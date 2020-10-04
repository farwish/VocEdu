<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Video::factory()->create([
            'name' => '视频1',
            'url' => 'http://baidu.com',
            'category_id' => 7,
        ]);
    }
}
