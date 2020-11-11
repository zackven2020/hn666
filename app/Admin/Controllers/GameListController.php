<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Gamelist;
use App\Models\GameCategory;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class GameListController extends BaseController
{

    protected $title = '游戏列表';

    protected $state = [0=>'关闭',1=>'开启'];
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Gamelist(), function (Grid $grid){
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('category','彩种分类',
                    GameCategory::all()->pluck('name','title'));
                $selector->select('show','前端展示',[0=>'下架',1=>'上架']);
                $selector->select('status','开启状态',[0=>'关闭',1=>'开启']);
                $selector->select('api_status','自动开奖',[0=>'关闭',1=>'开启']);
                $selector->select('maintain','游戏状态',[0=>'维护中',1=>'正常运营']);
            });

            $grid->column('id');
            $grid->column('category');
            $grid->column('name');
            $grid->column('title');
            $grid->column('api_frequency');
            $grid->column('api_url');
            $grid->column('status')->switch();
            $grid->column('maintain')->switch();
            $grid->column('api_status')->switch();
            $grid->column('interval')->editable();
            $grid->column('url')->editable();
            $grid->column('icon')->image('','60','600');
            $grid->column('note')->editable();
            $grid->column('start_at')->editable();
            $grid->column('end_at')->editable();
            $grid->column('show')->switch();
            $grid->column('sort')->editable();
            $grid->column('rules')->modal(function (){
                return '';
            });
//            $grid->column('created_at');
//            $grid->column('updated_at')->sortable();

            $grid->disablePagination();
            $grid->disablePerPages();
//            $grid->disableToolbar();
//            $grid->disableActions();
            $grid->disableBatchActions();
            $grid->disableCreateButton();
            $grid->disableRowSelector();
//            $grid->disableRefreshButton();
//            $grid->disableFilterButton();
            $grid->actions(function (Grid\Displayers\Actions $action){
                $action->disableView();
                $action->disableDelete();
            });

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
        return Show::make($id, new Gamelist(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('status');
            $show->field('maxodds');
            $show->field('maxamount');
            $show->field('show');
            $show->field('sort');
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
        return Form::make(new Gamelist(), function (Form $form) {
            $form->text('name')->required();
            $form->text('title')->disable();
            $form->text('category')->disable();
            $form->number('interval');
            $form->image('icon')->autoUpload()->uniqueName()->required();
            $form->text('note');
            $form->switch('status')->options($this->state);
            $form->switch('maintain')->options($this->state);

            $form->text('api_frequency');
            $form->url('api_url');
            $form->switch('api_status')->options($this->state);

            $form->text('start_at');
            $form->text('end_at');

            $form->switch('show')->options($this->state);
            $form->number('sort')->type('number');
            $form->hasMany('rules',function (Form\NestedForm $form){
                $form->text('name');
                $form->text('title');
            });
        });
    }
}
