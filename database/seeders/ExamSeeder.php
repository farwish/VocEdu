<?php

namespace Database\Seeders;

use App\Enums\ExamEnum;
use App\Models\Article;
use App\Models\Exam;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Exam::factory()->create(Exam::factory()->exam());
        Exam::factory()->create(Exam::factory()->exam2());
    }
}
