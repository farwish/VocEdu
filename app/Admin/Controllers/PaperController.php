<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\CategoryTrait;
use App\Models\Paper;
use App\Models\Question;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PaperController extends AdminController
{
    use CategoryTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Paper';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Paper());

        $grid->quickSearch('name');

        $categoryHref = sprintf('/%s/categories/', config('admin.route.prefix'));

        $grid->column('id', __('Id'));

        $grid->column('name', __('Name'));

        $grid->column('category_id', '所属科目')->display(function () {
            return $this->category()->first()->name;
        })->link(function () use ($categoryHref) {
            return $categoryHref . $this->category_id;
        });

        $grid->column('total_score', __('Total score'));

        $grid->column('pass_score', __('Pass score'));

        $grid->column('minutes', __('Minutes'));

        $grid->column('questions', '题量')->display(function ($questions) {
            return count($questions);
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
        $show = new Show(Paper::findOrFail($id));

        $show->field('id', __('Id'));

        $show->field('name', __('Name'));

        $show->field('category_id', '所属科目')->as(function ($categoryId) {
            return $this->category()->first()->name;
        });

        $show->field('total_score', __('Total score'));

        $show->field('pass_score', __('Pass score'));

        $show->field('minutes', __('Minutes'));

        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        $show->questions(__('Questions'), function ($questions) {
            return $questions->title();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Paper());

        $form->text('name', __('Name'));

        $form->select('category_id', '所属科目')
            ->options($this->categoryTree())->rules('required')
            ->load('questions', '/admin/api/questions')
        ;

        $form->number('total_score', __('Total score'));

        $form->number('pass_score', __('Pass score'));

        $form->number('minutes', __('Minutes'));

        $form->multipleSelect('questions', __('Questions'))->options(function ($questionIds) {
            $questionId = $this->id;

            // 新增时不展示，必须要先选择科目
            if (!$questionId) {
                return [];
            }

            $question = Question::query()->find($questionId);

            return Question::query()->where('category_id', $question->getAttribute('category_id'))->pluck('title', 'id');
        });

        return $form;
    }
}
