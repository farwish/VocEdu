<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\CategoryTrait;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('exam_time', __('Exam time'))->display(function ($examTime) {
            return (new \DateTime($examTime))->format('Y-m-d H:i:s') ?: '—';
        });

        $grid->column('chapters', __('Chapters'))->display(function ($chapters) {
            return count($chapters);
        });
        $grid->column('packages', __('Packages'))->display(function ($packages) {
            return count($packages);
        });
        $grid->column('suites', __('Suites'))->display(function ($suites) {
            return count($suites);
        });
        $grid->column('papers', __('Papers'))->display(function ($papers) {
            return count($papers);
        });
        $grid->column('questions', __('Questions'))->display(function ($questions) {
            return count($questions);
        });
        $grid->column('articles', __('Articles'))->display(function ($articles) {
            return count($articles);
        });
        $grid->column('videos', __('Videos'))->display(function ($videos) {
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
            $c = Category::find($parentId);
            return $c ? $c->name : '';
        });

        $show->field('name', __('Name'));

        $show->field('exam_time', __('Exam time'));

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

        $form->select('parent_id', '上级分类')
            ->options($this->categoryTree());

        $form->text('name', __('Name'))->rules(['required']);

        $form->datetime('exam_time', __('Exam time'))
            ->help('可对考试分类进行设置考试时间')
            ->default(date('Y-m-d H:i:s'));

        // $form->number('_lft', __(' lft'));
        // $form->number('_rgt', __(' rgt'));
        // $form->number('parent_id', __('Parent id'));

        return $form;
    }
}
