<?php

namespace Database\Seeders;

use App\Models\Paper;
use App\Models\Question;
use Illuminate\Database\Seeder;

class PaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paper::factory()
            ->hasQuestions(1, Question::factory()->questionRadioChoice())
            ->hasQuestions(1, Question::factory()->questionMultiChoice())
            ->hasQuestions(1, Question::factory()->questionJudgement())
            ->create(Paper::factory()->paper());

        Paper::factory()
            ->hasQuestions(1, Question::factory()->questionGapFilling())
            ->hasQuestions(1, Question::factory()->questionShortAnswer())
            ->create(Paper::factory()->paper());
    }
}
