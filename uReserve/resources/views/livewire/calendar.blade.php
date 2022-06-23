<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    {{-- php artisan make:livewire Calendar で作成 --}}
    <div class="text-center text-sm">
        日付を選択してください。本日から最大30日先まで選択可能です。
    </div> 
    <input id="calendar" class="block mt-1 mb-2 mx-auto" type="text" name="calendar"
    {{-- datepickerを変更したら値も変える --}}
    value="{{ $currentDate }}" wire:change="getDate($event.target.value)"/>
    <div class="flex border border-green-400 mx-auto">
        <x-calendar-time />
        @for ($i = 0; $i < 7; $i++)
        <div class="w-32">
            <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['day'] }}</div>
            <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['dayOfWeek'] }}</div>
            <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['checkDay'] }}</div>
        @for($j = 0; $j < 21; $j++)
            {{-- １週間通じてイベントがない可能性 --}}
            @if($events->isNotEmpty())
                {{-- イベント開始時間(DB) = 対象時間(入力した日付+時間) --}}
                @if(!is_null($events->firstWhere('start_date', $currentWeek[$i]
                ['checkDay'] . " " . \Constant::EVENT_TIME[$j]) ))
<<<<<<< HEAD
                @php
                $eventId = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] 
                . " " . \Constant::EVENT_TIME[$j])->id;
                $eventName = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] 
                . " " . \Constant::EVENT_TIME[$j])->name;
                $eventInfo = $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] 
                . " " .\Constant::EVENT_TIME[$j]);
                $eventPeriod = \Carbon\Carbon::parse($eventInfo->start_date)
                ->diffInMinutes($eventInfo->end_date) / 30 - 1;//差分
                @endphp
                <a href="{{ route('events.detail', ['id' => $eventId ]) }}">
                    <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-blue-900">
                        {{ $eventName }}
                    </div>
                </a>
                @if( $eventPeriod > 0)
                    @for($k = 0; $k < $eventPeriod; $k++)
                    <div class="py-1 px-2 h-8 border border-gray-200 bg-blue-900"></div>
                    @endfor
                    @php
                    $j += $eventPeriod
                    @endphp
                @endif
                {{-- 結果
                https://gyazo.com/16269994063effa69b196ba8f7472ef7 --}}
                @else
                <div class="py-1 px-2 h-8 border border-gray-200"></div>
=======
                <div class="py-1 px-2 h-8 border border-gray-200 text-xs">
                    {{ $events->firstWhere('start_date', $currentWeek[$i]['checkDay'] 
                    . " " . \Constant::EVENT_TIME[$j])->name }}
                </div>
                @else
                <div class="py-1 px-2 h-8 border border-gray-200">falseです</div>
>>>>>>> d4efc05a43bed9f88866771412a401051cbaa5cf
                @endif
            @else
            <div class="py-1 px-2 h-8 border border-gray-200"></div>
            @endif
        @endfor
        </div>
        @endfor
    </div>
</div>
