<?php

namespace Database\Factories;

use App\Models\Paper;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaperFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Paper::class;

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

    public function paper()
    {
        return [
            'name' => '模拟卷' . mt_rand(1, 100),
            'total_score' => 100,
            'pass_score' => 60,
            'minutes' => 60,

            'category_id' => 4,
        ];
    }
}
