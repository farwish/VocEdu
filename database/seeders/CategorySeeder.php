<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $treeData = Category::factory()->cateTestTreeData();

        foreach ($treeData as $treeItem) {
            Category::create($treeItem);
        }
    }
}
