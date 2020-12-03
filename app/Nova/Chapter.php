<?php

namespace App\Nova;

use App\Enums\ChapterEnum;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Saumini\Count\RelationshipCount;
use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use App\Models\Chapter as ChapterModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
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

    public static $searchRelations = [
        'category' => ['name'],
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
            (new Tabs('章节', [
                '详情' => [
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
                            if (empty($values['category_id'])) return [];
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

                    Boolean::make('本章节不禁用', 'status')
                        ->trueValue(ChapterEnum::STATUS_NORMAL)
                        ->falseValue(ChapterEnum::STATUS_DISABLED)
                        ->help('禁用后不展示给用户')
                    ,

                    Boolean::make('子章节不锁定', 'sub_lock')
                        ->trueValue(ChapterEnum::SUB_LOCK_NORMAL)
                        ->falseValue(ChapterEnum::SUB_LOCK_BUYING)
                        ->help('锁定后表示需要购买套餐后才能进入子章节')
                    ,

                    Number::make('免费题量', 'free_question_num')
                        ->min(0)
                        ->step(1)
                        ->help('只对最后一级生效')
                    ,

                    RelationshipCount::make('总题量', 'questions')
                        ->onlyOnIndex()
                    ,
                ],
                '题目' => [
                    HasMany::make('题目', 'questions', Question::class),
                ]
            ]))
                ->defaultSearch(true)
                ->withToolbar()
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
        return [
            new Filters\ChapterStatus(),
        ];
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
        return [
        ];
    }

    public static function label()
    {
        return '章节';
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withDepth()->defaultOrder();
    }
}
