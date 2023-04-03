<?php

namespace App\Admin\Controllers;

use App\Models\IceSubsModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class IceSubsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'IceSubsModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new IceSubsModel());

        $grid->column('id', __('Id'));
        $grid->column('name_subs', __('Name subs'));
        $grid->column('price', __('Price'));
        $grid->column('status', __('Status'));
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
        $show = new Show(IceSubsModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name_subs', __('Name subs'));
        $show->field('price', __('Price'));
        $show->field('status', __('Status'));
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
        $form = new Form(new IceSubsModel());

        $form->text('name_subs', __('Name subs'));
        $form->number('price', __('Price'));
        $form->number('status', __('Status'))->default(1);

        return $form;
    }
}
