<?php

namespace App\Admin\Controllers;

use App\Models\Events;
use App\Models\EventTime;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EventTimeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'EventTime';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EventTime());

        $grid->column('id', __('Id'));
        $grid->column('event_id', __('Event id'));
        $grid->column('eventDate', __('EventDate'));
        $grid->column('eventTime', __('EventTime'));
        $grid->column('status', __('Status'));

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
        $show = new Show(EventTime::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('event_id', __('Event id'));
        $show->field('eventDate', __('EventDate'));
        $show->field('eventTime', __('EventTime'));
        $show->field('status', __('Status'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new EventTime());

        $form->select('event_id', __('Event id'))->options(Events::all()->pluck('title','id'))->required();
        $form->date('eventDate', __('EventDate'))->default(date('Y-m-d'));
        $form->time('eventTime', __('EventTime'))->default(date('H:i'));
        $form->number('status', __('Status'))->default(0);

        return $form;
    }
}
