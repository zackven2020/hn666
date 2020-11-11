<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Navbar;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Admin::asset()->alias('@nunito', null, '');
Admin::asset()->alias('@montserrat', null, '');


Grid::resolving(function (Grid $grid) {
    $grid->disableViewButton();
    $grid->toolsWithOutline(false);
});

Form::resolving(function (Form $form){
    $form->disableEditingCheck();
    $form->disableViewCheck();
    $form->disableDeleteButton();
    $form->disableViewButton();
    $form->disableCreatingCheck();
});

