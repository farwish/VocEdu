<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\CategoryTrait;
use App\Models\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleController extends AdminController
{
    use CategoryTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->quickSearch('name');

        $categoryHref = sprintf('/%s/categories/', config('admin.route.prefix'));

        $grid->column('id', __('Id'));

        $grid->column('title', __('Title'));

        $grid->column('body', __('Body'))->display(function ($body) {
            return mb_substr($body, 0, 30) . '...';
        })->modal(function ($model) {
            return $model->body;
        });

        $grid->column('category_id', __('Category id'))->display(function () {
            return $this->category()->first()->name;
        })->link(function () use ($categoryHref) {
            return $categoryHref . $this->category_id;
        });

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
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));

        $show->field('title', __('Title'));

        $show->field('body', __('Body'));

        $show->field('category_id', __('Category id'))->as(function ($categoryId) {
            return $this->category()->first()->name;
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
        $form = new Form(new Article());

        $form->text('title', __('Title'))->required();

        $form->textarea('body', __('Body'))->required();

        $form->select('category_id', __('Category id'))
            ->options($this->categoryTree())->rules('required')
        ;

        return $form;
    }
}
