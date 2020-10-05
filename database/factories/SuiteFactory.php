<?php

namespace Database\Factories;

use App\Models\Suite;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Suite::class;

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

    public function suite()
    {
        return [
            'name' => '试卷组' . mt_rand(1, 100),
            'category_id' => 4,
        ];
    }
}
