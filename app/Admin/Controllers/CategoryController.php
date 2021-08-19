<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\CategoryTrait;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Carbon;

class CategoryController extends AdminController
{
    use CategoryTrait;

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

        $grid->column('id', 'Id');

        $grid->column('name', __('Name'))->display(function ($name) {
            // withDepth: https://github.com/lazychaser/laravel-nestedset#including-node-depth
            // $this: https://laravel-admin.org/docs/zh/1.x/model-grid#%E4%BF%AE%E6%94%B9%E6%98%BE%E7%A4%BA%E8%BE%93%E5%87%BA
            $result = $this->withDepth()->find($this->id);
            return str_repeat('|— ', $result->depth) . $result->name;
        });

        $grid->column('exam_time', '考试时间')->display(function ($examTime) {
            return $examTime ?: '—';
        });

        $grid->column('chapters', '章节')->display(function ($chapters) {
            return count($chapters);
        });
        $grid->column('packages', '套餐')->display(function ($packages) {
            return count($packages);
        });
        $grid->column('suites', '试卷组')->display(function ($suites) {
            return count($suites);
        });
        $grid->column('papers', '试卷')->display(function ($papers) {
            return count($papers);
        });
        $grid->column('questions', '题目')->display(function ($questions) {
            return count($questions);
        });
        $grid->column('articles', '文章')->display(function ($articles) {
            return count($articles);
        });
        $grid->column('videos', '视频')->display(function ($videos) {
            return count($videos);
        });

        // $grid->column('_lft', __(' lft'));
        // $grid->column('_rgt', __(' rgt'));
        // $grid->column('parent_id', __('Parent id'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

        // https://github.com/lazychaser/laravel-nestedset#including-node-depth
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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('parent_id', '上级分类')->as(function ($parentId) {
            return Category::find($parentId)->name;
        });
        $show->field('name', __('Name'));
        $show->field('exam_time', '考试时间');
        // $show->field('_lft', __(' lft'));
        // $show->field('_rgt', __(' rgt'));
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

        $form->select('parent_id', '上级分类')->options($this->categoryTree());
        $form->text('name', '名称')->rules(['required']);
        $form->datetime('exam_time', '考试时间')
            ->help('可对考试分类进行设置考试时间')
            ->default(date('Y-m-d H:i:s'));
        // $form->number('_lft', __(' lft'));
        // $form->number('_rgt', __(' rgt'));
        // $form->number('parent_id', __('Parent id'));

        return $form;
    }
}
