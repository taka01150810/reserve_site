<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        //結果 https://gyazo.com/341f03cc27b3c957e4d57b56ab2e3a03
    }
}
