<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeSetting extends Controller
{
    public function index(){
        return view('adminDashboard.user.themeSetting');
    }
}
