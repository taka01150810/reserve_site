<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl mx-auto py-4">
                    <x-jet-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="get" action="{{ route('events.edit', ['event' => $event->id]) }}">
                        
                        <div>
                            <x-jet-label for="event_name" value="イベント名" />
                            {{ $event->name }}
                        </div>
                        <div>
                            <x-jet-label for="information" value="イベント詳細" />
                            {{-- 
                                テキストエリア(改行の変換) 
                                e() ・・エスケープする(サニタイズ)
                                nl2br・・改行を<br />に変換
                                {!! !!} ・・<br>だけエスケープしない
                            --}}
                            {!! nl2br(e($event->information)) !!} 
                        </div>


                        <div class="md:flex justify-between">
                            <div class="mt-4">
                                <x-jet-label for="event_date" value="イベント日付" />
                                {{ $event->eventDate }}
                            </div>
                            <div class="mt-4">
                                <x-jet-label for="start_time" value="開始時間" />
                                {{-- ここはただの修正 --}}
                                {{ $event->startTime }}
                            </div>
                            <div class="mt-4">
                                <x-jet-label for="end_time" value="終了時間" />
                                {{ $event->endTime }}
                            </div>
                        </div>

                        <div class="md:flex justify-between items-end">
                            <div class="mt-4">
                                <x-jet-label for="max_people" value="定員数" />
                                {{ $event->max_people }}
                            </div>
                            <div class="mt-4">
                                <x-jet-label for="reserved_people" value="予約人数" />
                                <select name="reserved_people">
                                @for($i = 1; $i <= $resevablePeople; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            </div>
                            {{-- 結果 https://gyazo.com/9c0e4b2dc2a9f253b8fd4c7fb7bb0cfd --}}
                            <x-jet-button class="ml-4">
                             予約する
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
