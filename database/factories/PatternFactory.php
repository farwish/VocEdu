<?php

namespace Database\Factories;

use App\Enums\PatternEnum;
use App\Models\Pattern;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatternFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pattern::class;

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

    public function pattern()
    {
        return [
            [
                'name' => '单选题',
                'type' => PatternEnum::TYPE_OBJECTIVE,
                'classify' => PatternEnum::OBJECTIVE_CLASSIFY_RADIO,
            ],
            [
                'name' => '多选题',
                'type' => PatternEnum::TYPE_OBJECTIVE,
                'classify' => PatternEnum::OBJECTIVE_CLASSIFY_MULTI,
            ],
            [
                'name' => '不定项选择',
                'type' => PatternEnum::TYPE_OBJECTIVE,
                'classify' => PatternEnum::OBJECTIVE_CLASSIFY_DRIFT,
            ],
            [
                'name' => '判断题',
                'type' => PatternEnum::TYPE_OBJECTIVE,
                'classify' => PatternEnum::OBJECTIVE_CLASSIFY_JUDGE,
            ],
            [
                'name' => '填空题',
                'type' => PatternEnum::TYPE_OBJECTIVE,
                'classify' => PatternEnum::OBJECTIVE_CLASSIFY_CONST,
            ],
            [
                'name' => '简答题',
                'type' => PatternEnum::TYPE_SUBJECTIVE,
            ],
        ];
    }
}
