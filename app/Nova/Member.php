<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Saumini\Count\RelationshipCount;

class Member extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Member::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'mobile';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'mobile',
    ];

    public static $searchRelations = [
        'categories' => ['name'],
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

            Text::make('手机号', 'mobile')
                ->rules('required', 'max:255')
            ,

            Text::make('密码', 'password')
                ->resolveUsing(function ($value) {
                    return '';
                })
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6')
            ,

            Text::make('创建时间', 'created_at')
                ->displayUsing(function ($carbon) {
                    /** @var \Illuminate\Support\Carbon $carbon */
                    return $carbon->format('Y-m-d H:i');
                })
                ->onlyOnDetail()
            ,

            BelongsToMany::make('开通科目', 'categories', Category::class)
                ->searchable()
                ->fields(function () {
                    return [
                        DateTime::make('到期时间', 'expired_at')
                    ];
                })
            ,

            RelationshipCount::make('开通科目数', 'categories')
                ->sortable()
                ->onlyOnIndex()
            ,

            RelationshipCount::make('笔记数', 'practiseNotes')
                ->sortable()
                ->onlyOnIndex()
            ,

            HasMany::make('错题', 'practiseRecords', PractiseRecord::class),

            HasMany::make('笔记', 'practiseNotes', PractiseNote::class),

            // Text::make('用户名', 'name')
            //     ->rules('required', 'max:255')
            // ,
            //
            // Text::make('邮箱', 'email')
            //     ->rules('required', 'email', 'max:255')
            // ,
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
        return '用户';
    }

    // Overwrite the indexQuery to include relationship count
    public static function indexQuery(NovaRequest $request, $query)
    {
        // Give relationship name as alias else Laravel will name it as comments_count
        return $query->withCount('practiseNotes')->withCount('categories');
    }
}
