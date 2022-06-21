<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//php artisan make:controller ReservationController で生成
class ReservationController extends Controller
{
    //
    public function dashboard()
    {
        return view('dashboard');
    }
}
