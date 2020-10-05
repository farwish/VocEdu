<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Chapter;
use Illuminate\Database\Seeder;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $treeData = Chapter::factory()->chapterTestTreeData();

        foreach ($treeData as $treeItem) {
            Chapter::create($treeItem);
        }
    }
}
