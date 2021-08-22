<?php

namespace App\Admin\Controllers;

use App\Admin\Traits\CategoryTrait;
use App\Enums\PackageEnum;
use App\Models\Package;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PackageController extends AdminController
{
    use CategoryTrait;

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

        $grid->quickSearch('name');

        $categoryHref = sprintf('/%s/categories/', config('admin.route.prefix'));

        $grid->column('id', __('Id'));
        $grid->column('category_id', '所属科目')->display(function () {
            return $this->category()->first()->name;
        })->link(function () use ($categoryHref) {
            return $categoryHref . $this->category_id;
        });
        $grid->column('name', __('Name'))->editable();
        $grid->column('explain', __('Explain'))->editable('textarea');
        $grid->column('price', __('Price'))->editable();
        $grid->column('ori_price', __('Ori price'))->editable();
        $grid->column('expire_mode', __('Expire mode'))->editable('select', PackageEnum::$expireModes);
        $grid->column('duration', __('Duration'))->help('仅对 固定时间期限 有效')->editable();
        $grid->column('list_status', __('List status'))->editable('select', PackageEnum::$listStatuses);
        $grid->column('list_on_datetime', __('List on datetime'))->editable('datetime');
        $grid->column('list_off_datetime', __('List off datetime'))->editable('datetime');
        $grid->column('sort', __('Sort'))->editable();
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
        $show = new Show(Package::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_id', '所属科目')->using($this->categoryTree());
        $show->field('name', __('Name'));
        $show->field('explain', __('Explain'));
        $show->field('price', __('Price'));
        $show->field('ori_price', __('Ori price'));
        $show->field('expire_mode', __('Expire mode'))->using(PackageEnum::$expireModes);
        $show->field('duration', __('Duration'));
        $show->field('list_status', __('List status'))->using(PackageEnum::$listStatuses);
        $show->field('list_on_datetime', __('List on datetime'));
        $show->field('list_off_datetime', __('List off datetime'));
        $show->field('sort', __('Sort'));
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

        $form->select('category.id', '所属科目')
            ->options($this->categoryTree())
            ->required();

        $form->text('name', __('Name'))
            ->required();

        $form->text('explain', __('Explain'))
            ->required();

        $form->number('price', __('Price'))
            ->required();

        $form->number('ori_price', __('Ori price'))
            ->help('不填写默认和售价一致');

        $form->radio('expire_mode', __('Expire mode'))
            ->options(PackageEnum::$expireModes)
            ->when(PackageEnum::EXPIRE_MODE_FIXED, function (Form $form) {
                $form->number('duration', __('Duration'))->required();
            })
            ->when(PackageEnum::EXPIRE_MODE_DYNAMIC, function (Form $form) {
            })
            ->default(PackageEnum::EXPIRE_MODE_FIXED)
            ->required();

        $form->radio('list_status', __('List status'))
            ->options(PackageEnum::$listStatuses)
            ->when(PackageEnum::LIST_STATUS_NORMAL, function (Form $form) {
                $form->datetime('list_off_datetime', __('List off datetime'))->default(date('Y-m-d H:i:s'));
            })
            ->when(PackageEnum::LIST_STATUS_DISABLED, function (Form $form) {
                $form->datetime('list_off_datetime', __('List off datetime'))->default(date('Y-m-d H:i:s'));
                $form->datetime('list_on_datetime', __('List on datetime'))->default(date('Y-m-d H:i:s'));
            })
            ->default(PackageEnum::LIST_STATUS_NORMAL)
            ->required();

        $form->number('sort', __('Sort'));

        return $form;
    }
}
