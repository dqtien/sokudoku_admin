<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{

    public function __construct()
    {
    }

    protected function index(){
        return view('welcome');
    }
    
}