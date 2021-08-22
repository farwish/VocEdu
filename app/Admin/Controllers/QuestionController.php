<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\CategoryTrait;
use App\Admin\Traits\ChapterTrait;
use App\Enums\PatternEnum;
use App\Enums\QuestionEnum;
use App\Models\Pattern;
use App\Models\Pattern as PatternModel;
use App\Models\Question;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Collection;

class QuestionController extends AdminController
{
    use CategoryTrait;
    use ChapterTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Question';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Question());

        $grid->quickSearch('title');

        $categoryHref = sprintf('/%s/categories/', config('admin.route.prefix'));
        $chapterHref = sprintf('/%s/chapters/', config('admin.route.prefix'));

        $grid->column('id', __('Id'));

        $grid->column('title', __('Title'))->editable('textarea');

        $grid->column('description', __('Description'))->editable('textarea');

        $grid->column('difficulty', __('Difficulty'))->editable('select', QuestionEnum::$difficulty);

        $grid->column('pattern_id', __('Pattern id'))->editable('select', Pattern::all()->pluck('name', 'id'));

        // $grid->column('option_answer', __('Option answer'));

        $grid->column('right_answer', __('Right answer'))->editable();

        $grid->column('analysis', __('Analysis'))->editable('textarea');

        $grid->column('sort', __('Sort'))->editable();

        $grid->column('category_id', __('Category id'))->display(function () {
            return $this->category()->first()->name;
        })->link(function () use ($categoryHref) {
            return $categoryHref . $this->category_id;
        });

        $grid->column('chapter_id', __('Chapter id'))->display(function () {
            return $this->chapter()->first()->name;
        })->link(function () use ($chapterHref) {
            return $chapterHref . $this->chapter_id;
        });

        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Question::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('difficulty', __('Difficulty'))->using(QuestionEnum::$difficulty);
        $show->field('pattern_id', __('Pattern id'))->as(function ($patternId) {
            return Pattern::query()->find($patternId)->name;
        });
        $show->field('option_answer', __('Option answer'))->json();
        $show->field('right_answer', __('Right answer'));
        $show->field('analysis', __('Analysis'));
        $show->field('sort', __('Sort'));

        $show->field('category_id', __('Category id'))->as(function ($categoryId) {
            return $this->category()->first()->name;
        });

        $show->field('chapter_id', __('Chapter id'))->as(function ($categoryId) {
            return $this->chapter()->first()->name;
        });

        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Question());

        /** @var \Illuminate\Database\Eloquent\Collection $patternCollection */
        $patternCollection = Pattern::query()->get();
        $patternArray = $patternCollection->pluck('name', 'id')->toArray();

        $subjective_pattern_ids =
        $objective_classify_radio_pattern_ids =
        $objective_classify_multi_pattern_ids =
        $objective_classify_judge_pattern_ids =
        $objective_classify_const_pattern_ids =
        $objective_classify_short_pattern_ids = [];

        if ($patternCollection->isNotEmpty()) {
            /** @var Pattern $item */
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
                        // case PatternEnum::OBJECTIVE_CLASSIFY_DRIFT:
                        //     $objective_classify_drift_pattern_ids[] = $patternId;
                        //     break;
                        case PatternEnum::OBJECTIVE_CLASSIFY_JUDGE:
                            $objective_classify_judge_pattern_ids[] = $patternId;
                            break;
                        case PatternEnum::OBJECTIVE_CLASSIFY_CONST:
                            $objective_classify_const_pattern_ids[] = $patternId;
                            break;
                        case PatternEnum::OBJECTIVE_CLASSIFY_SHORT:
                            $objective_classify_short_pattern_ids[] = $patternId;
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        $form->textarea('title', __('Title'))->required();

        $form->textarea('description', __('Description'));

        $form->select('difficulty', __('Difficulty'))
            ->options(QuestionEnum::$difficulty)
            ->required()
        ;

        $form->select('pattern_id', __('Pattern id'))
            ->options($patternArray)
            ->required()
            ->when('in', $objective_classify_radio_pattern_ids, function (Form $form) {
                $form->keyValue('option_answer',  __('Option answer'))
                    ->default([
                        'A' => '',
                        'B' => '',
                        'C' => '',
                        'D' => '',
                    ])
                    ->value([
                        'A' => '',
                        'B' => '',
                        'C' => '',
                        'D' => '',
                    ])
                    ->required();

                $form->text('right_answer', __('Right answer'))
                    ->required();
            })
            ->when('in', $objective_classify_multi_pattern_ids, function (Form $form) {
                $form->keyValue('option_answer',  __('Option answer'))
                    ->default([
                        'A' => '',
                        'B' => '',
                        'C' => '',
                        'D' => '',
                        'E' => '',
                        'F' => '',
                    ])
                    ->value([
                        'A' => '',
                        'B' => '',
                        'C' => '',
                        'D' => '',
                        'E' => '',
                        'F' => '',
                    ])
                    ->required();

                $form->text('right_answer', __('Right answer'))
                    ->required();
            })
            ->when('in', $objective_classify_judge_pattern_ids, function (Form $form) {
                $form->radio('right_answer', __('Right answer'))
                    ->options(QuestionEnum::$judgeAnswer)
                    ->default(QuestionEnum::ANSWER_RIGHT)
                    ->required();
            })
            ->when('in', $objective_classify_const_pattern_ids, function (Form $form) {
                $form->textarea('right_answer', __('Right answer'))
                    ->required();
            })
            ->when('in', $subjective_pattern_ids, function (Form $form) {
                $form->textarea('right_answer', __('Right answer'));
            })
        ;

        $form->textarea('analysis', __('Analysis'));

        $form->number('sort', __('Sort'))->default(0);

        $form->select('category_id', __('Category id'))
            ->options($this->categoryTree())->rules('required')
            // 切换时动态加载
            ->load('chapter_id', '/admin/api/chapters')
        ;

        $form->select('chapter_id', __('Chapter id'))->options(function ($chapterId) {
            $questionId = $this->id;

            // 新增时不展示，必须要先选择科目
            if (!$questionId) {
                return [];
            }

            $question = Question::query()->find($questionId);

            return self::chapterTree($question->getAttribute('category_id'));
        })->required();

        return $form;
    }
}
