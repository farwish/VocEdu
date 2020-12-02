<?php

namespace App\Nova;

use App\Enums\AppMenuEnum;
use App\Models\AppMenu as AppMenuModel;
use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use OwenMelbz\RadioField\RadioButton;

class AppMenu extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = AppMenuModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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

            DynamicSelect::make('父菜单', 'parent_id')
                ->help('不选的时候代表根菜单。')
                ->options($this->appMenuTree())
                ->onlyOnForms()
            ,

            Text::make('标题', 'title')
                ->rules('required')
            ,

            Text::make('副标题', 'sub_title')
                ->rules('required')
            ,

            Text::make('图标名称', 'icon')
                ->rules('required')
                ->help('根据 uView 的 u-icon 图标名')
            ,

            Text::make('颜色', 'color')
            ,

            Select::make('子页面类型', 'next_format')
                ->options(AppMenuEnum::$nextFormats)
                ->displayUsingLabels()
            ,

            Boolean::make('是否展示', 'status')
                ->trueValue(AppMenuEnum::STATUS_NORMAL)
                ->falseValue(AppMenuEnum::STATUS_DISABLED)
                ->help('禁用后不展示给用户')
            ,

            Number::make('排序值', 'sort')
                ->rules('required', 'min:0')
                ->step(1)
            ,

            Text::make('菜单标记', 'slag')
                ->readonly()
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
        return 'APP菜单';
    }
}
