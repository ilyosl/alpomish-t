<?php

namespace App\Admin\Controllers;

use App\Models\KatokQrcodeModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class KatokListController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'KatokQrcodeModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new KatokQrcodeModel());

        $grid->column('id', __('Id'));
        $grid->column('qrcode', __('Qrcode'));
        $grid->column('price', __('Price'));
        $grid->column('status', __('Status'));
        $grid->column('startDate', __('StartDate'));
        $grid->column('finishDate', __('FinishDate'));
        $grid->column('time', __('Time'));
        $grid->column('type', __('Type'));
        $grid->column('is_read', __('Is read'));
        $grid->column('sell_date', __('Sell date'))->sortable();
        $grid->column('exitDate', __('ExitDate'));
        $grid->column('parent_id', __('Parent id'));
        $grid->column('jazo_price', __('Jazo price'));
        $grid->column('jazo_type', __('Jazo type'));
        $grid->column('user_id', __('User id'));

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
        $show = new Show(KatokQrcodeModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('qrcode', __('Qrcode'));
        $show->field('price', __('Price'));
        $show->field('status', __('Status'));
        $show->field('startDate', __('StartDate'));
        $show->field('finishDate', __('FinishDate'));
        $show->field('time', __('Time'));
        $show->field('type', __('Type'));
        $show->field('is_read', __('Is read'));
        $show->field('sell_date', __('Sell date'));
        $show->field('exitDate', __('ExitDate'));
        $show->field('parent_id', __('Parent id'));
        $show->field('jazo_price', __('Jazo price'));
        $show->field('jazo_type', __('Jazo type'));
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
        $form = new Form(new KatokQrcodeModel());

        $form->text('qrcode', __('Qrcode'));
        $form->number('price', __('Price'));
        $form->number('status', __('Status'));
        $form->text('startDate', __('StartDate'));
        $form->text('finishDate', __('FinishDate'));
        $form->text('time', __('Time'));
        $form->text('type', __('Type'))->default('click');
        $form->number('is_read', __('Is read'));
        $form->datetime('sell_date', __('Sell date'))->default(date('Y-m-d H:i:s'));
        $form->datetime('exitDate', __('ExitDate'))->default(date('Y-m-d H:i:s'));
        $form->number('parent_id', __('Parent id'));
        $form->number('jazo_price', __('Jazo price'));
        $form->text('jazo_type', __('Jazo type'))->default('Click');
        $form->number('user_id', __('User id'));

        return $form;
    }
}
