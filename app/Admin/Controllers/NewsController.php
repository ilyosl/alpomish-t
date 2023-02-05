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
    protected $title = 'Новости';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NewsModel());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Название'));
        $grid->column('short_text', __('Кароткие описание'));
        $grid->column('desc', __('Контент'))->display(function ($desc){
            return $desc;
        });
        $grid->column('status', __('Статус'));
        $grid->column('image', __('Рисунок'))->image();
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
        $show->field('title', __('Название'));
        $show->field('short_text', __('Описание'));
        $show->field('desc', __('Контент'));
        $show->field('status', __('Статус'));
        $show->field('image', __('Рисунок'))->image();
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
        $form->summernote('desc', __('Desc'));
        $form->file('image', __('image'));
        $form->number('status', __('Status'));

        return $form;
    }
}
