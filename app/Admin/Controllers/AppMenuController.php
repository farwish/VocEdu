<?php

namespace App\Admin\Controllers;

use App\Models\AppMenu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AppMenuController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AppMenu';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AppMenu());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('sub_title', __('Sub title'));
        $grid->column('icon', __('Icon'));
        $grid->column('color', __('Color'));
        $grid->column('slug', __('Slug'));
        $grid->column('status', __('Status'));
        $grid->column('sub_lock', __('Sub lock'));
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
        $show = new Show(AppMenu::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('sub_title', __('Sub title'));
        $show->field('icon', __('Icon'));
        $show->field('color', __('Color'));
        $show->field('slug', __('Slug'));
        $show->field('status', __('Status'));
        $show->field('sub_lock', __('Sub lock'));
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
        $form = new Form(new AppMenu());

        $form->text('title', __('Title'));
        $form->text('sub_title', __('Sub title'));
        $form->text('icon', __('Icon'));
        $form->color('color', __('Color'));
        $form->text('slug', __('Slug'));
        $form->switch('status', __('Status'));
        $form->switch('sub_lock', __('Sub lock'));
        $form->number('_lft', __(' lft'));
        $form->number('_rgt', __(' rgt'));
        $form->number('parent_id', __('Parent id'));

        return $form;
    }
}
