<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\CategoryTrait;
use App\Admin\Traits\ChapterTrait;
use App\Models\Chapter;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ChapterController extends AdminController
{
    use CategoryTrait;
    use ChapterTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Chapter';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Chapter());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('status', __('Status'));
        $grid->column('sub_lock', __('Sub lock'));
        $grid->column('free_question_num', __('Free question num'));
        $grid->column('category_id', __('Category id'));
        $grid->column('_lft', __(' lft'));
        $grid->column('_rgt', __(' rgt'));
        $grid->column('parent_id', __('Parent id'));
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
        $show = new Show(Chapter::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('status', __('Status'));
        $show->field('sub_lock', __('Sub lock'));
        $show->field('free_question_num', __('Free question num'));
        $show->field('category_id', __('Category id'));
        $show->field('_lft', __(' lft'));
        $show->field('_rgt', __(' rgt'));
        $show->field('parent_id', __('Parent id'));
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
        $form = new Form(new Chapter());

        $form->select('category.id')->options($this->categoryTree());
        $form->select('parent_id')->options($this->chapterTree(null));
        $form->text('name', __('Name'));
        $form->switch('status', __('Status'));
        $form->switch('sub_lock', __('Sub lock'));
        $form->number('free_question_num', __('Free question num'));
        $form->number('category_id', __('Category id'));
        $form->number('_lft', __(' lft'));
        $form->number('_rgt', __(' rgt'));
        // $form->number('parent_id', __('Parent id'));
        // $form->number('category_id', __('Category id'));

        return $form;
    }
}
