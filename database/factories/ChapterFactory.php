<?php

namespace Database\Factories;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chapter::class;

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

    public function chapterTestTreeData()
    {
        $categoryId = 4;

        $categoryIdTwo = 6;

        return [
            [
                'category_id' => $categoryId,
                'name' => '章1',
                'children' => [
                    [
                        'category_id' => $categoryId,
                        'name' => '单元1',
                        'children' => [
                            [
                                'category_id' => $categoryId,
                                'name' => '小节1',
                                'children' => [
                                    [
                                        'category_id' => $categoryId,
                                        'name' => '知识点1',
                                        'free_question_num' => 4,
                                    ],
                                    [
                                        'category_id' => $categoryId,
                                        'name' => '知识点2',
                                    ],
                                ],
                            ],
                            [
                                'category_id' => $categoryId,
                                'name' => '小节2'
                            ],
                        ],
                    ],
                    [
                        'category_id' => $categoryId,
                        'name' => '单元2',
                        'sub_lock' => 1,
                        'children' => [
                            [
                                'category_id' => $categoryId,
                                'name' => '小节1',
                            ],
                        ],
                    ]
                ]
            ],
            [
                'category_id' => $categoryId,
                'name' => '章2',
            ],

            [
                'category_id' => $categoryIdTwo,
                'name' => '章节1',
                'children' => [
                    [
                        'category_id' => $categoryIdTwo,
                        'name' => '单元1',
                        'children' => [
                            [
                                'category_id' => $categoryIdTwo,
                                'name' => '小节1',
                                'children' => [
                                    [
                                        'category_id' => $categoryIdTwo,
                                        'name' => '知识点1',
                                        'free_question_num' => 4,
                                    ],
                                    [
                                        'category_id' => $categoryIdTwo,
                                        'name' => '知识点2',
                                    ],
                                ],
                            ],
                            [
                                'category_id' => $categoryIdTwo,
                                'name' => '小节2'
                            ],
                        ],
                    ],
                    [
                        'category_id' => $categoryIdTwo,
                        'name' => '单元2',
                        'children' => [
                            [
                                'category_id' => $categoryIdTwo,
                                'name' => '小节1',
                            ],
                        ],
                    ]
                ]
            ],
            [
                'category_id' => $categoryIdTwo,
                'name' => '章节2',
            ],
        ];
    }
}
