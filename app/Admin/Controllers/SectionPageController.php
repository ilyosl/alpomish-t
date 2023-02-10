<?php

namespace App\Admin\Controllers;

use App\Models\SectionPageModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SectionPageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'SectionPageModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SectionPageModel());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('content', __('Content'));
        $grid->column('img_url', __('Img url'))->image();
//        $grid->column('images', __('Images'))->image();
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
        $show = new Show(SectionPageModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('content', __('Content'));
        $show->field('img_url', __('Img url'));
        $show->field('images', __('Images'));
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
        $form = new Form(new SectionPageModel());

        $form->text('name', __('Name'));
        $form->summernote('content', __('Content'));
        $form->file('img_url', __('Img url'));
        $form->text('images', __('Images'));

        return $form;
    }
}
