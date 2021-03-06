<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    {{-- php artisan make:livewire register で作成--}}
    <form wire:submit.prevent="register">{{-- prevent ... ページ読み込みを防ぐ --}}
        <label for="name">名前</label>
        {{-- .lazyをつけることでサーバーの負担を軽くする --}}
        <input id="name" type="text" wire:model.lazy="name"><br>
        @error('name') <div class="text-red-500">{{ $message }} </div> @enderror
        <label for="email">メールアドレス</label>
        <input id="email" type="email" wire:model.lazy="email"><br>
        @error('email') <div class="text-red-500">{{ $message }} </div> @enderror 
        <label for="password">パスワード</label>
        <input id="password" type="password" wire:model.lazy="password">
        @error('password') <div class="text-red-500">{{ $message }} </div> @enderror
        <button>登録する</button>
    </form>
</div>
