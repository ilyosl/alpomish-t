<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getCostTickets($tickets){
        $cost = DB::table('event_place')->selectRaw('sum(price) as cost')
            ->whereIn('id', $tickets)
            ->first();

        return $cost->cost;
    }
}
