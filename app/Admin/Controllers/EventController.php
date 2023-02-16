<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\EventPlaceForm;
use App\Models\Events;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class EventController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Events';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Events());
        $grid->column('id', __('Id'));
        $grid->column('image', __('Рисунок'))->image();
        $grid->column('title', __('Название'));
//        $grid->column('slug', __('Slug'));
//        $grid->column('age_limit', __('Age limit'));
        $grid->column('desc', __('Описание'));

//        $grid->column('cover', __('Cover'))->image();
//        $grid->column('meta_title', __('Meta title'));
//        $grid->column('meta_keywords', __('Meta keywords'));
//        $grid->column('meta_desc', __('Meta desc'));
//        $grid->column('status', __('Status'));
        $grid->column('meta_desc', __('Управление местами'))->display(function ($desc){
            $content = '<a href="/admin/place-control?eventId='.$this->id.'" class="btn btn-primary" style="margin-bottom: 15px"><i class="fa fa-braille" aria-hidden="true" style="position: relative; left: -3px;"></i>Управление местами</a><br>';
            return $content.' <a href="#" class="btn btn-primary"><i class="fa fa-bar-chart" aria-hidden="true" style="position: relative; left: -3px;"></i>Статистика билетов</a><br>';
        });
//        $grid->tools(function ($tools){
//            $tools->append('Hello');
//        });
        /*$grid->actions(function ($actions){
           $actions->prepend('<a href="/admin/place-control?eventId='.$actions->getKey().'" class="btn btn-primary">Управление местами</a><br>');
        });*/
//        $grid->column('created_at', __('Created at'));
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
        $show = new Show(Events::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->eventTimes('eventTimes', function ($eventTimes){
            $eventTimes->resource('/admin/event-times');
            $eventTimes->eventDate();
            $eventTimes->eventTime();
        });
        $show->field('slug', __('Slug'));
        $show->field('age_limit', __('Age limit'));
        $show->field('desc', __('Desc'));
        $show->field('image', __('Image'))->image();
        $show->field('cover', __('Cover'))->image();
        $show->field('meta_title', __('Meta title'));
        $show->field('meta_keywords', __('Meta keywords'));
        $show->field('meta_desc', __('Meta desc'));
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
        $form = new Form(new Events());

        $form->text('title', __('Title'));
        $form->text('slug', __('Slug'));
        $form->text('age_limit', __('Age limit'));
        $form->textarea('desc', __('Desc'));
        $form->image('image', __('Image'));
        $form->image('cover', __('Cover'));
        $form->text('meta_title', __('Meta title'));
        $form->text('meta_keywords', __('Meta keywords'));
        $form->text('meta_desc', __('Meta desc'));
        $form->number('status', __('Status'));

        return $form;
    }
    public function eventPlace(Content $content){
        return $content
            ->title('Website setting')
            ->body(new EventPlaceForm());
    }
}
