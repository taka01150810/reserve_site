<?php

namespace App\Http\Livewire;

use Livewire\Component;

//php artisan make:livewire register で作成
class Register extends Component
{
    public $name;
    
    public $email;
    
    public $password;

    public function register()
    {
         dd($this);//$thisで$name,$email,$passwordの値を取得できる
         /* 結果
         ^ App\Http\Livewire\Register {#547 ▼
            +name: "Takatoshi Miyanaka"
            +email: "taka01150810@gmail.com"
            +password: "aaa"
            +id: "DmCCVBDHPlg0r7vd1kxm"
         */
    }

    public function render()
    {
        return view('livewire.register');
    }
}
