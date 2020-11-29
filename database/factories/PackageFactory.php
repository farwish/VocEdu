<?php

namespace Database\Factories;

use App\Enums\PackageEnum;
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
            'expire_mode' => PackageEnum::EXPIRE_MODE_FIXED,
            'duration' => 1,
            'list_status' => PackageEnum::LIST_STATUS_NORMAL,

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
            'expire_mode' => PackageEnum::EXPIRE_MODE_DYNAMIC,
            'duration' => null,
            'list_status' => PackageEnum::LIST_STATUS_NORMAL,

            'explain' => '针对NB专业侧重点进行练习 ' . $rand,
            'category_id' => 6,
        ];
    }
}
