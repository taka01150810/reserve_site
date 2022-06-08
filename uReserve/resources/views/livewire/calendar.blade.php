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
        <x-day />
        <x-day />
        <x-day />
        <x-day />
        <x-day />
        <x-day />
        <x-day />
    </div>
    @foreach($events as $event)
    {{ $event->start_date }}<br>
    @endforeach
</div>
