<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */

//php artisan make:model Event -a で作成
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //今月分のダミーデータを作成
        $dummyDate = $this->faker->dateTimeThisMonth;

        return [
            'name' => $this->faker->name,
            'information' => $this->faker->realText,
            'max_people' => $this->faker->numberBetween(1,20),
            'start_date' => $dummyDate->format('Y-m-d H:i:s'),//開始日時
            'end_date' => $dummyDate->modify('+1hour')->format('Y-m-d H:i:s'),//終了日時
            'is_visible' => $this->faker->boolean
        ];
    }
}
