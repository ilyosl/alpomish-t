<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index() {
        return view('admin.news.index');
    }
}
