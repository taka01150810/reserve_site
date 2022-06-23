<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;//クエリビルダ
use Carbon\Carbon;

class MyPageService
{
    public static function reservedEvent($events, $string)
    {
        $reservedEvents = [];
        if($string === 'fromToday')
        {
        }

        if($string === 'past')
        {
        }

        return $reservedEvents;
    }
}