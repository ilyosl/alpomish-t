<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationKatokServiceRequest;
use App\Models\ApplicationForKatokServiceModel;
use Illuminate\Http\Request;

class ApplicationForKatokServiceController extends Controller
{
    public function store(ApplicationKatokServiceRequest $request){
        $data= $request->validated();

        $app = ApplicationForKatokServiceModel::create($data);

        return $app;
    }
}
