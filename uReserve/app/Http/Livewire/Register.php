<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

//php artisan make:livewire register で作成
class Register extends Component
{
    public $name;
    
    public $email;
    
    public $password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ];

    //リアルタイムバリデーション(入力しながらエラーメッセージが表示される)
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

    }

    public function render()
    {
        return view('livewire.register');
    }
}
