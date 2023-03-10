<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
use Encore\Admin\Form;

Form::extend('ckeditor', \App\Admin\Extensions\Form\CKEditor::class);
Form::forget(['map', 'editor']);
\Encore\Admin\Admin::css("/css/newfont.css");
\Encore\Admin\Admin::css('https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
\Encore\Admin\Admin::js('https://code.jquery.com/ui/1.13.2/jquery-ui.js');
\Encore\Admin\Admin::js('https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js');
\Encore\Admin\Admin::js('https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js');
\Encore\Admin\Admin::js('/js/tooltip.js');
