<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\DB;//クエリビルダ
use Carbon\Carbon;
use App\Services\EventService;

//php artisan make:model Event -a で作成
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $today = Carbon::today();
        
        //クエリビルダ
        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->groupBy('event_id');
        // dd($reservedPeople);
        /* 結果
          +columns: array:2 [▼
            0 => "event_id"
            1 => Illuminate\Database\Query\Expression {#1491 ▼
            #value: "sum(number_of_people) as number_of_people"
            }
        ]
        */

        $events = DB::table('events')
        ->leftJoinSub($reservedPeople, 'reservedPeople',
        function($join){
            $join->on('events.id', '=', 'reservedPeople.event_id');
        })
        ->whereDate('start_date', '>=' , $today)
        ->orderBy('start_date', 'asc')//開始日時順
        ->paginate(10);//10件ずつ

        return view('manager.events.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('manager.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $check = EventService::checkEventDuplication($request['event_date'],$request['start_time'],$request['end_time']);

        if($check){
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            return view('manager.events.create');
        }

        $startDate = EventService::joinDateAndTime($request['event_date'], $request['start_time']);
        $endDate = EventService::joinDateAndTime($request['event_date'], $request['end_time']);


        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible'],
        ]);

        session()->flash('status', '登録できました');
        return to_route('events.index');//名前付きルート
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
        $event = Event::findOrFail($event->id);

        $users = $event->users;
        //dd($event, $users); 
        /* 結果
        #relations: array:1 [▼
            "users" => Illuminate\Database\Eloquent\Collection {#1545 ▼
            #items: array:2 [▼
                ユーザー情報を取得できている
                0 => App\Models\User {#1543 ▶}
                1 => App\Models\User {#1556 ▶}
            ]
            #escapeWhenCastingToString: false
            }
        ]
        */

        $reservations = []; // 連想配列を作成

        foreach($users as $user){
            $reservedInfo = [
                'name' => $user->name,
                'number_of_people' => $user->pivot->number_of_people,
                'canceled_date' => $user->pivot->canceled_date,
            ];
            array_push($reservations, $reservedInfo);//連想配列に追加
        }
        //dd($reservations);
        /* 結果
        ^ array:2 [▼
        0 => array:3 [▼
            "name" => "admin"
            "number_of_people" => 5
            "canceled_date" => null
        ]
        1 => array:3 [▼
            "name" => "manager"
            "number_of_people" => 3
            "canceled_date" => null
        ]
        ]
        */

        $eventDate = $event->eventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;
        // dd($eventDate, $startTime, $endTime);
        /* 結果
        ^ "2022年06月16日"
        ^ "12時00分"
        ^ "13時00分"
        */
        
        return view('manager.events.show',
        compact('event','users','reservations','eventDate','startTime','endTime'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
        $event = Event::findOrFail($event->id);

        $eventDate = $event->editEventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;
        
        return view('manager.events.edit',
        compact('event', 'eventDate', 'startTime', 'endTime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //
        $check = EventService::countEventDuplication($request['event_date'],$request['start_time'],$request['end_time']);

        if($check > 1){
            $event = Event::findOrFail($event->id);
            $eventDate = $event->editEventDate;
            $startTime = $event->startTime;
            $endTime = $event->endTime;
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            return view('manager.events.edit', compact('event', 'eventDate', 'startTime', 'endTime'));
        }

        $startDate = EventService::joinDateAndTime($request['event_date'], $request['start_time']);
        $endDate = EventService::joinDateAndTime($request['event_date'], $request['end_time']);

        $event = Event::findOrFail($event->id);

        $event->name = $request['event_name'];
        $event->information = $request['information'];
        $event->start_date = $startDate;
        $event->end_date = $endDate;
        $event->max_people = $request['max_people'];
        $event->is_visible = $request['is_visible'];
        $event->save();

        session()->flash('status', '更新しました');
        return to_route('events.index');
    }

    public function past()
    {
        $today = Carbon::today();
    
        $reservedPeople = DB::table('reservations')
        ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
        ->groupBy('event_id');

        $events = DB::table('events')
        ->leftJoinSub($reservedPeople, 'reservedPeople',
        function($join){
            $join->on('events.id', '=', 'reservedPeople.event_id');
        })
        ->whereDate('start_date', '<', $today )
        ->orderBy('start_date', 'desc')
        ->paginate(10);
        
        return view('manager.events.past', compact('events'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
