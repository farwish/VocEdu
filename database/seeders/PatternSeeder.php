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
        $patterns = Pattern::factory()->pattern();

        foreach ($patterns as $pattern) {
            Pattern::factory()->create($pattern);
        }
    }
}
