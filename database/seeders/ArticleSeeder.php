<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::factory()->create(Article::factory()->articleGuide());
        Article::factory()->create(Article::factory()->articleOutline());

        Article::factory()->create(Article::factory()->articleGuide2());
        Article::factory()->create(Article::factory()->articleOutline2());
    }
}
