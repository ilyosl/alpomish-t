<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderEventModel;
use App\Models\OrdersModel;
use App\Models\PayTransModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymeController extends Controller
{
    public function index(){
        $payload = json_decode(file_get_contents('php://input'), true);
        // Authorize client
        $headers = getallheaders();

        $encoded_credentials = base64_encode("Paycom:8QkhGFXs#JgK7KbbwC@0gsVYpYIAIUXDQKh1");

        if (!$headers || // there is no headers
            !isset($headers['Authorization']) || // there is no Authorization
            !preg_match('/^\s*Basic\s+(\S+)\s*$/i', $headers['Authorization'], $matches) || // invalid Authorization value
            $matches[1] != $encoded_credentials // invalid credentials
        ) {

            return $this->respond($this->error_authorization($payload));
        }

        // Execute appropriate method
        $response = method_exists($this, $payload['method'])
            ? $this->{$payload['method']}($payload)
            : $this->error_unknown_method($payload);

        // Respond with result
       return $this->respond($response);
    }
    public function respond($response)
    {
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=UTF-8');
        }

        return json_encode($response);

    }
    public function amount_to_coin($amount)
    {
        return 100 * number_format($amount, 0, '.', '');
    }

    public function current_timestamp()
    {
        return round(microtime(true) * 1000);
    }
    public function GetStatement($payload){
        $from =  $payload['params']['from'];
        $to =  $payload['params']['to'];

        $transactions = DB::table('pay_trans')

            ->leftJoin('orders', 'orders.id', '=', 'pay_trans.pay_account')
            ->whereBetween('pay_trans.pay_time',[$from, $to])->get();

        $resTransactions = [];
        foreach ($transactions as $trans){
            $resTransactions[] =[
                "id"=>$trans->pay_id,
                "time"=>$trans->pay_time,
                "amount"=>$trans->summ,
                "account"=>["ticket_id"=>(string)$trans->pay_account],
                "create_time"=>$trans->create_time,
                "perform_time"=>$trans->perform_time,
                "cancel_time"=>$trans->cancel_time,
                "transaction"=>(string)$trans->id,
                "state"=>$trans->stat,
                "reason"=>$trans->reason
            ];
        }

        $response = [
            "transactions" => $resTransactions
        ];

        return $response;
    }
    public function CheckPerformTransaction($payload)
    {
        $ticket_id = $payload['params']['account']['ticket_id'] ?? 0;
        $order = OrdersModel::where('id', $ticket_id)->first();

//         return [$order];
        if(empty($order))
            return $this->error_order_id($payload);
        $amount = $this->amount_to_coin($order->summ);

        if ($amount != $payload['params']['amount']) {
            $response = $this->error_amount($payload);
        } else {
            $response = [
                'id' => $payload['id'],
                'result' => [
                    'allow' => true,
                    "detail" => [
                        "items" => [
                            [
                                "title" => "Билет",
                                "price" => $amount,
                                "count" => $order->count_tickets,
                                "code" => "11001004001000000",
                                "vat_percent" => 12,
                                'package_code'=>"90605"
                            ]
                        ]
                    ]
                ],
                'error' => null
            ];
        }

        return $response;
    }
    public function CreateTransaction($payload)
    {
        $order = OrdersModel::where('id', $payload['params']['account']['ticket_id'])->first();
        if(empty($order))
            return $this->error_order_id($payload);
        $amount = $this->amount_to_coin($order->summ);

        if ($amount != $payload['params']['amount']) {
            $response = $this->error_amount($payload);
        } else {
            $create_time = $payload['params']['time'];//$this->current_timestamp();
            $transaction_id = $payload['params']['id'];
            $saved_transaction_id = $this->GetByIdTrans($transaction_id);
            if ($order->status == 1 && empty($saved_transaction_id)) { // handle new transaction with the same order
                return $this->error_has_another_transaction($payload);
            }
            $receivers = [];
            if ($order->status == 0) { // handle new transaction
                // Save time and transaction id
                $newTrans = $this->CreateTransactionData($payload['params']);
                $order->create_time = $create_time;

                // Change order's status to Processing
                $order->status = 1;
                $order->save();

                $response = [
                    "id" => $payload['id'],
                    "result" => [
                        "create_time" => $create_time,
                        "transaction" => (string)$newTrans->id,
//                        "receivers" => $receivers,
                        "state" => 1
                    ]
                ];
            } elseif ($order->status == 1 && $transaction_id == $saved_transaction_id->pay_id) { // handle existing transaction
                $response = [
                    "id" => $payload['id'],
                    "result" => [
                        "create_time" => $create_time,
                        "transaction" => (string)$saved_transaction_id->id,
//                        "receivers" => $receivers,
                        "state" => 1
                    ]
                ];
            } else {
                $response = $this->error_unknown($payload);
            }
        }

        return $response;
    }
    public function PerformTransaction($payload)
    {
        $perform_time = $this->current_timestamp();
        $order = $this->GetByIdTrans($payload['params']['id']);
        $billing =  OrdersModel::where('id',$order->pay_account)->first();

        if ($billing->status == 1) {

            // handle new Perform request
            // Save perform time
            $billing->perform_time = $perform_time;

            $response = [
                "id" => $payload['id'],
                "result" => [
                    "transaction" => (string)$order->id,
                    "perform_time" => $billing->perform_time,
                    "state" => 2
                ]
            ];
            $orderEvents = DB::table('order_event')->select('event_place_id')
                ->where(['order_id'=> $billing->id])->get();
            $tickets = [];
            foreach ($orderEvents as $orderEvent){
                $tickets[]=$orderEvent->event_place_id;
            }
            DB::table('event_place')
                ->whereIn('id', $tickets)
                ->update(['status'=>2]);

            $billing->status = 2;
            $billing->confirm_buy = date('Y-m-d H:i:s',  time());
            $billing->save();

        } elseif ($billing->status == 2) { // handle existing Perform request
            $response = [
                "id" => $payload['id'],
                "result" => [
                    "transaction" => (string)$order->id,
                    "perform_time" => $billing->perform_time,
                    "state" => 2
                ]
            ];
        } elseif ($billing->status == -2) { // handle cancelled order
            $response = $this->error_cancelled_transaction($payload);
        } else {
            $response = $this->error_unknown($payload);
        }

        return $response;
    }
    public function CheckTransaction($payload)
    {
        $transaction_id = $payload['params']['id'];
        // $order = $this->get_order_by_transaction($payload);

        // Get transaction id from the order
        $saved_transaction_id = $this->GetByIdTrans($transaction_id);

        $order =OrdersModel::where('id',$saved_transaction_id->pay_account)->first();

        $response = [
            "id" => $payload['id'],
            "result" => [
                "create_time" => $order->create_time,//$this->get_create_time($order),
                "perform_time" => 0,
                "cancel_time" => 0,
                "transaction" => (string)$saved_transaction_id->id,
                "state" => null,
                "reason" => null
            ],
            "error" => null
        ];

        if ($transaction_id == $saved_transaction_id->pay_id) {
            switch ($order->status) {
                case '1':
                    $response['result']['state'] = 1;
                    break;

                case '2':
                    $response['result']['state'] = 2;
                    $response['result']['perform_time'] = $order->perform_time;
                    break;

                case '-2':
                    $response['result']['state'] = -1;
                    $response['result']['reason'] = 3;
                    $response['result']['cancel_time'] = $order->cancel_time;//$this->get_cancel_time($order);
                    break;

                case '-3':
                    $response['result']['state'] = -2;
                    $response['result']['reason'] = 5;
                    $response['result']['perform_time'] = $order->perform_time; // $this->get_perform_time($order);
                    $response['result']['cancel_time'] = $order->cancel_time;//$this->get_cancel_time($order);
                    break;

                default:
                    $response = $this->error_transaction($payload);
                    break;
            }
        } else {
            $response = $this->error_transaction($payload);
        }

        return $response;
    }
    public function CancelTransaction($payload)
    {
        // $order = $this->get_order_by_transaction($payload);

        $transaction_id = $payload['params']['id'];
        $saved_transaction_id = $this->GetByIdTrans($transaction_id);

        $order = OrdersModel::where('id', $saved_transaction_id->pay_account)->first();

        if ($transaction_id == $saved_transaction_id->pay_id) {

            $cancel_time = $this->current_timestamp();

            $response = [
                "id" => $payload['id'],
                "result" => [
                    "transaction" => (string) $saved_transaction_id->id,
                    "cancel_time" => $cancel_time,
                    "state" => null
                ]
            ];

            switch ($order->status) {
                case '1':
                    // add_post_meta($order->get_id(), '_payme_cancel_time', $cancel_time, true); // Save cancel time
                    $order->cancel_time = $cancel_time;
                    $order->status = -2;//('cancelled'); // Change status to Cancelled
                    $order->save();
                    $response['result']['state'] = -1;
                    break;

                case '2':
                    // add_post_meta($order->get_id(), '_payme_cancel_time', $cancel_time, true); // Save cancel time
                    $order->cancel_time = $cancel_time;
                    $order->status = -3;//('refunded'); // Change status to Refunded
                    $order->save();
                    $response['result']['state'] = -2;
                    break;

                case '-2':
                    $response['result']['cancel_time'] = $order->cancel_time;// $this->get_cancel_time($order);
                    $response['result']['state'] = -1;
                    break;

                case '-3':
                    $response['result']['cancel_time'] = $order->cancel_time;//$this->get_cancel_time($order);
                    $response['result']['state'] = -2;
                    break;

                default:
                    $response = $this->error_cancel($payload);
                    break;
            }
//            DB::table('order_event')->where(['order_id'=>$order->id])->delete();
        } else {
            $response = $this->error_transaction($payload);
        }

        return $response;
    }
    public function CreateTransactionData($addData)
    {

        $cTrans = new PayTransModel;
        $cTrans->pay_id = $addData['id'];
        $cTrans->pay_time = round(microtime(true) * 1000);
        $cTrans->pay_amount = $addData['amount'];
        $cTrans->pay_account = $addData['account']['ticket_id'];
        $cTrans->stat = 1;
        $cTrans->reason = null;
        $cTrans->save();

        return $cTrans;
    }
    public function GetTransaction($payId)
    {
        $payInfo = PayTransModel::where('pay_account',$payId)->first();
        return $payInfo;
    }

    public function GetByIdTrans($payId)
    {

        $payInfo =  PayTransModel::where('pay_id',$payId)->first();
        return $payInfo;
    }
    public function error_transaction($payload)
    {
        $response = [
            "error" => [
                "code" => -31003,
                "message" => [
                    "ru" => "Неверный номер транзакции",
                    "uz" => "Tranzaksiya raqami xato",
                    "en" => "Transaction number is wrong"
                ],
                "data" => "id"
            ],
            "result" => null,
            "id" => $payload['id']
        ];

        return $response;
    }
    private function error_order_id($payload)
    {
        $response = [
            "error" => [
                "code" => -31099,
                "message" => [
                    "ru" => "Номер заказа не найден",
                    "uz" => "Buyurtma raqami topilmadi",
                    "en" => "Order number cannot be found"
                ],
                "data" => "order"
            ],
            "result" => null,
            "id" => $payload['id']
        ];

        return $response;
    }

    public function error_has_another_transaction($payload)
    {
        $response = [
            "error" => [
                "code" => -31099,
                "message" => [
                    "ru" => "Оплата запущена. Повторная оплата - невозможна",
                    "uz" => "Bu buyurtma uchun boshqa aktiv tranzaksiya mavjud",
                    "en" => "Other transaction for this order is in progress"
                ],
                "data" => "order"
            ],
            "result" => null,
            "id" => $payload['id']
        ];

        return $response;
    }
    public function error_amount($payload)
    {
        $response = [
            "error" => [
                "code" => -31001,
                "message" => [
                    "ru" => "Неверная сумма заказа",
                    "uz" => "Buyurtma summasi xato",
                    "en" => "Order amount is incorrect"
                ],
                "data" => "amount"
            ],
            "result" => null,
            "id" => $payload['id']
        ];

        return $response;
    }
    public function error_unknown($payload)
    {
        $response = [
            "error" => [
                "code" => -31008,
                "message" => [
                    "ru" => "Неизвестная ошибка",
                    "uz" => "Noma`lum xatolik",
                    "en" => "Unknown error"
                ],
                "data" => null
            ],
            "result" => null,
            "id" => $payload['id']
        ];

        return $response;
    }
    public function error_unknown_method($payload)
    {
        $response = [
            "error" => [
                "code" => -32601,
                "message" => [
                    "ru" => "Неизвестный метод",
                    "uz" => "Noma`lum metod",
                    "en" => "Unknown method"
                ],
                "data" => $payload['method']
            ],
            "result" => null,
            "id" => $payload['id']
        ];

        return $response;
    }
    public function error_cancelled_transaction($payload)
    {
        $response = [
            "error" => [
                "code" => -31008,
                "message" => [
                    "ru" => "Транзакция отменена или возвращена",
                    "uz" => "Tranzaksiya bekor qilingan yoki qaytarilgan",
                    "en" => "Transaction was cancelled or refunded"
                ],
                "data" => "order"
            ],
            "result" => null,
            "id" => $payload['id']
        ];

        return $response;
    }
    public function error_cancel($payload)
    {
        $response = [
            "error" => [
                "code" => -31007,
                "message" => [
                    "ru" => "Заказ выполнен. Отмена невозможна",
                    "uz" => "Buyurtma bajarilgan - uni bekor qilib bo`lmaydi",
                    "en" => "It is impossible to cancel. The order is completed"
                ],
                "data" => "order"
            ],
            "result" => null,
            "id" => $payload['id']
        ];

        return $response;
    }
    public function error_authorization($payload)
    {
        $response = [
            "error" =>
                [
                    "code" => -32504,
                    "message" => [
                        "ru" => "Ошибка авторизации",
                        "uz" => "Avtorizatsiyada xatolik",
                        "en" => "Error during authorization"
                    ],
                    "data" => null
                ],
            "result" => null,
            "id" => isset($payload['id'])?$payload['id']:0
        ];

        return $response;
    }
}
