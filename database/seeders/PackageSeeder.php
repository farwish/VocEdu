<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Suite;
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
            ->create(Package::factory()->package());

        Package::factory()
            ->hasSuites(1, Suite::factory()->suite2())
            ->hasSuites(1, Suite::factory()->suite2())
            ->create(Package::factory()->package2());
    }
}
