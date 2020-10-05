<?php

namespace App\Nova;

use App\Models\Category as CategoryModel;
use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Saumini\Count\RelationshipCount;

class Category extends Resource
{
    public static $group = '题库管理';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = CategoryModel::class;

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

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')
                ->sortable()
                ->onlyOnDetail()
            ,

            DynamicSelect::make('上级分类', 'parent_id')
                ->help('不选的时候代表根分类。')
                ->options($this->categoryTree())
                ->onlyOnForms()
            ,

            Text::make('名称', 'name')
                ->rules('required', 'max:255')
                ->displayUsing(function($name, $resource){
                    return str_repeat('|— ', $resource->depth) . $name;
                })
                ->asHtml()
            ,

            RelationshipCount::make('章节数', 'chapters')
                ->onlyOnIndex()
            ,

            HasMany::make('章节', 'chapters', Chapter::class),
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
        return '科目分类';
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withDepth()->defaultOrder();
    }
}
