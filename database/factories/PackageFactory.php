<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Package::class;

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

    public function package()
    {
        $rand = mt_rand(1, 100);
        return [
            'name' => '套餐' . $rand,
            'price' => 100,
            'period' => 1,

            'explain' => '针对专业侧重点进行练习 ' . $rand,
            'category_id' => 4,
        ];
    }

    public function package2()
    {
        $rand = mt_rand(1, 100);
        return [
            'name' => '套餐' . $rand,
            'price' => 100,
            'period' => 1,

            'explain' => '针对NB专业侧重点进行练习 ' . $rand,
            'category_id' => 6,
        ];
    }
}
