<?php

namespace App\Nova;

use App\Enums\QuestionEnum;
use App\Models\Question as QuestionModel;
use DigitalCreative\ConditionalContainer\ConditionalContainer;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Question extends Resource
{
    public static $group = '题库管理';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = QuestionModel::class;

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
        $difficulty = QuestionEnum::$difficulty;
        $patterns = QuestionEnum::$pattern;

        return [
            // ID::make(__('ID'), 'id')
            //     ->sortable()
            //     ->onlyOnDetail()
            // ,

            Select::make('分类', 'category_id')
                ->searchable()
                ->options($this->categoryTree())
                ->rules('required')
                ->displayUsingLabels()
            ,

            Text::make('题目标题', 'title')->rules('required'),

            Trix::make('题干描述', 'description')->placeholder('没有可不填'),

            Select::make('难度', 'difficulty')->options($difficulty)
                ->sortable()
                ->rules('required')
                ->default(function () {
                    return QuestionEnum::DIFFICULTY_EASY;
                })
                ->displayUsingLabels()
            ,

            Select::make( '题型', 'pattern')
                ->options($patterns)
                ->rules('required')
                ->default(function () {
                    return QuestionEnum::PATTERN_RADIO_CHOICE;
                })
                ->displayUsingLabels()
            ,

            // 单选
            NovaDependencyContainer::make([
                KeyValue::make('选择项', 'option_answer')
                    ->rules('json')
                    ->keyLabel('选项') // Customize the key heading
                    ->valueLabel('内容') // Customize the value heading
                    ->actionText('添加选项')
                    ->withMeta([
                        'value' => $this->option_answer ?? [
                                'A' => '',
                                'B' => '',
                                'C' => '',
                                'D' => '',
                            ]
                    ])->rules('required')
                ,

                Text::make('答案', 'right_answer')
                    ->placeholder('比如填：A')
                    ->rules('required')
                ,
            ])
                ->dependsOn('pattern', QuestionEnum::PATTERN_RADIO_CHOICE)
            ,

            // 多选
            NovaDependencyContainer::make([
                KeyValue::make('选择项', 'option_answer')
                    ->rules('json')
                    ->keyLabel('选项') // Customize the key heading
                    ->valueLabel('内容') // Customize the value heading
                    ->actionText('添加选项')
                    ->withMeta([
                        'value' => $this->option_answer ?? [
                                'A' => '',
                                'B' => '',
                                'C' => '',
                                'D' => '',
                                'E' => '',
                                'F' => '',
                                'G' => '',
                            ]
                    ])->rules('required')
                ,

                Text::make('答案', 'right_answer')
                    ->placeholder('比如填：ABC')
                    ->rules('required')
                ,
            ])
                ->dependsOn('pattern', QuestionEnum::PATTERN_MULTI_CHOICE)
            ,

            // 判断
            NovaDependencyContainer::make([
                Select::make('答案', 'right_answer')->options([
                    1 => '正确',
                    0 => '错误',
                ])->rules('required'),
            ])
                ->dependsOn('pattern', QuestionEnum::PATTERN_JUDGE_CHOICE)
            ,

            // 填空，简答
            NovaDependencyContainer::make([
                Text::make('答案', 'right_answer')->rules('required'),
            ])
                ->dependsOn('pattern', QuestionEnum::PATTERN_GAP_FILLING)
                ->dependsOn('pattern', QuestionEnum::PATTERN_SHORT_ANSWER)
            ,

            Textarea::make('解析', 'analysis'),
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
        return '题目';
    }
}
