<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Deposit;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class DepositController extends BaseController
{

    protected $title = '充值订单';

    public function ing(Content $content)
    {
        $this->title = '待充值订单';
        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body($this->grid(false));
    }
    /**
     * Make a grid builder.
     * @param $finished bool
     * @return Grid
     */
    protected function grid($finished = true)
    {
        return Grid::make(new Deposit(), function (Grid $grid) use ($finished) {
            if($finished){
                $grid->model()->where('status','>',0);
            }else{
                $grid->model()->where('status',0);
            }
            $grid->model()->orderBy('id','DESC');

            $grid->quickSearch(['account','money'])->placeholder('账户，充值金额');

            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('account');
            $grid->column('type')->using([1=>'普通充值']);
            $grid->column('money');
            $grid->column('before');
            $grid->column('after');

            if($finished) {
                $grid->column('status')
                    ->using([0 => '待处理', 1 => '已完成', 2=>'失败', 3=>'挂起'])
                    ->dot(
                        [
                            0 => 'primary',
                            1 => 'success',
                            2 => 'danger',
                            3 => 'default'
                        ],
                        'primary' // 第二个参数为默认值
                    );
            }else{
                $grid->column('status')->using([0 => '待处理', 1 => '已完成', 2=>'失败', 3=>'挂起'])
                    ->select([0 => '待处理', 1 => '已完成', 2=>'失败', 3=>'挂起']);
            }
            $grid->column('operate');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('account');
                $filter->equal('type')->select([1=>'手动充值','第三方充值']);
                $filter->between('money');
            });

            $grid->disableCreateButton();
            $grid->disableBatchActions();
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
        return Show::make($id, new Deposit(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('type');
            $show->field('money');
            $show->field('before');
            $show->field('after');
            $show->field('status');
            $show->field('operate');
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
        return Form::make(new Deposit(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('type');
            $form->text('money');
            $form->text('before');
            $form->text('after');
            $form->text('status');
            $form->text('operate');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
