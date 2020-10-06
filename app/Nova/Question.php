<?php

namespace App\Nova;

use App\Models\Pattern as PatternModel;
use App\Enums\PatternEnum;
use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use App\Enums\QuestionEnum;
use App\Models\Question as QuestionModel;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
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

    public static $searchRelations = [
        'chapter' => ['id', 'name'],
        'chapter.category' => ['id', 'name'],
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $objective_classify_radio_pattern_ids =
        $objective_classify_multi_pattern_ids =
        $objective_classify_drift_pattern_ids =
        $objective_classify_judge_pattern_ids =
        $objective_classify_const_pattern_ids =
        $subjective_pattern_ids = [];

        // 题型id按选项分类 归类到以上变量中.
        /** @var Collection $patternCollection */
        $patternCollection = PatternModel::query()->get();
        $patternArray = $patternCollection->pluck('name', 'id')->toArray();

        if ($patternCollection->isNotEmpty()) {
            /** @var PatternModel $item */
            foreach ($patternCollection as $item) {
                $patternId = $item->getAttribute('id');
                $patternType = $item->getAttribute('type');
                $patternClassify = $item->getAttribute('classify');

                if ($patternType == PatternEnum::TYPE_SUBJECTIVE) {
                    $subjective_pattern_ids[] = $patternId;
                } else {
                    switch ($patternClassify) {
                        case PatternEnum::OBJECTIVE_CLASSIFY_RADIO:
                            $objective_classify_radio_pattern_ids[] = $patternId;
                            break;
                        case PatternEnum::OBJECTIVE_CLASSIFY_MULTI:
                            $objective_classify_multi_pattern_ids[] = $patternId;
                            break;
                        case PatternEnum::OBJECTIVE_CLASSIFY_DRIFT:
                            $objective_classify_drift_pattern_ids[] = $patternId;
                            break;
                        case PatternEnum::OBJECTIVE_CLASSIFY_JUDGE:
                            $objective_classify_judge_pattern_ids[] = $patternId;
                            break;
                        case PatternEnum::OBJECTIVE_CLASSIFY_CONST:
                            $objective_classify_const_pattern_ids[] = $patternId;
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        // 单选
        $radio_container = (NovaDependencyContainer::make([
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
                ->rules('required', 'min:1', 'max:1')
            ,
        ]));
        if ($objective_classify_radio_pattern_ids) {
            foreach ($objective_classify_radio_pattern_ids as $patternId) {
                $radio_container = $radio_container->dependsOn('pattern_id', $patternId);
            }
        }

        // 多选
        $multi_container = (NovaDependencyContainer::make([
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
                ])->rules('required', 'min:1', 'max:10')
            ,

            Text::make('答案', 'right_answer')
                ->placeholder('比如填：ABC')
                ->rules('required')
            ,
        ]));
        if ($objective_classify_multi_pattern_ids) {
            foreach ($objective_classify_multi_pattern_ids as $patternId) {
                $multi_container = $multi_container->dependsOn('pattern_id', $patternId);
            }
        }

        if ($objective_classify_drift_pattern_ids) {
            foreach ($objective_classify_drift_pattern_ids as $patternId) {
                $multi_container = $multi_container->dependsOn('pattern_id', $patternId);
            }
        }

        // 判断
        $judge_container = (NovaDependencyContainer::make([
            Select::make('答案', 'right_answer')->options([
                1 => '正确',
                0 => '错误',
            ])->rules('required'),
        ]));
        if ($objective_classify_judge_pattern_ids) {
            foreach ($objective_classify_judge_pattern_ids as $patternId) {
                $judge_container = $judge_container->dependsOn('pattern_id', $patternId);
            }
        }

        // 填空
        $const_container = (NovaDependencyContainer::make([
            Text::make('答案', 'right_answer')->rules('required'),
        ]));
        if ($objective_classify_const_pattern_ids) {
            foreach ($objective_classify_const_pattern_ids as $patternId) {
                $const_container = $const_container->dependsOn('pattern_id', $patternId);
            }
        }

        // 简答
        if ($subjective_pattern_ids) {
            foreach ($subjective_pattern_ids as $patternId) {
                $const_container = $const_container->dependsOn('pattern_id', $patternId);
            }
        }

        return [
            ID::make(__('ID'), 'id')->sortable(),

            DynamicSelect::make('科目分类', 'category_id')
                ->options($this->categoryTree())
                ->rules('required')
                ->onlyOnForms()
            ,
            BelongsTo::make('科目分类', 'category', Category::class)
                ->exceptOnForms()
            ,

            DynamicSelect::make('章节知识', 'chapter_id')
                ->rules('required')
                ->onlyOnForms()
                ->dependsOn(['category_id'])
                ->options(function ($values) {
                    return $this->chapterTree($values['category_id']);
                })
            ,
            BelongsTo::make('章节知识', 'chapter', Chapter::class)                ->exceptOnForms()
                ->exceptOnForms()
            ,

            Text::make('题目标题', 'title')->rules('required'),

            Trix::make('题干描述', 'description')->placeholder('没有可不填'),

            Select::make('难度', 'difficulty')
                ->options(QuestionEnum::$difficulty)
                ->sortable()
                ->rules('required')
                ->default(function () {
                    return QuestionEnum::DIFFICULTY_EASY;
                })
                ->displayUsingLabels()
            ,

            Select::make('题型', 'pattern_id')
                ->rules('required')
                ->options($patternArray)
                ->displayUsingLabels()
            ,

            // DynamicSelect::make('题型', 'pattern_id')
            //     ->rules('required')
            //     ->dependsOn(['category_id'])
            //     ->options(function ($values) use (&$dynamicPatternIds) {
            //         $category = \App\Models\Category::query()->find($values['category_id']);
            //         if (! $category) return [];
            //
            //         /** @var Collection $patterns */
            //         $patterns = $category->patterns()->get();
            //         if ($patterns->isEmpty()) return [];
            //
            //         $dynamicPatternIds = $patterns->pluck('name', 'id')->toArray();
            //
            //         return $dynamicPatternIds;
            //     })
            // ,

            $radio_container,
            $multi_container,
            $judge_container,
            $const_container,

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
