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
            '题库',
            '考点精讲',
            '易混易错',
            '重点案例',
            '名师点题',
        ];
    }
}
