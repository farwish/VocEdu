<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Suite;
use App\Models\Tab;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::factory()
            ->hasSuites(1, Suite::factory()->suite())
            ->hasSuites(1, Suite::factory()->suite())
            ->hasTabs(1, Tab::factory()->tab())
            ->create(Package::factory()->package());

        Package::factory()
            ->hasSuites(1, Suite::factory()->suite2())
            ->hasSuites(1, Suite::factory()->suite2())
            ->hasTabs(1, Tab::factory()->tab2())
            ->hasTabs(1, Tab::factory()->tab22())
            ->create(Package::factory()->package2());
    }
}
