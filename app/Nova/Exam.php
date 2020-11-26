<?php

namespace App\Nova;

use App\Enums\ExamEnum;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Manmohanjit\BelongsToDependency\BelongsToDependency;

class Exam extends Resource
{
    public static $group = '题库管理';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Exam::class;

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
            // Only relation can be used by BelongsToManyField::dependOn
            BelongsTo::make('科目分类', 'category', Category::class)
                ->onlyOnForms()
                ->searchable() // BelongsToDependency not support searchable()
                // ->displayUsing(function ($model) {
                //     $tree = $this->categoryTree();
                //     return $model ? $tree[$model->getAttribute('id')] : $tree;
                // })
            ,
            BelongsTo::make('科目分类', 'category', Category::class)
                ->exceptOnForms()
            ,

            Text::make('考场名称', 'name')->rules('required'),

            Text::make('考试地区', 'area')
                ->rules('required')
            ,

            // Badge::make( '状态', 'status', function () {
            //     return ExamEnum::$status[$this->status];
            // })->exceptOnForms(),

            Select::make('状态', 'status')
                ->rules('required')
                ->options(ExamEnum::$status)
                ->default(function () {
                    return ExamEnum::STATUS_IS_NOT_OPEN;
                })
                ->displayUsingLabels()
            ,

            BelongsToDependency::make('试卷', 'paper', Paper::class)
                ->rules('required')
                ->dependsOn('category', 'category_id')
            ,

            BelongsToDependency::make('考试指南', 'guide', Article::class)
                ->rules('required')
                ->dependsOn('category', 'category_id')
                ->help('文章模块内容'),

            BelongsToDependency::make('考试大纲', 'outline', Article::class)
                ->rules('required')
                ->dependsOn('category', 'category_id')
                ->help('文章模块内容'),

            DateTime::make('到期时间', 'expired_at')
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
        return '考场';
    }
}
