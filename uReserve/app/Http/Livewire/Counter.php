<?php
//php artisan make:livewire counter で作成
namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    
    public $name = ''; 

    public function mount()//render描画前に実行(constructorのように)
    {
        $this->name = '初期値です。';//初期値が 初期値です。
    }

    public function updated()
    {
        $this->name = '更新値です。';
        // 更新するごとに
        //結果 こんにちは、更新値です。さん
    }

    public function mouseOver()
    {
        $this->name = 'mouseover';
    }

    public function increment()
    {
        $this->count++;
    }
    
    public function render()
    {
        return view('livewire.counter');
    }
}
