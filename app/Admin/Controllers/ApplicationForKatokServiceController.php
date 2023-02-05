<?php

namespace App\Admin\Controllers;

use App\Models\ApplicationForKatokServiceModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ApplicationForKatokServiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Запись на секцию';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ApplicationForKatokServiceModel());

        $grid->column('id', __('Id'));
//        $grid->katok()->name();
        $grid->column('katok.name', __('название секцию'));
        $grid->column('first_name', __('Имя'));
        $grid->column('last_name', __('Фамилия'));
        $grid->column('phone', __('Номер'));
        $grid->column('comment', __('Коментарий'));
        $grid->column('status', __('Статус'));
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
        $show = new Show(ApplicationForKatokServiceModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('katok_service_id', __('Katok service id'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('phone', __('Phone'));
        $show->field('comment', __('Comment'));
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
        $form = new Form(new ApplicationForKatokServiceModel());

        $form->number('katok_service_id', __('Katok service id'));
        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->mobile('phone', __('Phone'));
        $form->textarea('comment', __('Comment'));
        $form->number('status', __('Status'));

        return $form;
    }
}
