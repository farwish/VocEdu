<?php

namespace App\Admin\Controllers;

use App\Enums\PatternEnum;
use App\Models\Pattern;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PatternController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pattern';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Pattern());

        $grid->column('id', __('Id'));

        $grid->column('name', __('Name'));

        $grid->column('type', __('Type'))->editable('select', PatternEnum::$patternType);

        $grid->column('classify', __('Classify'))->using(PatternEnum::$objectiveClassify);

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
        $show = new Show(Pattern::findOrFail($id));

        $show->field('id', __('Id'));

        $show->field('name', __('Name'));

        $show->field('type', __('Type'))->using(PatternEnum::$patternType);

        $show->field('classify', __('Classify'))->using(PatternEnum::$objectiveClassify);

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
        $form = new Form(new Pattern());

        $form->text('name', __('Name'));
        $form->select('type', __('Type'))->options(PatternEnum::$patternType);
        $form->select('classify', __('Classify'))->options(PatternEnum::$objectiveClassify);

        return $form;
    }
}
