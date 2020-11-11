<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Wanfa;
use App\Models\GameCategory;
use App\Models\GameList;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class WanfaController extends AdminController
{

    protected $state = [0=>'关闭',1=>'开启'];

    protected $description = '当所属游戏名字为空时，默认为彩种规则！如果对某彩种有单独设置的需求，则增加相应的所属游戏玩法规则';

    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description)
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Wanfa(), function (Grid $grid) {
            $grid->selector(function (Grid\Tools\Selector $selector) {

                $selector->select('grandpa','彩种分类',
                    GameCategory::all()->pluck('name','title')
                );
                $selected_param = $selector->parseSelected();

                if(isset($selected_param['grandpa'])){
                    $category_array = $selected_param['grandpa'];
                    $game_list = GameList::query()->whereIn('category',$category_array)->pluck('name','id');
                }else{
                    $game_list = GameList::all()->pluck('name','id');
                }
                $selector->select('parent_game_id','具体彩种',$game_list);

                $selector->select('category_title','玩法分类',[
                    'sm'=>'双面','gyh'=>'冠亚和','xh'=>'选号','qzhs'=>'前中后三','yxx'=>'鱼虾蟹','zh'=>'整合','renxxuan'=>'任选','zuxuan'=>'组选','zhixuan'=>'直选','zm'=>'正码'
                ]);
            });

            $grid->quickSearch(['category','title','name'])->placeholder('玩法分类，名称，标识');

            $grid->column('grandpa')->filter();
            $grid->column('parent_game_id');
            $grid->column('parent_game_name')->filter();
            $grid->column('category')->filter();
            $grid->column('name');
            $grid->column('title')->editable();
            $grid->column('status')->switch();
            $grid->column('rate')->editable();
            $grid->column('maxodds')->editable();
            $grid->column('maxbet')->editable();
            $grid->column('minpay')->editable();
            $grid->column('maxpay')->editable();
            $grid->column('note');

            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->disableBatchDelete();
            $grid->paginate(100);

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
        return Show::make($id, new Wanfa(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('title');
            $show->field('rate');
            $show->field('maxodds');
            $show->field('maxbet');
            $show->field('minpay');
            $show->field('maxpay');
            $show->field('note');
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
        return Form::make(new Wanfa(), function (Form $form) {
            $game_list = GameList::all()->pluck('name','id');
            $cate_list = GameCategory::all()->pluck('name','title');
            $form->select('grandpa')->options($cate_list)->required();
            $form->select('parent_game_id')
                ->options($game_list);
            $form->hidden('parent_game_name');
            $form->text('category')->required();
            $form->text('category_title')->required();
            $form->switch('status')->options($this->state)->default(1);
            $form->text('name')->required();
            $form->text('title')->required();
            $form->text('rate')->required();
            $form->text('maxodds')->default(9999999);
            $form->number('maxbet')->default(9999);
            $form->currency('minpay')->symbol('￥')->default(1);
            $form->currency('maxpay')->symbol('￥')->default(9999999);
            $form->textarea('note');

            $form->saving(function (Form $form) use ($game_list){
                if(isset($form->parent_game_id) && $form->parent_game_id>0){
                    $form->parent_game_name = $game_list[$form->parent_game_id];
                }
            });

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
