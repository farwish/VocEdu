<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

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

    public function articleGuide()
    {
        return [
            'title' => '考试指南' . mt_rand(1, 100),
            'body' => '2020年版试题分析将进行全面修订，分单科出版。图书内容也将做较大调整，分为三个部分：第一部分为考试要求，将对各学科的能力要求做详细阐述并附例题说明；第二部分为2019年考试分析，将在详细数据分析的基础上对2019年的高考各科试题进行较为权威的解析；第三部分附有近几年的真题及解析。此6册图书中，语文、英语分册不分文理科。',
            'category_id' => 4,
        ];
    }

    public function articleOutline()
    {
        return [
            'title' => '考试大纲' . mt_rand(1, 100),
            'body' => '2020年版试题分析将进行全面修订，分单科出版。图书内容也将做较大调整，分为三个部分：第一部分为考试要求，将对各学科的能力要求做详细阐述并附例题说明；第二部分为2019年考试分析，将在详细数据分析的基础上对2019年的高考各科试题进行较为权威的解析；第三部分附有近几年的真题及解析。此6册图书中，语文、英语分册不分文理科。',
            'category_id' => 4,
        ];
    }
}
