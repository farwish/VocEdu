<?php

namespace App\Nova;

use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use App\Models\Article as ArticleModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Article extends Resource
{
    public static $group = '内容管理';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ArticleModel::class;

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

            // DynamicSelect::make('科目分类', 'category_id')
            //     ->options($this->categoryTree())
            //     ->rules('required')
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

            Text::make('标题', 'title')
                ->rules('required')
            ,

            Trix::make('内容', 'body')
                ->rules('required')
                ->alwaysShow()
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
        return '文章';
    }
}
