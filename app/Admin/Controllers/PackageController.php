<?php

namespace App\Admin\Controllers;

use App\Models\Package;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PackageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Package';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Package());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('explain', __('Explain'));
        $grid->column('price', __('Price'));
        $grid->column('ori_price', __('Ori price'));
        $grid->column('expire_mode', __('Expire mode'));
        $grid->column('duration', __('Duration'));
        $grid->column('list_status', __('List status'));
        $grid->column('list_on_datetime', __('List on datetime'));
        $grid->column('list_off_datetime', __('List off datetime'));
        $grid->column('sort', __('Sort'));
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
        $show = new Show(Package::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('explain', __('Explain'));
        $show->field('price', __('Price'));
        $show->field('ori_price', __('Ori price'));
        $show->field('expire_mode', __('Expire mode'));
        $show->field('duration', __('Duration'));
        $show->field('list_status', __('List status'));
        $show->field('list_on_datetime', __('List on datetime'));
        $show->field('list_off_datetime', __('List off datetime'));
        $show->field('sort', __('Sort'));
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
        $form = new Form(new Package());

        $form->text('name', __('Name'));
        $form->text('explain', __('Explain'));
        $form->number('price', __('Price'));
        $form->number('ori_price', __('Ori price'));
        $form->switch('expire_mode', __('Expire mode'));
        $form->number('duration', __('Duration'));
        $form->switch('list_status', __('List status'))->default(1);
        $form->datetime('list_on_datetime', __('List on datetime'))->default(date('Y-m-d H:i:s'));
        $form->datetime('list_off_datetime', __('List off datetime'))->default(date('Y-m-d H:i:s'));
        $form->number('sort', __('Sort'));
        $form->number('category_id', __('Category id'));

        return $form;
    }
}
