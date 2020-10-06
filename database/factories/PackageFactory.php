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
        return [
            'name' => '套餐' . mt_rand(1, 100),
            'price' => 100,

            'explain_id' => 3,
            'category_id' => 4,
        ];
    }
}
