<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BasketRequest;
use App\Models\BasketModel;

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
        $addTicket = BasketModel::create(['ticket_id'=>$ticketId['ticket_id'], 'user_id'=>auth()->user()->id]);
        return $addTicket;
    }
    public function destroy(BasketRequest $request){
        $ticketId = $request->validated();

        try {
            BasketModel::where('ticket_id', $ticketId['ticket_id'])->delete();
            return ['success'=>1];
        }catch (\Exception $e){
            abort(402, $e);
        }
    }
}
