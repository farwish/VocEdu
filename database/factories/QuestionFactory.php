<?php

namespace Database\Factories;

use App\Enums\QuestionEnum;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

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

    public function questionRadioChoice()
    {
        return [
            'title' => '中华人民共和国成立于（）年?',
            'difficulty' => QuestionEnum::DIFFICULTY_EASY,
            'pattern' => QuestionEnum::PATTERN_RADIO_CHOICE,
            'option_answer' => [
                'A' => '1990',
                'B' => '1949',
                'C' => '1919',
                'D' => '1840',
            ],
            'right_answer' => 'B',
            'category_id' => 4,
        ];
    }

    public function questionMultiChoice()
    {
        return [
            'title' => '淮海战役的参与者都有谁？',
            'difficulty' => QuestionEnum::DIFFICULTY_MIDDLE,
            'pattern' => QuestionEnum::PATTERN_MULTI_CHOICE,
            'option_answer' => [
                'A' => '毛泽东',
                'B' => '刘伯承',
                'C' => '朱德',
                'D' => '周恩来',
                'E' => '林彪',
                'F' => '粟裕',
            ],
            'right_answer' => 'BF',
            'category_id' => 4,
        ];
    }

    public function questionGapFilling()
    {
        return [
            'title' => '__球有人类？',
            'difficulty' => QuestionEnum::DIFFICULTY_EASY,
            'pattern' => QuestionEnum::PATTERN_GAP_FILLING,
            'right_answer' => '地',
            'category_id' => 4,
        ];
    }

    public function questionShortAnswer()
    {
        return [
            'title' => '请谈一下你对网络红人的看法？',
            'difficulty' => QuestionEnum::DIFFICULTY_HARD,
            'pattern' => QuestionEnum::PATTERN_SHORT_ANSWER,
            'right_answer' => '没有标准答案',
            'category_id' => 4,
        ];
    }
}
