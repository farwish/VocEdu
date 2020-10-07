<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

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

    public function cateTestTreeData()
    {
        return [
            [
                'name' => '医学',
                'children' => [
                    [
                        'name' => '执业药师',
                        'children' => [
                            [
                                'name' => '执业药师（西药）'
                            ],
                            [
                                'name' => '执业药师（中药）'
                            ],
                        ],
                    ],
                    [
                        'name' => '执业医师/执业兽医',
                        'children' => [
                            [
                                'name' => '护士执业资格考试',
                            ],
                        ],
                    ]
                ]
            ],
            [
                'name' => '金融',
                'children' => [
                    [
                        'name' => '初级会计',
                        'children' => [
                            [
                                'name' => '初级经济法-押题',
                            ],
                            [
                                'name' => '经济法主考场',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => '建筑',
            ],
        ];
    }

}
