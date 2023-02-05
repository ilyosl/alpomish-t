<?php

namespace App\Admin\Controllers;

use App\Models\KatokServiceModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class KatokServiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Секции';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new KatokServiceModel());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Название'));
        $grid->column('work_week', __('Дни'));
        $grid->column('work_time', __('Время'));
        $grid->column('coach_fio', __('Тренер'));
        $grid->column('img_url', __('Рисунок'))->image();
        $grid->column('created_at', __('Дата создание'));
//        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(KatokServiceModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('work_week', __('Work week'));
        $show->field('work_time', __('Work time'));
        $show->field('coach_fio', __('Coach fio'));
        $show->field('img_url', __('Img url'))->image();
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
        $form = new Form(new KatokServiceModel());

        $form->text('name', __('Name'));
        $form->text('work_week', __('Work week'));
        $form->text('work_time', __('Work time'));
        $form->text('coach_fio', __('Coach fio'));
        $form->file('img_url', __('Img url'));

        return $form;
    }
}
