<?php

namespace Database\Seeders;

use App\Models\Paper;
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
        Paper::factory()->create([
            'name' => '模拟卷1',
            'total_score' => 100,
            'pass_score' => 60,
            'minutes' => 60,
        ]);
    }
}
