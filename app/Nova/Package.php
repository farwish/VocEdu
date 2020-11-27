<?php

namespace App\Nova;

use App\Enums\PackageEnum;
use App\Models\Package as PackageModel;
use Benjacho\BelongsToManyField\BelongsToManyField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\MultiselectField\Multiselect;
use OwenMelbz\RadioField\RadioButton;

class Package extends Resource
{
    public static $group = '题库管理';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PackageModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    public static $searchRelations = [
        'category' => ['id', 'name'],
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            // DynamicSelect::make('科目分类', 'category_id')
            //     ->options($this->categoryTree())
            //     ->rules('required')
            //     ->onlyOnForms()
            // ,
            // Select::make('Category', 'category')
            //     ->options($this->categoryTree())
            //     ->rules('required')
            //     ->searchable()
            //     ->onlyOnForms()
            // ,

            // Only relation can be used by BelongsToManyField::dependOn
            BelongsTo::make('科目分类', 'category', Category::class)
                ->onlyOnForms()
                ->searchable()
                ->displayUsing(function ($model) {
                    $tree = $this->categoryTree();
                    return $model ? $tree[$model->getAttribute('id')] : $tree;
                })
            ,
            // On index and detail page
            BelongsTo::make('科目分类', 'category', Category::class)
                ->exceptOnForms()
            ,

            Text::make('套餐名称', 'name')
                ->rules('required')
            ,

            Textarea::make('套餐说明', 'explain')
                ->rules('required')
            ,

            Number::make('价格(元)', 'price')
                ->rules('required')
                ->default(function () {
                    return 0;
                })
            ,

            // 用于Form
            RadioButton::make('有效期模式', 'expire_mode')
                ->onlyOnForms()
                ->options([
                    PackageEnum::EXPIRE_MODE_FIXED   => [ '设置'   => PackageEnum::$expireModes[PackageEnum::EXPIRE_MODE_FIXED] ],
                    PackageEnum::EXPIRE_MODE_DYNAMIC => [ '不设置' => PackageEnum::$expireModes[PackageEnum::EXPIRE_MODE_DYNAMIC] ],
                ])
                ->default(0)     // optional
                ->stack()               // optional (required to show hints)
                ->marginBetween()       // optional
                ->skipTransformation()  // optional
                ->toggle([              // optional
                    1 => ['duration']     // will hide period field when value is equal to the key
                ])
            ,
            // 用于展示
            Select::make('有效期模式', 'expire_mode')
                ->exceptOnForms()
                ->options(PackageEnum::$expireModes)
                ->displayUsingLabels()
            ,

            Number::make('有效时间(年)', 'duration')
                ->rules('required', 'min:1', 'max:10')
                ->step(1)
            ,

            // Tabs:

            // For form
            BelongsToManyField::make('标签', 'tabs', Tab::class)
                ->rules('required')
                ->dependsOn('category', 'category_id')
                ->onlyOnForms()
            ,
            // For index and detail
            Multiselect::make('标签', 'tabs')
                ->rules('required')
                ->options(\App\Models\Tab::all()->pluck('name', 'name')->toArray())
                ->belongsToMany(Tab::class)
                ->exceptOnForms()
            ,

            // Suite:

            // Only for create/edit, for help with 'Multiselect', dependency should be native field.
            BelongsToManyField::make('试卷组', 'suites', Suite::class)
                ->dependsOn('category', 'category_id')
                ->onlyOnForms()
            ,
            // Only for show, because 'Multiselect' can not dependOn category relationShip.
            Multiselect::make('试卷组', 'suites')
                ->rules('required')
                ->belongsToMany(Suite::class)
                ->exceptOnForms()
            ,

            // Video:

            BelongsToManyField::make('视频', 'videos', Video::class)
                ->dependsOn('category', 'category_id')
                ->onlyOnForms()
            ,
            Multiselect::make('视频', 'videos')
                ->belongsToMany(Video::class)
                ->exceptOnForms()
            ,
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function label()
    {
        return '套餐';
    }
}
