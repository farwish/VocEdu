<?php

namespace Database\Seeders;

use App\Models\AppMenu;
use Illuminate\Database\Seeder;

class AppMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Global for category without card data
        $treeData = AppMenu::factory()->cardList();

        foreach ($treeData as $treeItem) {
            AppMenu::create($treeItem);
        }
    }
}
