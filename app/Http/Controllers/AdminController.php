<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;

use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function someControllerMethod()
    {
        if (Gate::allows('admin-access')) {
           
            return view('admin.dashboard');
        } else {
            abort(403); 
        }
    }
}
