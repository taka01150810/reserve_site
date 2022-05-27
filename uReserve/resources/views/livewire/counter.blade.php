{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
{{-- php artisan make:livewire counter で作成--}}
<div style="text-align: center">
    {{-- wire:click=“メソッド名”で実行 --}}
    <button wire:click="increment">+</button>
    {{-- Counterクラス内プロパティを表示 --}}
    <h1>{{ $count }}</h1>
    {{-- 結果 https://i.gyazo.com/456aeb863dd8c810cc37ab0bc9d2ddc9.png --}}

    <div class="mb-8"></div>
    <input type="text" wire:model="name"><br>
    こんにちは、{{ $name }}さん
    {{-- 結果 https://gyazo.com/82016b6970069b31bb2d4c024eb2d620 --}}

    <div class="mb-8"></div>
    <input type="text" wire:model.debounce.2000ms="name"><br>
    {{-- ms ... 待って通信 1000ms = 1秒 --}}
    こんにちは、{{ $name }}さん
    {{-- 2秒待って表示される --}}

    <div class="mb-8"></div>
    <input type="text" wire:model.lazy="name"><br>
    {{-- lazy ... フォーカスが外れたタイミングで通信(JSのchangeイベント) --}}
    こんにちは、{{ $name }}さん

    <div class="mb-8"></div>
    <input type="text" wire:model.defer="name"><br>
    {{-- defer ... submitボタンなどを押したタイミングで通信 --}}
    こんにちは、{{ $name }}さん

</div>
