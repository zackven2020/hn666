<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Game\PK10;
use App\Models\Game\SSC;
use App\Models\Game\K3;
use App\Models\GameList;
use App\Models\GameCategory;
use App\Models\OpenHistory;


/**
 * 彩票基本类
 * @author ppx
 */
class LotteryController extends Controller
{
    /**
     * 左边菜单
     */
    public function menuLists(){
        $menu = $this->getCache('menu_lists');

        if(empty($menu)){
            $menu = GameCategory::query()
                ->select(['sort as sortid','title','name','icon'])
                ->where('status',1)
                ->with(['lists'=>function($query){
                    return $query
                        ->select(['category','sort as sortid','name','title','icon']);
                }])
                ->get()->toArray();
            $this->setCache('menu_lists',$menu,60);
        }
        return response()->json('左边菜单',$menu);
    }

    /**
     * 首页推荐彩票
     */
    public function lists()
    {
        $menu = $this->getCache('recommend_lists');
        if(empty($menu)){
            $menu = Article::query()->where('is_home',1)
                ->select(['title as name','content as brief','url','cover as path'])
                ->orderBy('order','DESC')
                ->get()->toArray();
            $this->setCache('recommend_lists',$menu);
        }

        return response()->success('首页推荐彩票',$menu);
    }

    /**
     * 获取彩票信息
     */
    public function info(){
    	$title = \request()->get('lottery','pk10');
    	$lotteryInfo = GameList::query()->where(['title' => $title])->first();
    	$openData = OpenHistory::query()->where(['game_type' => $title])->orderBy('term','DESC')->first();
        $numberArr = explode(',',$openData['number']);
        foreach ($numberArr as $k => $v){
        	$data[] = ['trans' => 0,'value' => $v];
        }
        
        $lastRecord = ['issue' => $openData['term'], 'data' => $data,'digits' => $openData['number'],'lotteryType' => $title];
        return response()->success('彩票详情',[
            'lotteryName' => $lotteryInfo['name'],
            'lastRecord' => $lastRecord]);
    }

    /**
     * 玩法规则
     * ###前端 提供彩票id  玩法id
     * ###接口 提供响应的规则介绍 和 赔率 值等信息
     */
    public function rule(){
        $grandpa = \request()->get('grandpa','pk10');
        //$father = \request()->get('father',NULL);
        $category = \request()->get('category_title','sm');

        //$zhiding = Wanfa::query()->where('parent_game_name',$father)->get();
        $cache_name = "rule_".$grandpa."_".$category;
        $data = $this->getCache($cache_name);
        if(empty($data)){
            switch ($grandpa){
                case 'pk10':
                    $model = new PK10();
                    break;
                case 'k3':
                    $model = new K3();
                    break;
                case 'ssc':
                    $model = new SSC();
                    break;
                case '11x5':
                    $model = new SYXW();
                    break;
                case 'kl8':
                    $model = new KL8();
                    break;
                case 'lhc':
                    $model = new LHC();
                    break;
                default:
                    $model = new PK10();
                    break;
            }
            $data = $model->getData($category);
            $this->setCache($cache_name,$data);
        }

        return response()->success('玩法规则',$data);
    }
    
    /**
     * 获取下一次开奖期号 全局统一
     */
    public function currentSaleIssue(){
        $data = GameList::calcNextOpenIssue(\request()->get('lottery'));
        return response()->success('获取下一次开奖期号',$data);
    }
}
