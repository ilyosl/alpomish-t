<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\EventPlaceForm;
use App\Models\EventPlaceModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EventPlaceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'EventPlaceModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EventPlaceModel());
        $grid->disableCreateButton();
        $grid->column('id', __('Id'));
        $grid->column('place', __('Place'));
        $grid->column('row', __('Row'));
        $grid->column('event_id', __('Event id'));
        $grid->column('price', __('Price'));
        $grid->column('block_name', __('Block name'));
        $grid->column('event_time', __('Event time'));
        $grid->column('event_date', __('Event date'));
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
        $show = new Show(EventPlaceModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('place', __('Места'));
        $show->field('row', __('Ряд'));
        $show->field('event_id', __('Event id'));
        $show->field('price', __('Price'));
        $show->field('block_name', __('Block name'));
        $show->field('event_time', __('Event time'));
        $show->field('event_date', __('Event date'));
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
        $form = new EventPlaceForm();
//        $form = new Form(new EventPlaceModel());

//        $form->number('place', __('Place'));
//        $form->number('row', __('Row'));
//        $form->number('event_id', __('Event id'));
//        $form->number('price', __('Price'));
//        $form->text('block_name', __('Block name'));
//        $form->text('event_time', __('Event time'));
//        $form->date('event_date', __('Event date'))->default(date('Y-m-d'));
//        $form->number('status', __('Status'));

        return $form;
    }
}
