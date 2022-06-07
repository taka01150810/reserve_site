<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    {{-- php artisan make:livewire Calendar で作成 --}}
    カレンダー
    <x-jet-input id="calendar" class="block mt-1 w-full" type="text" name="calendar"/>
    {{ $currentDate }}
    <div class="flex">
        @for($day = 0; $day < 7; $day++)
        {{ $currentWeek[$day] }}
        @endfor
        {{-- 結果
            2022-06-07 00:00:00
            06月07日 06月08日 06月09日 06月10日 06月11日 06月12日 06月13日
        --}}
    </div>
</div>
