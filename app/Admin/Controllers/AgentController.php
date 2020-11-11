<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Agent;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Str;

class AgentController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        return Grid::make(new Agent(), function (Grid $grid) {
            $grid->quickSearch(['id','name','title','invate_url'])->placeholder('ID，名字，标记，邀请码');
            $grid->column('id')->bold()->sortable();
            $grid->title->tree(); // 开启树状表格功能

            $grid->column('name');
            $grid->column('level');
            $grid->column('status')->using([0=>'停用',1=>'正常'])->dot([0=>'danger',1=>'success']);
            $grid->column('rabate')->editable();
            $grid->column('balance');
            $grid->column('invate_url')->editable();

            $grid->created_at;
            $grid->updated_at->sortable();

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
        return Show::make($id, new Agent(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('title');
            $show->field('level');
            $show->field('status');
            $show->field('parent_id');
            $show->field('rabate');
            $show->field('balance');
            $show->field('invate_url');
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
        return Form::make(new Agent(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('title')->required();
            $form->number('level')->default(0)->max(9);
            $form->switch('status');
            $agent_list = array_merge([0=>'无上级'],\App\Models\Agent::all()->pluck('title','id')->toArray());
            $form->select('parent_id')->options($agent_list)->required();
            $form->rate('rabate');
            $form->text('balance')->default(0)->disable();
            $form->text('invate_url')->default(strtoupper(Str::random(6)))->help('置空時默認隨機');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
