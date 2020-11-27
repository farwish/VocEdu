<?php

namespace Database\Factories;

use App\Models\Tab;
use Illuminate\Database\Eloquent\Factories\Factory;

class TabFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tab::class;

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

    public function tabNames()
    {
        return [
            '考点精讲',
            '易混易错',
        ];
    }

    public function tabNames2()
    {
        return [
            '重点案例',
            '名师点题',
        ];
    }

    public function tab()
    {
        return [
            'name' => '题库',
            'category_id' => 4,
        ];
    }

    public function tab2()
    {
        return [
            'name' => '题库',
            'category_id' => 6,
        ];
    }

    public function tab22()
    {
        return [
            'name' => '考前押题',
            'category_id' => 6,
        ];
    }
}
