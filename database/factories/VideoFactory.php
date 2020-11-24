<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function video()
    {
        return [
            'name' => '视频' . mt_rand(1, 100),
            'url' => $this->faker->url,
            'category_id' => 4,
        ];
    }

    public function video2()
    {
        return [
            'name' => '视频' . mt_rand(1, 100),
            'url' => $this->faker->url,
            'category_id' => 6,
        ];
    }
}
