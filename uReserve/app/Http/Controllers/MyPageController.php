<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Services\MyPageService;

class MyPageController extends Controller
{
    //
    public function index(){
        $user = User::findOrFail(Auth::id());
        $events = $user->events; // イベント一覧を取得
        // dd($events);
        //結果 https://gyazo.com/eb4047d2c0085905ef16a93795c6b75d
        $fromTodayEvents = MyPageService::reservedEvent($events, 'fromToday');
        $pastEvents = MyPageService::reservedEvent($events, 'past');
        // dd($fromTodayEvents, $pastEvents);
        //結果 https://gyazo.com/69fe46eff17865a0762a0911f2d22045
        return view('mypage/index', compact('fromTodayEvents', 'pastEvents'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        $reservation = Reservation::where('user_id', '=', Auth::id())
        ->where('event_id', '=', $id)
        ->first();
        // dd($reservation);
        return view('mypage/show', compact('event', 'reservation'));
    } 

}
