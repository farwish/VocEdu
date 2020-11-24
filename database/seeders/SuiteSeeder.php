<?php

namespace Database\Seeders;

use App\Models\Paper;
use App\Models\Suite;
use Illuminate\Database\Seeder;

class SuiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Suite::factory()
            ->hasPapers(1, Paper::factory()->paper())
            ->hasPapers(1, Paper::factory()->paper())
            ->create(Suite::factory()->suite());

        Suite::factory()
            ->hasPapers(1, Paper::factory()->paper2())
            ->hasPapers(1, Paper::factory()->paper2())
            ->create(Suite::factory()->suite2());
    }
}
