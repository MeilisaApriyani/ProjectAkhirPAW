<?php

namespace App\Http\Controllers;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user'); 
    }
}
