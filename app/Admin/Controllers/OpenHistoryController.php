<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Lotteryhistory;
use App\Models\GameList;
use App\Models\OpenHistory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class OpenHistoryController extends BaseController
{

    protected $title = '开奖记录';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new OpenHistory(), function (Grid $grid) {

            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->select('game_type', '彩种', GameList::all()->pluck('name','title'));
            });
            $grid->quickSearch(['term','game_type'])->placeholder('搜索期数，彩种');
            $grid->disableFilter();
            $grid->model()->orderBy('term_time','DESC');

            $grid->column('id')->sortable();
            $grid->column('game_type');
            $grid->column('term');
            $grid->column('number','开奖内容');
            $grid->column('add_time');
            $grid->column('created_at');

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
        return Show::make($id, new OpenHistory(), function (Show $show) {

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new OpenHistory(), function (Form $form) {
            $form->display('id');
            $form->text('term');
            $form->text('term_time');
            $form->text('number');
            $form->text('from');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
