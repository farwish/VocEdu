<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\AppMenuTrait;
use App\Enums\AppMenuEnum;
use App\Models\AppMenu;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AppMenuController extends AdminController
{
    use AppMenuTrait;

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

        $grid->column('title', __('Title'))->display(function ($title) {
            $result = $this->withDepth()->find($this->id);
            return str_repeat('|— ', $result->depth) . $title;
        });

        $grid->column('sub_title', __('Sub title'));

        $grid->column('status', '是否展示')
            ->editable('select', AppMenuEnum::$statuses)
            ->help('禁用后不展示给用户')
        ;

        $grid->column('sub_lock', __('Sub lock'))
            ->editable('select', AppMenuEnum::$subLocks);

        $grid->column('icon', __('Icon'))
            ->help('根据 uView 的 u-icon 图标名');

        $grid->column('slug', __('Slug'));

        // $grid->column('parent_id', '上级菜单')
        //     ->using($this->appMenuTree())
        // ;

        // $grid->column('_lft', __(' lft'));
        // $grid->column('_rgt', __(' rgt'));

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
        $show = new Show(AppMenu::findOrFail($id));

        $show->field('id', __('Id'));

        $show->field('title', __('Title'));

        $show->field('sub_title', __('Sub title'));

        $show->field('status', '是否展示')->using(AppMenuEnum::$statuses);

        $show->field('sub_lock', __('Sub lock'))->using(AppMenuEnum::$subLocks);

        $show->field('icon', __('Icon'));

        // $show->field('color', __('Color'));

        $show->field('slug', __('Slug'));

        // $show->field('_lft', __(' lft'));
        // $show->field('_rgt', __(' rgt'));

        $show->field('parent_id', '上级菜单')->as(function ($parentId) {
            return AppMenu::query()->find($parentId)->title;
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
        $form = new Form(new AppMenu());

        $form->text('title', __('Title'))->required();

        $form->text('sub_title', __('Sub title'))->required();

        $form->radio('status', '是否展示')
            ->options(AppMenuEnum::$statuses)
            ->default(AppMenuEnum::STATUS_NORMAL)
            ->required()
        ;

        $form->radio('sub_lock', __('Sub lock'))
            ->options(AppMenuEnum::$subLocks)
            ->default(AppMenuEnum::SUB_LOCK_NORMAL)
            ->required()
        ;

        $form->text('icon', __('Icon'))->required();

        // $form->color('color', __('Color'));

        $form->text('slug', __('Slug'))->required();

        // $form->number('_lft', __(' lft'));
        // $form->number('_rgt', __(' rgt'));

        $form->select('parent_id', '上级菜单')
            ->options($this->appMenuTree())
        ;

        return $form;
    }
}
