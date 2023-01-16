<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RinkInfoController extends Controller
{
    public function index(){
        return view('rinkInfo.index');
    }
}
