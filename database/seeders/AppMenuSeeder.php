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
        foreach (AppMenu::factory()->cardList() as $item) {
            AppMenu::factory()->create($item);
        }

        // Category specific card
        foreach (AppMenu::factory()->cardList() as &$item) {
            $item['title'] = $item['title'] . '666';
            $item['sub_title'] = $item['sub_title'] . ' !';
            $item['category_id'] = 6;
            AppMenu::factory()->create($item);
        }
        unset($item);
    }
}
