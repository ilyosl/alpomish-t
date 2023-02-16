<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BasketRequest;
use App\Models\BasketModel;
use App\Models\EventPlaceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BasketController extends Controller
{
    public function index(){
        $tickets = BasketModel::with('tickets')->where('user_id', auth()->user()->id)->get();

        return $tickets;
    }
    public function show(BasketRequest $request){

        $ticketId = BasketModel::where('ticket_id', $request->validated())->first();
        if($ticketId) {
            return ['exists' => 1];
        }else{
            return ['exists' => 0];
        }
    }
    public function store(BasketRequest $request){
        $ticketId = $request->validated();
        $getTicket = EventPlaceModel::query()->where('id', $ticketId['ticket_id'])->first();
        if($getTicket) {
            $addTicket = BasketModel::create(['ticket_id' => $ticketId['ticket_id'], 'user_id' => auth()->user()->id]);
            $getTicket->status = 1;
            $getTicket->save();
            return $addTicket;
        }
    }
    public function destroy(BasketRequest $request){
        $ticketId = $request->validated();
        try {
            $ticket = BasketModel::where('ticket_id', $ticketId['ticket_id'])->first();
            if($ticket) {
                $ticket->delete();
                return ['success' => 1];
            }else{
                return ['success'=> 0];
            }
        }catch (\Exception $e){
            abort(402, $e);
        }
    }
    public function deleteAll(Request $request){
        $tickets = $request->post('tickets');
        try {
            DB::table('basket_tickets')->whereIn('ticket_id', $tickets)->delete();
            return ['success'=>1];
        }catch (\Exception $e){
            abort(400,  $e);
        }

    }
}
