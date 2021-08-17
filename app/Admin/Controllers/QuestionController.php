<?php

namespace App\Admin\Controllers;

use App\Models\Question;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class QuestionController extends AdminController
{
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

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('description', __('Description'));
        $grid->column('difficulty', __('Difficulty'));
        $grid->column('pattern_id', __('Pattern id'));
        $grid->column('option_answer', __('Option answer'));
        $grid->column('right_answer', __('Right answer'));
        $grid->column('analysis', __('Analysis'));
        $grid->column('sort', __('Sort'));
        $grid->column('category_id', __('Category id'));
        $grid->column('chapter_id', __('Chapter id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show->field('difficulty', __('Difficulty'));
        $show->field('pattern_id', __('Pattern id'));
        $show->field('option_answer', __('Option answer'));
        $show->field('right_answer', __('Right answer'));
        $show->field('analysis', __('Analysis'));
        $show->field('sort', __('Sort'));
        $show->field('category_id', __('Category id'));
        $show->field('chapter_id', __('Chapter id'));
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

        $form->textarea('title', __('Title'));
        $form->textarea('description', __('Description'));
        $form->switch('difficulty', __('Difficulty'));
        $form->number('pattern_id', __('Pattern id'));
        $form->text('option_answer', __('Option answer'));
        $form->text('right_answer', __('Right answer'));
        $form->text('analysis', __('Analysis'));
        $form->number('sort', __('Sort'));
        $form->number('category_id', __('Category id'));
        $form->number('chapter_id', __('Chapter id'));

        return $form;
    }
}
