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

        $grid->quickSearch('name');

        $grid->column('id', __('Id'));

        $grid->column('name', __('Name'))->display(function ($name) {
            $result = $this->withDepth()->find($this->id);
            return str_repeat('|— ', $result->depth) . $result->name;
        });

        $grid->column('category_id', '所属科目分类')->display(function ($categoryId) {
            return $this->category()->first()->name;
        });

        $grid->column('status', '本章节不禁用')->display(function ($status) {
            return $status === 0 ? "<span class='label label-info'>√</span>" : "<span class='label label-warning'>×</span>";
        });
        $grid->column('sub_lock', '子章节不锁定')->display(function ($subLock) {
            return $subLock === 0 ? "<span class='label label-info'>√</span>" : "<span class='label label-warning'>×</span>";
        });

        $grid->column('free_question_num', '免费题量');

        $grid->column('questions', '总题量')->display(function ($questions) {
            return count($questions);
        });

        // $grid->column('_lft', __(' lft'));
        // $grid->column('_rgt', __(' rgt'));
        // $grid->column('parent_id', __('Parent id'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

        $grid->model()->newQuery()->withDepth()->defaultOrder();

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
        $show->field('category_id', '所属科目分类')->as(function ($categoryId) {
            return $this->category()->first()->name;
        });
        $show->field('name', __('Name'));
        $show->field('status', '本章节不禁用');
        $show->field('sub_lock', '子章节不锁定');
        $show->field('free_question_num', '免费题量');
        // $show->field('_lft', __(' lft'));
        // $show->field('_rgt', __(' rgt'));
        // $show->field('parent_id', __('Parent id'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $states = [
            'on'  => ['value' => 0, 'text' => '打开', 'color' => 'success'],
            'off' => ['value' => 1, 'text' => '关闭', 'color' => 'danger'],
        ];

        $form = new Form(new Chapter());

        $form->select('category.id', '所属科目分类')->options($this->categoryTree());
        $form->select('parent_id', '上级章节')->options($this->chapterTree(null));
        $form->text('name', __('Name'))->rules('required');
        $form->switch('status', '本章节不禁用')->states($states)->help('禁用后不展示给用户');
        $form->switch('sub_lock', '子章节不锁定')->states($states)->help('锁定后表示需要购买套餐后才能进入子章节');
        $form->number('free_question_num', '免费题量')->help('只对最后一级生效');
        // $form->number('_lft', __(' lft'));
        // $form->number('_rgt', __(' rgt'));
        // $form->number('parent_id', __('Parent id'));
        // $form->number('category_id', __('Category id'));

        return $form;
    }
}
