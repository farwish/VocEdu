<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->quickSearch('name');

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('exam_time', __('Exam time'));
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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('exam_time', __('Exam time'));
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
        $form = new Form(new Category());

        $form->text('name', __('Name'));
        $form->datetime('exam_time', __('Exam time'))->default(date('Y-m-d H:i:s'));
        $form->number('_lft', __(' lft'));
        $form->number('_rgt', __(' rgt'));
        $form->number('parent_id', __('Parent id'));

        return $form;
    }
}
