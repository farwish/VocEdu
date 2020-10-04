<?php

namespace Database\Seeders;

use App\Enums\ExamEnum;
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
        Exam::factory()->create([
            'name' => '考1',
            'status' => ExamEnum::STATUS_IS_NOT_OPEN,
            'paper_id' => 1,
            'area' => '北京',

            'guide_id' => 1,
            'outline_id' => 1,
        ]);
    }
}
