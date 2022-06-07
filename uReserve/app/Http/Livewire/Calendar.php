<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;

//php artisan make:livewire Calendar で作成
class Calendar extends Component
{
    public $currentDate;

    public $day;

    public $currentWeek;

    public function mount()
    {
        $this->currentDate = Carbon::today();
        $this->currentWeek = [];
        //7日分の情報を取得
        for($i = 0; $i < 7; $i++ )
        {
            $this->day = Carbon::today()->addDays($i)->format('m月d日');
            array_push($this->currentWeek, $this->day);
        }
        // dd($this->currentWeek);
        /* 結果
        array:7 [▼
            0 => "06月07日"
            1 => "06月08日"
            2 => "06月09日"
            3 => "06月10日"
            4 => "06月11日"
            5 => "06月12日"
            6 => "06月13日"
        ]
        */
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
