<?php

namespace App\Nova;

use App\Enums\AppMenuEnum;
use App\Models\AppMenu as AppMenuModel;
use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
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
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
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

            DynamicSelect::make('上级菜单', 'parent_id')
                ->options($this->appMenuTree())
                ->hideFromIndex()
                ->readonly()
            ,
            Text::make('名称', 'title')
                ->rules('required', 'max:255')
                ->displayUsing(function($name, $resource){
                    return str_repeat('|— ', $resource->depth) . $name;
                })
                ->asHtml()
            ,

            Text::make('副标题', 'sub_title')
                ->rules('required')
            ,

            Text::make('图标名称', 'icon')
                ->hideFromIndex()
                ->rules('required')
                ->help('根据 uView 的 u-icon 图标名')
            ,

            Text::make('颜色', 'color')
                ->hideFromIndex()
            ,

            Boolean::make('是否展示', 'status')
                ->trueValue(AppMenuEnum::STATUS_NORMAL)
                ->falseValue(AppMenuEnum::STATUS_DISABLED)
                ->help('禁用后不展示给用户')
            ,

            RadioButton::make('是否开放菜单下内容', 'sub_lock')
                ->onlyOnForms()
                ->rules('required')
                ->options(AppMenuEnum::$subLocks)
                ->default(AppMenuEnum::SUB_LOCK_NORMAL)     // optional
                ->stack()               // optional (required to show hints)
                ->marginBetween()       // optional
                ->skipTransformation()  // optional
            ,
            // 用于展示
            Select::make('是否开放菜单下内容', 'sub_lock')
                ->exceptOnForms()
                ->options(AppMenuEnum::$subLocks)
                ->displayUsingLabels()
            ,

            Text::make('菜单标记', 'slug')
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

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withDepth()->defaultOrder();
    }
}
