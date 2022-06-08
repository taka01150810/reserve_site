<x-calendar-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベントカレンダー
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="event-calendar border border-red-400 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    @livewire('calendar')
                    {{--  結果
                        https://i.gyazo.com/c50dc8ce835b91ae1bdc962b922e6a2c.png 
                    --}}
            </div>
        </div>
    </div>
</x-calendar-layout>