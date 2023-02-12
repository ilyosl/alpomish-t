<?php

namespace App\Actions;

use App\Models\BlocksModel;

class BlocksPlace
{
    public function getPlace($block_name){
        $data = BlocksModel::query()->where('name_block',$block_name)->first();

        return $data;
    }
}
