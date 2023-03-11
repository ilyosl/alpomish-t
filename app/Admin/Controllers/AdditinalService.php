<?php

namespace App\Admin\Controllers;

use App\Models\AdditionalServiceModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdditinalService extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AdditionalServiceModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdditionalServiceModel());

        $grid->column('id', __('Id'));
        $grid->column('type', __('Тип'))->display(function ($type){
            if($type ==1){
                return 'Инструктор';
            }else{
                return 'Игрушки';
            }
        });
        $grid->column('payment', __('Тип оплаты'));
        $grid->column('price', __('Стоимость'));
        $grid->column('sell_date', __('Дата продажи'));
        $grid->column('count', __('Колечество'));

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
        $show = new Show(AdditionalServiceModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('Type'));
        $show->field('payment', __('Payment'));
        $show->field('price', __('Price'));
        $show->field('sell_date', __('Sell date'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('count', __('Count'));
        $show->field('user_id', __('User id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AdditionalServiceModel());

        $form->text('type', __('Type'));
        $form->text('payment', __('Payment'));
        $form->number('price', __('Price'));
        $form->datetime('sell_date', __('Sell date'))->default(date('Y-m-d H:i:s'));
        $form->number('count', __('Count'));
        $form->number('user_id', __('User id'))->default(5);

        return $form;
    }
}
