<?php

namespace Database\Seeders;

use App\Models\Pattern;
use Illuminate\Database\Seeder;

class PatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            '单选',
            '多选',
            '判断',
            '填空',
            '问答',
        ];

        foreach ($names as $name) {
            Pattern::factory()->create([
                'name' => $name,
            ]);
        }

    }
}
