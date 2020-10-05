<?php

namespace App\Nova;

use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use App\Models\Chapter as ChapterModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Chapter extends Resource
{
    public static $group = '题库管理';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ChapterModel::class;

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
            ID::make(__('ID'), 'id'),

            DynamicSelect::make('科目分类', 'category_id')
                ->options($this->categoryTree())
                ->rules('required')
                ->onlyOnForms()
            ,
            BelongsTo::make('科目分类', 'category', Category::class)                ->exceptOnForms()
                ->exceptOnForms()
            ,

            DynamicSelect::make('上级章节', 'parent_id')
                ->help('不选的时候代表根章节。')
                ->onlyOnForms()
                ->dependsOn(['category_id'])
                ->options(function ($values) {
                    return $this->chapterTree($values['category_id']);
                })
            ,

            Text::make('名称', 'name')
                ->rules('required', 'max:255')
                ->displayUsing(function($name, $resource){
                    return str_repeat('|— ', $resource->depth) . $name;
                })
                ->asHtml()
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
        return '章节知识';
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withDepth()->defaultOrder();
    }
}
