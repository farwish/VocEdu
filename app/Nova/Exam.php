<?php

namespace App\Nova;

use App\Enums\ExamEnum;
use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

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
            // ID::make(__('ID'), 'id')->sortable(),

            DynamicSelect::make('科目分类', 'category_id')
                ->options($this->categoryTree())
                ->rules('required')
                ->onlyOnForms()
            ,

            BelongsTo::make('科目分类', 'category', Category::class)
                ->exceptOnForms()
            ,

            Text::make('考场名称', 'name')->rules('required'),

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

            BelongsTo::make('试卷', 'paper', Paper::class)
                ->rules('required')
            ,

            Text::make('考试地区', 'area')
                ->rules('required')
            ,

            BelongsTo::make('考试指南', 'guide', Article::class)
                ->rules('required')
                ->help('文章模块内容'),

            BelongsTo::make('考试大纲', 'outline', Article::class)
                ->rules('required')
                ->help('文章模块内容'),
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
