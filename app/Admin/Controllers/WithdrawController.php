<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Withdraw;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class WithdrawController extends BaseController
{

    protected $title = '出金訂單';

    public function ing(Content $content)
    {
        $this->title = '待出金訂單';
        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body($this->grid(false));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($finished = true)
    {
        return Grid::make(new Withdraw(), function (Grid $grid) use ($finished) {
            if($finished){
                $grid->model()->where('status','>',0);
            }else{
                $grid->model()->where('status',0);
            }
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('account');
            $grid->column('money');
            $grid->column('before');
            $grid->column('after');

            if($finished) {
                $grid->column('status')->using([0 => '待处理', 1 => '已完成', 2=>'失败', 3=>'挂起']);
            }else{
                $grid->column('status')->using([0 => '待处理', 1 => '已完成', 2=>'失败', 3=>'挂起'])
                    ->select([0 => '待处理', 1 => '已完成', 2=>'失败', 3=>'挂起']);
            }
            $grid->column('operate');
            $grid->column('realname');
            $grid->column('bankcard');
            $grid->column('banktype');
            $grid->column('bankaddress');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('account');
                $filter->between('money');
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
        return Show::make($id, new Withdraw(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('money');
            $show->field('before');
            $show->field('after');
            $show->field('status');
            $show->field('operate');
            $show->field('realname');
            $show->field('bankcard');
            $show->field('banktype');
            $show->field('bankaddress');
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
        return Form::make(new Withdraw(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('money');
            $form->text('before');
            $form->text('after');
            $form->text('status');
            $form->text('operate');
            $form->text('realname');
            $form->text('bankcard');
            $form->text('banktype');
            $form->text('bankaddress');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
