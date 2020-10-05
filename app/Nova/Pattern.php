<?php

namespace App\Nova;

use App\Enums\PatternEnum;
use App\Models\Pattern as PatternModel;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Pattern extends Resource
{
    public static $group = '题库管理';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PatternModel::class;

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
            // ID::make(__('ID'), 'id')->sortable(),

            Text::make('题型名称', 'name')
                ->rules('required')
            ,

            Select::make('题型分类', 'type')
                ->options(PatternEnum::$patternType)
                ->default(function () {
                    return PatternEnum::TYPE_SUBJECTIVE;
                })
                ->rules('required')
                ->displayUsingLabels()
            ,

            NovaDependencyContainer::make([
                Select::make('选项分类', 'classify')
                    ->options(PatternEnum::$objectiveClassify)
                    ->default(function () {
                        return PatternEnum::OBJECTIVE_CLASSIFY_RADIO;
                    })
                ,
            ])
                ->dependsOn('type', PatternEnum::TYPE_OBJECTIVE)
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
        return '题型';
    }
}
