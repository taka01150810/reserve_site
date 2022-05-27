<?php

namespace App\Http\Livewire;

use Livewire\Component;

//php artisan make:livewire register で作成
class Register extends Component
{
    public function register()
    {
        dd('登録テスト');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
