<?php

namespace App\Admin\Controllers;

use App\Models\OrdersModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
//use Encore\Admin\Grid\Displayers\Table;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Заказы';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OrdersModel());
        $grid->disableCreateButton();
        $grid->column('id', __('Id'));
//        $grid->column('user_id', __('User id'));

        $grid->column('event.title', __('Мероприятия'));
        $grid->column('first_name', __('Имя'));
        $grid->column('last_name', __('Фамилия'));
//        $grid->column('email', __('Email'));
        $grid->column('phone', __('Телефон'));
        $grid->column('status', __('Статус'))->display(function ($status){
            switch ($status){
                case 0:
                    return '<span style="font-size:85%;" class="label label-success"> В обработке </span>';
                case 2:
                    return '<span style="font-size:85%;" class="label label-danger"> Куплено </span>';
                case 1:
                    return '<span style="font-size:85%;" class="label label-success"> В обработке </span>';

            }
        });
        $grid->column('confirm_buy', __('Дата покупке'))->display(function ($confirm_by){
            if(empty($confirm_by))
                return 'Не куплено';
        });
//        $grid->column('created_at', __('Created at'));
//        $grid->column('updated_at', __('Updated at'));
        $grid->column('payment_type', __('Тип оплаты'));
        $grid->column('count_tickets', __('Кол. билетов'))->modal('Список билетов',function ($model){
            $tickets = $model->tickets()->get()->map(function ($ticket) {
                return $ticket->only(['row', 'place', 'block_name','event_time','event_date','price']);
            });

            return new Table(['Ряд', 'Места', 'Название блока','Время','Дата','Стоимость'], $tickets->toArray());
        });
        $grid->column('summ', __('Стоимост'));
//        $grid->column('create_time', __('Create time'));
//        $grid->column('perform_time', __('Perform time'));
//        $grid->column('cancel_time', __('Cancel time'));

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
        $show = new Show(OrdersModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone'));
        $show->field('status', __('Status'));
        $show->field('confirm_buy', __('Confirm buy'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('payment_type', __('Payment type'));
        $show->field('count_tickets', __('Count tickets'));
        $show->field('summ', __('Summ'));
        $show->field('create_time', __('Create time'));
        $show->field('perform_time', __('Perform time'));
        $show->field('cancel_time', __('Cancel time'));
        $show->field('event_id', __('Event id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OrdersModel());

        $form->number('user_id', __('User id'));
        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->email('email', __('Email'));
        $form->mobile('phone', __('Phone'));
        $form->number('status', __('Status'));
        $form->datetime('confirm_buy', __('Confirm buy'))->default(date('Y-m-d H:i:s'));
        $form->text('payment_type', __('Payment type'));
        $form->number('count_tickets', __('Count tickets'));
        $form->number('summ', __('Summ'));
        $form->number('create_time', __('Create time'));
        $form->number('perform_time', __('Perform time'));
        $form->number('cancel_time', __('Cancel time'));
        $form->number('event_id', __('Event id'));

        return $form;
    }
}
