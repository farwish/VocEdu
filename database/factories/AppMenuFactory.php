<?php

namespace Database\Factories;

use App\Models\AppMenu;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppMenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AppMenu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function cardList()
    {
        return [
            [
                'title' => '考试指南',
                'sub_title' => '剖析考点 抢分利器',
                'icon' => 'grid',
                'color' => '',
                'next_format' => 'list',
                'slug' => 'exam-guide',
                'sort' => 2,
            ],
            [
                'title' => '学习报告',
                'sub_title' => '统计分析 专属计划',
                'icon' => 'file-text',
                'color' => '',
                'next_format' => 'list',
                'slug' => 'study-report',
                'sort' => 3,
            ],
            [
                'title' => '温故知新',
                'sub_title' => '错题收藏 笔记搜题',
                'icon' => 'order',
                'color' => '',
                'next_format' => 'list',
                'slug' => 'review-insight',
                'sort' => 4,
            ],
            [
                'title' => '模拟考试',
                'sub_title' => '随机模拟 考试记录',
                'icon' => 'man-add-fill',
                'color' => '',
                'next_format' => 'list',
                'slug' => 'simulate-exam',
                'sort' => 5,
            ],
            [
                'title' => '章节练习',
                'sub_title' => '海量题库 快速背题',
                'icon' => 'list-dot',
                'color' => '',
                'next_format' => 'list',
                'slug' => 'chapter-practise',
                'sort' => 6,
            ],
        ];
    }
}
