<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\System;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Callout;

class SystemController extends BaseController
{
    protected $title = '站點配置';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new System(), function (Grid $grid) {
//            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('status')->select([1=>'開啓','關閉']);
            $grid->column('totalScore');
            $grid->column('currentScore');
            $grid->column('level');
            $grid->column('gift1')->select([1=>'開啓','關閉']);
            $grid->column('gift2')->select([1=>'開啓','關閉']);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });

            $grid->footer(function (){
                $row = new Row();
                $message = <<<EOT
<br/>
當月儲值階梯比例：<br/>
等級一：儲值比例：（1000 - 9999） 2番平臺分儲值<br/>
等級二：儲值比例：（10000 - 49999） 3番平臺分儲值<br/>
等級三：儲值比例：（50000 - 199999） 4番平臺分儲值<br/>
等級四：儲值比例：（200000 - 5000000） 5番平臺分儲值<br/>
等級五：處置比例：（ 5000000 + ） 客制化合夥<br>
首次儲值可獲得單次8番平臺分儲值機會！
<br><br>
示例：當月首次儲值10000，獲得80000平臺分，當月再儲值10000，獲得30000平臺分，以此類推。
EOT;
                $gift1 = <<<EOT
會員餘額在系統裏會獲得相應利息，連續3天保持餘額1000以上即可開始獲取利息。<br/>
利息平臺統一為單日2%，次月可領。<br/><br/>
示例：會員儲值10000，在第四日后開始每日增加200平臺分，30自然日后可提取。<br/>
EOT;

                $dama = <<<EOT
為避免平臺刷分套利等情況，本平臺規定打碼量必須為出金額度的120%。<br/>
即會員申請出金10000，必須有12000的投注流水。如會員共有360000流水，那總計可提300000，以總數計算，不計次數。
EOT;

                $dajiaying = <<<EOT
平臺開啓瘋狂返利模式，只要會員當日參與游戲。即可平分當日平臺縂盈利的5%！<br/>
EOT;


                $row->column(8,Callout::make($message, '平臺分説明')->primary()->removable());
                $row->column(8,Callout::make($gift1, '平臺息金説明')->primary()->removable());
                $row->column(8,Callout::make($dama, '打碼量説明')->primary()->removable());
                $row->column(8,Callout::make($dajiaying, '大家贏説明')->primary()->removable());
                return $row;
            });

            $grid->disablePagination();
            $grid->disablePerPages();
            $grid->disableToolbar();
            $grid->disableActions();
            $grid->disableBatchActions();
            $grid->disableCreateButton();
            $grid->disableRowSelector();
            $grid->disableRefreshButton();
            $grid->disableFilterButton();
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
        return Show::make($id, new System(), function (Show $show) {
            $show->field('id');
            $show->field('title');
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
        return Form::make(new System(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->text('status');
            $form->text('currentScore');
            $form->text('level');
            $form->text('gift1');
            $form->text('gift2');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
