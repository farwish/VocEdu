<?php

namespace App\Admin\Controllers;

use App\Models\Member;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MemberController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Member());

        $grid->quickSearch('mobile');

        $grid->column('id', __('Id'));

        $grid->column('mobile', __('Mobile'));

        $grid->column('email', __('Email'));

        $grid->column('name', __('Name'));

        // $grid->column('password', __('Password'));

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
        $show = new Show(Member::findOrFail($id));

        $show->field('id', __('Id'));

        $show->field('mobile', __('Mobile'));

        $show->field('email', __('Email'));

        $show->field('name', __('Name'));

        // $show->field('password', __('Password'));

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
        $form = new Form(new Member());

        $form->mobile('mobile', __('Mobile'));

        $form->email('email', __('Email'));

        $form->text('name', __('Name'));

        $form->password('password', __('Password'));

        return $form;
    }
}
