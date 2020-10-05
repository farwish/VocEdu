<?php

namespace Database\Seeders;

use App\Models\Package;
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
        Package::factory()->create([
            'name' => '套餐1',
            'price' => 100,

            'category_id' => 4,
        ]);
    }
}
