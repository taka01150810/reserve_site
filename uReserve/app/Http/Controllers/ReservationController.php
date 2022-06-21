<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

//php artisan make:controller ReservationController で生成
class ReservationController extends Controller
{
    //
    public function dashboard()
    {
        return view('dashboard');
    }

    public function detail($id)
    {
        $event = Event::findOrFail($id);
        return view('event-detail', compact('event'));
    }
}
