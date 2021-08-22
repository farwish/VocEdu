<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\CategoryTrait;
use App\Admin\Traits\ChapterTrait;
use App\Enums\ChapterEnum;
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
    protected $title = '章节';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Chapter());

        $grid->quickSearch('name');

        $categoryHref = sprintf('/%s/categories/', config('admin.route.prefix'));

        $grid->column('id', __('Id'));

        $grid->column('name', __('Name'))->display(function ($name) {
            $result = $this->withDepth()->find($this->id);
            return str_repeat('|— ', $result->depth) . $result->name;
        });

        $grid->column('category_id', __('Category id'))->display(function () {
            return $this->category()->first()->name;
        })->link(function () use ($categoryHref) {
            return $categoryHref . $this->category_id;
        });

        $grid->column('status', '章节是否禁用')->editable('select', ChapterEnum::$statuses)
            ->help('禁用后不展示给用户');

        $grid->column('sub_lock', '子章节是否锁定')->editable('select', ChapterEnum::$subLocks)
            ->help('锁定后表示需要购买套餐后才能进入子章节');

        $grid->column('free_question_num', '免费题量')->editable();

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

        $show->field('parent_id', '上级章节')->as(function ($parentId) {
            $c = Chapter::find($parentId);
            return $c ? $c->name : '';
        });

        $show->field('name', __('Name'));

        $show->field('category_id', __('Category id'))->as(function ($categoryId) {
            return $this->category()->first()->name;
        });

        $show->field('status', '章节是否禁用')->using(ChapterEnum::$statuses);

        $show->field('sub_lock', '子章节是否锁定')->using(ChapterEnum::$subLocks);

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
        $form = new Form(new Chapter());

        $form->select('parent_id', '上级章节')
            ->options(self::chapterTree(null))
        ;

        $form->text('name', __('Name'))->rules('required');

        $form->select('category_id', __('Category id'))->options($this->categoryTree())->rules('required');

        $form->radio('status', '章节是否禁用')->options(ChapterEnum::$statuses)
            ->default(ChapterEnum::STATUS_NORMAL)
            ->help('禁用后不展示给用户');

        $form->radio('sub_lock', '子章节是否锁定')->options(ChapterEnum::$subLocks)
            ->default(ChapterEnum::SUB_LOCK_NORMAL)
            ->help('锁定后表示需要购买套餐后才能进入子章节');

        $form->number('free_question_num', '免费题量')->help('只对最后一级生效');

        // $form->number('_lft', __(' lft'));
        // $form->number('_rgt', __(' rgt'));

        return $form;
    }
}
