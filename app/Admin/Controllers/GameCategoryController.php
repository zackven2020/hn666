<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\GameCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class GameCategoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new GameCategory(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('title');
            $grid->column('icon')->image();
            $grid->column('sort')->editable();
            $grid->column('status')->switch();

            $grid->disableBatchDelete();
            $grid->disableCreateButton();
            $grid->disableRefreshButton();
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new GameCategory(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('title');
            $show->field('icon');
            $show->field('sort');
            $show->field('status');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new GameCategory(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('title');
            $form->image('icon')->autoupload()->uniqueName();
            $form->text('sort');
            $form->text('status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
