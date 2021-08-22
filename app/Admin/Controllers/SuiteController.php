<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\CategoryTrait;
use App\Models\Paper;
use App\Models\Suite;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SuiteController extends AdminController
{
    use CategoryTrait;

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Suite';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Suite());

        $grid->quickSearch('name');

        $categoryHref = sprintf('/%s/categories/', config('admin.route.prefix'));

        $grid->column('id', __('Id'));

        $grid->column('name', __('Name'));

        $grid->column('category_id', __('Category id'))->display(function () {
            return $this->category()->first()->name;
        })->link(function () use ($categoryHref) {
            return $categoryHref . $this->category_id;
        });

        $grid->column('papers')->display(function ($papers) {
            $papers = array_map(function ($paper) {
                return "<span class='label label-success'>{$paper['name']}</span>";
            }, $papers);

            return join('&nbsp;', $papers);
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
        $show = new Show(Suite::findOrFail($id));

        $show->field('id', __('Id'));

        $show->field('name', __('Name'));

        $show->field('category_id', __('Category id'));

        $show->field('category_id', __('Category id'))->as(function ($categoryId) {
            return $this->category()->first()->name;
        });

        $show->papers('试卷', function ($papers) {
            $papers->name()->limit(20);
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
        $form = new Form(new Suite());

        $form->text('name', __('Name'));

        $form->select('category_id', __('Category id'))
            ->options($this->categoryTree())->rules('required')
            // 切换时动态加载试卷
            ->load('papers', '/admin/api/papers')
        ;

        $form->multipleSelect('papers', __('Papers'))->options(function ($paperIds) {
            $paperId = $this->id;

            // 新增时，不展示试卷，必须要先选择科目
            if (!$paperId) {
                return [];
            }

            $paper = Paper::query()->find($paperId);

            return Paper::query()->where('category_id', $paper->getAttribute('category_id'))->pluck('name', 'id');
        });

        return $form;
    }
}
