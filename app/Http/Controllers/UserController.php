<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\url;


class UserController extends Controller
{

    public function index()
    {
        return view('miperfil');
    }

    
}
