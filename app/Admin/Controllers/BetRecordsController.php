<?php

namespace App\Admin\Controllers;

use App\Models\BetRecord;
use App\Models\GameList;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class BetRecordsController extends BaseController
{

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new BetRecord(), function (Grid $grid) {

            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('gametype', '游戲種類', [
                    'pk10' => '北京PK10',
                    'xyft' => '幸運飛艇',
                    'jsks' => '江蘇快三',
                    'pc28' => 'PC28',
                ]);
            });
            $grid->quickSearch(['term'])->placeholder('搜索期數...');

            $grid->column('user_id')->sortable();
            $grid->column('wanfa_id');
            $grid->column('term');
            $grid->column('before');
            $grid->column('after');
            $grid->column('lotterymoney');
            $grid->column('maxamount');
            $grid->column('afterlottery');
            $grid->column('status');
            $grid->column('finaly');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

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
        return Show::make($id, new BetRecord(), function (Show $show) {
            $show->field('user_id')->sortable();
            $show->field('term');
            $show->field('before');
            $show->field('after');
            $show->field('lotterymoney');
            $show->field('maxamount');
            $show->field('afterlottery');
            $show->field('status');
            $show->field('finaly');
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
        return Form::make(new BetRecord(), function (Form $form) {
            $form->text('user_id');
            $form->text('term');
            $form->text('before');
            $form->text('after');
            $form->text('lotterymoney');
            $form->text('maxamount');
            $form->text('afterlottery');
            $form->text('status');
            $form->text('finaly');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
