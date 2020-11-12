<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples\NewDevices;
use App\Admin\Metrics\Examples\NewUsers;
use App\Admin\Repositories\Member;
use App\Models\Agent;
use App\Models\System;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;



class MemberController extends BaseController
{

    public function index(Content $content)
    {
        return $content
            ->header('會員 & 平臺')
            ->description('圖形示意圖')
            ->body(function (Row $row) {
                $row->column(6, new NewUsers());
                $row->column(6, new NewDevices());
            })
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Member(['agent','company']), function (Grid $grid) {

            $grid->showQuickEditButton();
            $grid->column('id')->sortable();
            if(\Admin::user()->isRole('administrator')){
                $grid->selector(function (Grid\Tools\Selector $selector) {
                    $selector->select('company.title', '分公司', System::all()->pluck('title','id')->toArray());
                });
                $grid->column('company.title','分公司');
            }

            $grid->column('agent.title','代理线')->bold()->filter();
            $grid->column('agent.name','代理名称');
            $grid->column('account');
            $grid->column('password')->display(function ($model){
                return '******';
            })->editable();
            $grid->column('status')->select([1=>'正常','凍結錢包','凍結賬號']);
            $grid->column('realname');
            $grid->column('bankcard');
            $grid->column('banktype');
            $grid->column('bankaddress');
            $grid->column('balance');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->quickSearch(['id','account','realname'])->placeholder('ID，代理，賬號，真實姓名');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('status')->select([1=>'正常','凍結錢包','凍結賬號']);
                $filter->like('bankcard');
                $filter->like('banktype');
                $filter->equal('bankaddress');
                $filter->between('created_at')->datetime();
                $filter->between('updated_at')->datetime();
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
        return Show::make($id, new Member(), function (Show $show) {
            $show->field('id');
            $show->field('account');
            $show->field('password');
            $show->field('status');
            $show->field('realname');
            $show->field('bankcard');
            $show->field('banktype');
            $show->field('bankaddress');
            $show->field('balance');
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
        return Form::make(new Member(), function (Form $form) {
            $form->display('id');
            $form->text('account')->required();
            $form->password('password')->required();
            $form->select('status')->options([1=>'正常','凍結錢包','凍結賬號'])->default(1);
            $form->select('agent_id')->options(Agent::all()->pluck('name', 'id')->toArray())->default(1);
            $form->text('realname');
            $form->text('bankcard');
            $form->text('banktype');
            $form->text('bankaddress');
            $form->text('balance')->default(0)->disable();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
