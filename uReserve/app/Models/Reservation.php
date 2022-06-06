<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// php artisan make:model Reservation -m で作成
class Reservation extends Model
{
    use HasFactory;

    //まとめて登録できるように設定
    protected $fillable = [
        'user_id',
        'event_id',
        'number_of_people',
    ];

}
