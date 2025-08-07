<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display users
        return view('admin.users.index');
    }
    public function create()
    {
        // Logic to show the form for creating a new user
        return view('admin.users.create');
    }

}
