<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    {{-- php artisan make:livewire register で作成--}}
    <form wire:submit.prevent="register">{{-- prevent ... ページ読み込みを防ぐ --}}
        <label for="name">名前</label>
        <input id="name" type="text" wire:model="name"><br>
        <label for="email">メールアドレス</label>
        <input id="email" type="email" wire:model="email"><br>
        <label for="password">パスワード</label>
        <input id="password" type="password" wire:model="password">
        <button>登録する</button>
    </form>
</div>
