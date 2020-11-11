<?php

namespace App\Admin\Controllers;

use App\Models\CliWork;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class CliWorkController extends AdminController
{

    protected $title = '系统进程管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CliWork(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');

            $grid->column('foo','执行状态')->display(function (){
                $success = '<i class="fa fa-circle" style="font-size: 13px;color: #28da1c"></i>';
                $fail = '<i class="fa fa-circle" style="font-size: 13px;color: #cc4f29"></i>';
                $rs = time() - Cache::get($this->name);
                return $rs > 10 ? "$fail 于 $rs 秒前停止" : "$success 正在执行 (上次执行 $rs 秒前)";
            });
            $grid->column('status','自动守护进程')->switch();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableActions();

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
        return Show::make($id, new CliWork(), function (Show $show) {
            $show->field('id');
            $show->field('name');
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
        return Form::make(new CliWork(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->switch('status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
