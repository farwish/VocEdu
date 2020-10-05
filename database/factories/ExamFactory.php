<?php

namespace Database\Factories;

use App\Enums\ExamEnum;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exam::class;

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

    public function exam()
    {
        return [
            'name' => '考场' . mt_rand(1, 100),
            'status' => ExamEnum::STATUS_IS_NOT_OPEN,
            'paper_id' => 1,
            'category_id' => 4,

            'area' => '北京',
            'guide_id' => 1,
            'outline_id' => 2,
        ];
    }
}
