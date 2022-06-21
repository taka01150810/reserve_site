<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->whereNull('canceled_date')
        ->groupBy('event_id')
        ->having('event_id', $event->id )//havingはgroupByの後に検索
        ->first();

        //予約可能な人数=最大定員-予約済みの人数(キャンセルを除く)
        if(!is_null($reservedPeople)){
            $resevablePeople = $event->max_people - $reservedPeople->number_of_people;
        } else {
            $resevablePeople = $event->max_people;
        } 

        return view('event-detail', compact('event', 'resevablePeople'));
    }
}
