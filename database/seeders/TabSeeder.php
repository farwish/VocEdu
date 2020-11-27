<?php

namespace Database\Seeders;

use App\Models\Tab;
use Illuminate\Database\Seeder;

class TabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Tab::factory()->tabNames() as $name) {
            Tab::factory()->create([
                'name' => $name,
                'category_id' => 4,
            ]);
        }

        foreach (Tab::factory()->tabNames2() as $name) {
            Tab::factory()->create([
                'name' => $name,
                'category_id' => 6,
            ]);
        }
    }
}
