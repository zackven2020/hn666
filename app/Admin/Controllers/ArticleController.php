<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Article;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class ArticleController extends BaseController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Article(), function (Grid $grid) {

            $grid->model()->orderBy('order','DESC');

            $grid->showQuickEditButton();


            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('content')->limit(15);
            $grid->column('url');
            $grid->column('cover')->image('',80,80);
            $grid->column('order');
            $grid->column('is_top')->switch();
            $grid->column('is_home')->switch();
            $grid->column('is_hot')->switch();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
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
        return Show::make($id, new Article(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('content');
            $show->field('author');
            $show->field('cover');
            $show->field('sort');
            $show->field('is_top');
            $show->field('is_hot');
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
        return Form::make(new Article(), function (Form $form) {
            $form->display('id');
            $form->text('title')->required();
            $form->text('pid')->default(0)->disable();
            $form->textarea('content')->required();
            $form->text('author');
            $form->image('cover')->uniqueName()->accept('jpg,png,jpeg', 'image/*')->maxSize(10240)->autoUpload();
            $form->number('order');
            $form->switch('is_top');
            $form->switch('is_home');
            $form->switch('is_hot');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
