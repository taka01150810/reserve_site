<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;//クエリビルダ
use Carbon\Carbon;

class EventService
{
    public static function checkEventDuplication($eventDate,$startTime,$endTime)
     {
        /*
        同じ時間帯に複数のイベントは作成できない

        新規の開始時間 < 登録済の終了時間 AND
        新規の終了時間 > 登録済の開始時間
        を満たす場合、重複している
        */
        $check = DB::table('events')
        ->whereDate('start_date', $eventDate)//日にち
        ->whereTime('end_date' ,'>',$startTime)
        ->whereTime('start_date', '<', $endTime)
        ->exists();//存在確認

        return $check;
     }

     public static function joinDateAndTime($date, $time)
     {
        /*
        formはevent_date,start_time,end_time 
        modelはstart_date,end_date
        formから渡ってくるデータをくっつけてからDB保存
        */
        $join = $date . " " . $time;
        $dateTime = Carbon::createFromFormat(
            'Y-m-d H:i', $join
        );
        return $dateTime;
     }

   /*
   既にイベントが存在しているので、
   重複しているのが1件なら問題なく、1件より多ければエラー
   */
     public static function countEventDuplication($eventDate, $startTime, $endTime)
      {
         return DB::table('events')
         ->whereDate('start_date', $eventDate)
         ->whereTime('end_date' ,'>',$startTime)
         ->whereTime('start_date', '<', $endTime)
         ->count();
      }

      //サービスの切り離し
      public static function getWeekEvents($startDate, $endDate){
         $reservedPeople = DB::table('reservations')
         ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
         ->whereNull('canceled_date')
         ->groupBy('event_id');
   
         return DB::table('events')
         ->leftJoinSub($reservedPeople, 'reservedPeople',
         function($join){
             $join->on('events.id', '=', 'reservedPeople.event_id');
         })
         //whereBetween ... カラムの値が2つの値の間にある条件を迎える
         ->whereBetween('start_date', [$startDate, $endDate])
         ->orderBy('start_date', 'desc')
         ->get();
      }
}