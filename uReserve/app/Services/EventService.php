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
}