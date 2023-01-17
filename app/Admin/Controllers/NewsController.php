<?php

namespace App\Admin\Controllers;

use App\Models\NewsModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'NewsModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NewsModel());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('short_text', __('Short text'));
        $grid->column('desc', __('Desc'));
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
        $show = new Show(NewsModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('short_text', __('Short text'));
        $show->field('desc', __('Desc'));
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
        $form = new Form(new NewsModel());

        $form->text('title', __('Title'));
        $form->text('short_text', __('Short text'));
        $form->textarea('desc', __('Desc'));
        $form->number('status', __('Status'));

        return $form;
    }
}
