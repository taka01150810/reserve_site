{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
{{-- php artisan make:livewire counter で作成--}}
<div style="text-align: center">
    {{-- wire:click=“メソッド名”で実行 --}}
    <button wire:click="increment">+</button>
    {{-- Counterクラス内プロパティを表示 --}}
    <h1>{{ $count }}</h1>

    <div class="mb-8"></div>
    <input type="text" wire:model="name"><br>
    こんにちは、{{ $name }}さん
    {{-- 結果 https://gyazo.com/82016b6970069b31bb2d4c024eb2d620 --}}

</div>
