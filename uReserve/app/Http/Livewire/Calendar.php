<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use App\Services\EventService;

//php artisan make:livewire Calendar で作成
class Calendar extends Component
{
    public $currentDate;

    public $day;

    public $checkDay;

    public $dayOfWeek;

    public $currentWeek;

    public $sevenDaysLater;

    public $events;
    
    public function mount()
    {
        /*
        Carbonはミュータブル(可変)とイミュータブル(不変)がある
        デフォルトはミュータブル。
        対策1 ->copy()を使ってコピーしてから処理する。
        対策2 イミュータブル版を使う。
        今回はイミュータブル版を使う
        */
        $this->currentDate = CarbonImmutable::today();
        $this->sevenDaysLater = $this->currentDate->addDays(7);
        $this->currentWeek = [];

        $this->events = EventService::getWeekEvents(
            $this->currentDate->format('Y-m-d'),
            $this->sevenDaysLater->format('Y-m-d'),
        );

        //7日分の情報を取得
        for($i = 0; $i < 7; $i++ )
        {
            $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');
            $this->checkDay = CarbonImmutable::today()->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::today()->addDays($i)->dayName; 
            array_push($this->currentWeek,[// 連想配列に変更
                'day' => $this->day,//カレンダー表示用(○月△日)
                'checkDay' => $this->checkDay, //判定用(○○○○-△△-□□)
                'dayOfWeek' => $this->dayOfWeek //曜日
            ]
            );
        }
        //dd($this->currentWeek);
        /* 結果
        ^ array:7 [▼
        0 => array:3 [▼
            "day" => "06月08日"
            "checkDay" => "2022-06-08"
            "dayOfWeek" => "水曜日"
        ]
        1 => array:3 [▼
            "day" => "06月09日"
            "checkDay" => "2022-06-09"
            "dayOfWeek" => "木曜日"
        ]
        2 => array:3 [▼
            "day" => "06月10日"
            "checkDay" => "2022-06-10"
            "dayOfWeek" => "金曜日"
        ]
        3 => array:3 [▼
            "day" => "06月11日"
            "checkDay" => "2022-06-11"
            "dayOfWeek" => "土曜日"
        ]
        4 => array:3 [▶]
        5 => array:3 [▶]
        6 => array:3 [▶]
        ]
        */
    }

    //datepickerを変更したら値も変える
    public function getDate($date)
    {
        $this->currentDate = $date; //文字列
        $this->currentWeek = [];
        $this->sevenDaysLater = CarbonImmutable::parse($this->currentDate)->addDays(7);

        $this->events = EventService::getWeekEvents(
            $this->currentDate,
            $this->sevenDaysLater->format('Y-m-d'),
        );

        for($i = 0; $i < 7; $i++ )
        {
            $this->day = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('m月d日');
            $this->checkDay = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::parse($this->currentDate)->addDays($i)->dayName;
            array_push($this->currentWeek,[// 連想配列に変更
                'day' => $this->day,//カレンダー表示用(○月△日)
                'checkDay' => $this->checkDay, //判定用(○○○○-△△-□□)
                'dayOfWeek' => $this->dayOfWeek //曜日
            ]);
        }
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
