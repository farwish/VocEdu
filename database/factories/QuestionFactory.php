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
            'pattern_id' => 1,
            'option_answer' => [
                'A' => '1990',
                'B' => '1949',
                'C' => '1919',
                'D' => '1840',
            ],
            'right_answer' => 'B',
            'category_id' => 4,
            'chapter_id' => 4,
            'sort' => 6,
        ];
    }

    public function questionMultiChoice()
    {
        return [
            'title' => '淮海战役的参与者都有谁？',
            'difficulty' => QuestionEnum::DIFFICULTY_MIDDLE,
            'pattern_id' => 2,
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
            'chapter_id' => 4,
            'sort' => 6,
        ];
    }

    public function questionJudgement()
    {
        return [
            'title' => '人有三只眼睛',
            'difficulty' => QuestionEnum::DIFFICULTY_EASY,
            'pattern_id' => 3,
            'right_answer' => 2,
            'category_id' => 4,
            'chapter_id' => 4,
            'sort' => 5,
        ];
    }

    public function questionGapFilling()
    {
        return [
            'title' => '__球有人类？',
            'difficulty' => QuestionEnum::DIFFICULTY_EASY,
            'pattern_id' => 4,
            'right_answer' => '地',
            'category_id' => 4,
            'chapter_id' => 4,
            'sort' => 8,
        ];
    }

    public function questionShortAnswer()
    {
        return [
            'title' => '请谈一下你对网络红人的看法？',
            'difficulty' => QuestionEnum::DIFFICULTY_HARD,
            'pattern_id' => 5,
            'right_answer' => '没有标准答案',
            'category_id' => 4,
            'chapter_id' => 4,
            'sort' => 2,
        ];
    }

    // ================ for another category ===================


    public function questionRadioChoice2()
    {
        $rand = mt_rand(1, 100);

        return [
            'title' => '中华人民共和国成立于（）年?' . " flag-$rand",
            'difficulty' => QuestionEnum::DIFFICULTY_EASY,
            'pattern_id' => 1,
            'option_answer' => [
                'A' => '1990',
                'B' => '1949',
                'C' => '1919',
                'D' => '1840',
            ],
            'right_answer' => 'B',
            'category_id' => 6,
            'chapter_id' => 14,
            'sort' => 6,
        ];
    }

    public function questionMultiChoice2()
    {
        $rand = mt_rand(1, 100);

        return [
            'title' => '淮海战役的参与者都有谁？' . " flag-$rand",
            'difficulty' => QuestionEnum::DIFFICULTY_MIDDLE,
            'pattern_id' => 2,
            'option_answer' => [
                'A' => '毛泽东',
                'B' => '刘伯承',
                'C' => '朱德',
                'D' => '周恩来',
                'E' => '林彪',
                'F' => '粟裕',
            ],
            'right_answer' => 'BF',
            'category_id' => 6,
            'chapter_id' => 14,
            'sort' => 6,
        ];
    }

    public function questionJudgement2()
    {
        $rand = mt_rand(1, 100);

        return [
            'title' => '人有三只眼睛' . " flag-$rand",
            'difficulty' => QuestionEnum::DIFFICULTY_EASY,
            'pattern_id' => 3,
            'right_answer' => 2,
            'category_id' => 6,
            'chapter_id' => 14,
            'sort' => 5,
        ];
    }

    public function questionGapFilling2()
    {
        $rand = mt_rand(1, 100);

        return [
            'title' => '__球有人类？' . " flag-$rand",
            'difficulty' => QuestionEnum::DIFFICULTY_EASY,
            'pattern_id' => 4,
            'right_answer' => '地',
            'category_id' => 6,
            'chapter_id' => 14,
            'sort' => 8,
        ];
    }

    public function questionShortAnswer2()
    {
        $rand = mt_rand(1, 100);

        return [
            'title' => '请谈一下你对网络红人的看法？' . " flag-$rand",
            'difficulty' => QuestionEnum::DIFFICULTY_HARD,
            'pattern_id' => 5,
            'right_answer' => '没有标准答案',
            'category_id' => 6,
            'chapter_id' => 14,
            'sort' => 2,
        ];
    }
}
