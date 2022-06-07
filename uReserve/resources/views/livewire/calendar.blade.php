<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    {{-- php artisan make:livewire Calendar で作成 --}}
    カレンダー
    <input id="calendar" class="block mt-1 w-full" type="text" name="calendar"
    {{-- datepickerを変更したら値も変える --}}
    value="{{ $currentDate }}" wire:change="getDate($event.target.value)"/>
    {{ $currentDate }}
    <div class="flex">
        @for($day = 0; $day < 7; $day++)
        {{ $currentWeek[$day] }}
        @endfor
        {{-- 結果
            2022-06-09(指定した日付)
            06月09日 06月10日 06月11日 06月12日 06月13日 06月14日 06月15日(指定した日付+7日分)
        --}}
    </div>
</div>
