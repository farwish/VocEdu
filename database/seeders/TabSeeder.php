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
        $tabNames = Tab::factory()->tabNames();

        foreach ($tabNames as $name) {
            Tab::factory()->create([
                'name' => $name,
            ]);
        }
    }
}
