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

        $availableHour = $this->faker->numberBetween(10, 18); //10時～18時
        $minutes = [0, 30]; // 00分か 30分
        $mKey = array_rand($minutes); //ランダムにキーを取得
        $addHour = $this->faker->numberBetween(1, 3); //イベント時間 1時間～3時間

        //今月分のダミーデータを作成
        $dummyDate = $this->faker->dateTimeThisMonth;

        $startDate = $dummyDate->setTime($availableHour, $minutes[$mKey]);
        $clone = clone $startDate; //そのままmodifyするとstartDateも変わるためコピー
        $endDate = $clone->modify('+'.$addHour.'hour');
        //dd($startDate, $endDate);
        /* 結果 1〜3時間の間で30分単位で表示
        ^ DateTime @1654660800 {#1924
        date: 2022-06-08 13:00:00.0 Asia/Tokyo (+09:00)
        }
        ^ DateTime @1654664400 {#1926
        date: 2022-06-08 14:00:00.0 Asia/Tokyo (+09:00)
        }
        */
        return [
            'name' => $this->faker->name,
            'information' => $this->faker->realText,
            'max_people' => $this->faker->numberBetween(1,20),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_visible' => $this->faker->boolean,
        ];
    }
}
