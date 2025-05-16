<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index()
    {
        return view('shop.index');
    }

    public function products()
    {
        return view('shop.products');
    }

}
