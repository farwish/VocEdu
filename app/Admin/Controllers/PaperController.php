<?php

namespace App\Admin\Controllers;

use App\Models\Paper;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PaperController extends AdminController
{
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

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('total_score', __('Total score'));
        $grid->column('pass_score', __('Pass score'));
        $grid->column('minutes', __('Minutes'));
        $grid->column('category_id', __('Category id'));
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
        $show = new Show(Paper::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('total_score', __('Total score'));
        $show->field('pass_score', __('Pass score'));
        $show->field('minutes', __('Minutes'));
        $show->field('category_id', __('Category id'));
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
        $form = new Form(new Paper());

        $form->text('name', __('Name'));
        $form->number('total_score', __('Total score'));
        $form->number('pass_score', __('Pass score'));
        $form->number('minutes', __('Minutes'));
        $form->number('category_id', __('Category id'));

        return $form;
    }
}
