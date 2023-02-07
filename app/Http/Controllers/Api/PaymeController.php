<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrdersModel;
use App\Models\PayTransModel;
use Illuminate\Http\Request;

class PaymeController extends Controller
{
    public function index(){
        $payload = json_decode(file_get_contents('php://input'), true);
        // Authorize client
        $headers = getallheaders();
        $encoded_credentials = base64_encode("Paycom:W@E?xe9fv3RH?nbv28P2%zpMAx39GPi@NQW6");
        // $encoded_credentials = base64_encode("Paycom:GePoN@D417tA0pBqFbBtDkboEbv997BRHZfe");
        if (!$headers || // there is no headers
            !isset($headers['Authorization']) || // there is no Authorization
            !preg_match('/^\s*Basic\s+(\S+)\s*$/i', $headers['Authorization'], $matches) || // invalid Authorization value
            $matches[1] != $encoded_credentials // invalid credentials
        ) {
            $this->respond($this->error_authorization($payload));
        }

        // Execute appropriate method
        $response = method_exists($this, $payload['method'])
            ? $this->{$payload['method']}($payload)
            : $this->error_unknown_method($payload);

        // Respond with result
        $this->respond($response);
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
    public function CheckPerformTransaction($payload)
    {

        $order = OrdersModel::where('id', $payload['params']['account']['ticket_id'])->first();

        // return [$order];
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
                                "vat_percent" => 0,
                                'package_code'=>90605
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
                $order->save(false);

                $response = [
                    "id" => $payload['id'],
                    "result" => [
                        "create_time" => $create_time,
                        "transaction" => (string)$newTrans->id,
                        "receivers" => $receivers,
                        "state" => 1
                    ]
                ];
            } elseif ($order->status == 1 && $transaction_id == $saved_transaction_id->pay_id) { // handle existing transaction
                $response = [
                    "id" => $payload['id'],
                    "result" => [
                        "create_time" => $create_time,
                        "transaction" => (string)$saved_transaction_id->id,
                        "receivers" => $receivers,
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
        $billing =  OrdersModel::where('id',$order->pay_acount)->first();
        // BillingPayments::findOne($order->pay_acount);
        if ($billing->status == 1) { // handle new Perform request
            // Save perform time
            $billing->confirm_buy = $perform_time;


            $response = [
                "id" => $payload['id'],
                "result" => [
                    "transaction" => (string)$order->id,
                    "perform_time" => $billing->perform_time,
                    "state" => 2
                ]
            ];

            // Mark order as completed
//            $myUpdate = "UPDATE bron_tickets SET status=2 WHERE uzcard_id = ".$billing->id.";";
//            $txt = "Myticket. Vi mojete raspechatat Vash elektronniy bilet v personalnom kabinete po ssilke www.myticket.uz/profile  spravki po telefonu 1408787";
//            Yii::$app->db->createCommand($myUpdate)->execute();
//            $phone = $billing->phone;
//            Yii::$app->sms->send($txt, $phone);
//            $textAdmin = "Abonet kupil bilet .".$billing->TicketsInfoAdmin();
//            // Yii::$app->sms->send($textAdmin, '998331108585');
//            Yii::$app->sms->send($textAdmin, '998998008787');
            $billing->status = 2;
            $billing->bought_date = time();
            $billing->save(false);

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
    public function CreateTransactionData($addData)
    {

        $cTrans = new PayTransModel();
        $cTrans->pay_id = $addData['id'];
        $cTrans->pay_time = round(microtime(true) * 1000);
        $cTrans->pay_amount = $addData['amount'];
        $cTrans->pay_acount = $addData['account']['myticket'];
        $cTrans->stat = 1;
        $cTrans->reason = null;
        $cTrans->save(false);

        return $cTrans;
    }
    public function GetTransaction($payId)
    {

        $payInfo = PayTransModel::where('pay_acount',$payId)->first();

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
