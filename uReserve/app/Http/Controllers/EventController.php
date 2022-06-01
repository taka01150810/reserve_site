<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\DB;//クエリビルダ
use Carbon\Carbon;

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
        $events = DB::table('events')
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
        /*
        同じ時間帯に複数のイベントは作成できない

        新規の開始時間 < 登録済の終了時間 AND
        新規の終了時間 > 登録済の開始時間
        を満たす場合、重複している
        */
        $check = DB::table('events')
        ->whereDate('start_date', $request['event_date'])//日にち
        ->whereTime('end_date' ,'>',$request['start_time'])
        ->whereTime('start_date', '<', $request['end_time'])
        ->exists();//存在確認
        
        //dd($check);
        //結果 重複してたらfalse。重複してなかったらtrue

        if($check){
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            return view('manager.events.create');
        }

        /*
        formはevent_date,start_time,end_time 
        modelはstart_date,end_date
        formから渡ってくるデータをくっつけてからDB保存
        */
        $start = $request['event_date'] . " " . $request['start_time'];
        $startDate = Carbon::createFromFormat(
            'Y-m-d H:i', $start
        );
        $end = $request['event_date'] . " " . $request['end_time'];
        $endDate = Carbon::createFromFormat(
            'Y-m-d H:i', $end
        );

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
