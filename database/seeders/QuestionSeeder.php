<?php

namespace Database\Seeders;

use App\Enums\QuestionEnum;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $q_radio_choice = [
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
            'category_id' => 7,
        ];

        $q_multi_choice = [
            'title' => '淮海战役的参与者都有谁？',
            'difficulty' => QuestionEnum::DIFFICULTY_MIDDLE,
            'pattern' => QuestionEnum::PATTERN_MULTI_CHOICE,
            'option_answer' => [
                'A' => '毛泽东',
                'B' => '刘少奇',
                'C' => '朱德',
                'D' => '周恩来',
                'E' => '林彪',
            ],
            'right_answer' => 'BC',
            'category_id' => 7,
        ];

        $q_short_answer = [
            'title' => '请谈一下你对网络红人的看法？',
            'difficulty' => QuestionEnum::DIFFICULTY_HARD,
            'pattern' => QuestionEnum::PATTERN_SHORT_ANSWER,
            'right_answer' => '没有标准答案',
            'category_id' => 7,
        ];

        foreach ([$q_radio_choice, $q_multi_choice, $q_short_answer] as $data) {
            Question::factory()->create($data);
        }
    }
}
