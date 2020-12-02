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
                'title' => '章节练习',
                'sub_title' => '海量题库 快速背题',
                'icon' => 'list-dot',
                'color' => '',
                'slug' => 'chapter-practise',
            ],
            [
                'title' => '温故知新',
                'sub_title' => '错题收藏 笔记搜题',
                'icon' => 'order',
                'color' => '',
                'slug' => 'review-insight',
                'children' => [
                    [
                        'title' => '我的错题',
                        'sub_title' => '个人错题 查缺补漏',
                        'icon' => 'order',
                        'color' => '',
                        'slug' => 'wrong-question',
                    ],
                    [
                        'title' => '我的收藏',
                        'sub_title' => '我的收藏 好题汇总',
                        'icon' => 'order',
                        'color' => '',
                        'slug' => 'collected-question',
                    ],
                    [
                        'title' => '我的笔记',
                        'sub_title' => '个人笔记 随心记录',
                        'icon' => 'order',
                        'color' => '',
                        'slug' => 'noted-question',
                    ],
                    [
                        'title' => '易错试题',
                        'sub_title' => '高频错题 逐一攻破',
                        'icon' => 'order',
                        'color' => '',
                        'slug' => 'easy-wrong-question',
                    ],
                    [
                        'title' => '热点试题',
                        'sub_title' => '精华好题 热门排行',
                        'icon' => 'order',
                        'color' => '',
                        'slug' => 'hot-question',
                    ],
                    // [
                    //     'title' => '查找试题',
                    //     'sub_title' => '海量题库 精确查找',
                    //     'icon' => 'order',
                    //     'color' => '',
                    //     'slug' => 'search-question',
                    // ],
                ],
            ],
            [
                'title' => '模拟考试',
                'sub_title' => '随机模拟 考试记录',
                'icon' => 'man-add-fill',
                'color' => '',
                'slug' => 'exam-simulate',
                'children' => [
                    [
                        'title' => '模拟试题',
                        'sub_title' => '仿真试卷 知根知底',
                        'icon' => 'man-add-fill',
                        'color' => '',
                        'slug' => 'paper-simulate',
                    ],
                    [
                        'title' => '随机模考',
                        'sub_title' => '模拟考试 还原现场',
                        'icon' => 'man-add-fill',
                        'color' => '',
                        'slug' => 'random-simulate',
                    ],
                    // [
                    //     'title' => '考试记录',
                    //     'sub_title' => '详细记录 反复练习',
                    //     'icon' => 'man-add-fill',
                    //     'color' => '',
                    //     'slug' => 'exam-record',
                    // ],
                ],
            ],
            [
                'title' => '考试指南',
                'sub_title' => '剖析考点 抢分利器',
                'icon' => 'grid',
                'color' => '',
                'slug' => 'exam-guide',
            ],
            [
                'title' => '学习报告',
                'sub_title' => '统计分析 专属计划',
                'icon' => 'file-text',
                'color' => '',
                'slug' => 'study-report',
            ],
        ];
    }
}
