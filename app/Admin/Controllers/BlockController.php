<?php

namespace App\Admin\Controllers;

use App\Models\BlocksModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BlockController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'BlocksModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BlocksModel());

        $grid->column('id', __('Id'));
        $grid->column('name_block', __('Name block'));
        $grid->column('count_place', __('Count place'));
        $grid->column('count_rows', __('Count rows'));
        $grid->column('price_info', __('Price info'));
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
        $show = new Show(BlocksModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name_block', __('Name block'));
        $show->field('count_place', __('Count place'));
        $show->field('count_rows', __('Count rows'));
        $show->field('price_info', __('Price info'));
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
        $form = new Form(new BlocksModel());

        $form->text('name_block', __('Name block'));
        $form->text('count_place', __('Count place'));
        $form->text('count_rows', __('Count rows'));
        $form->text('price_info', __('Price info'));

        return $form;
    }
}
