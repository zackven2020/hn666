<?php


namespace App\Models\Game;


use App\Models\Wanfa;

class KL8
{
    public function getData($category)
    {
        $wanfa_list = Wanfa::query()->where('category_title',$category)->where('grandpa','KL8')->get()->groupBy('ball');
        $data['lists'] = [];
        $data['rule-info'] = '';
        $i = 1;
        foreach ($wanfa_list as $key => $wanfa){
            $list['title'] = $key;
            $list['name'] = $i++;
            $list['list'] = [];
            foreach ($wanfa as $items){
                $name = explode('-',$items->name);
                array_push($list['list'],[
                    'odds'=>$items->rate,'value'=>$name[1],'active' => false
                ]);
            }
            array_push($data['lists'],$list);
        }
        return $data;
    }

    public function createRules(){
        $grandpa = 'KL8';
        $balls = ['zh'=>'总和','zhgg'=>'总和过关','qhd'=>'前后多','dsd'=>'单双多','wx'=>'五行'];
        $zonghe = ['big'=>'大','small'=>'小','single'=>'单','double'=>'双'];
        $zongheguoguan = ['bigsingle'=>'大单','bigdouble'=>'大双','smallsingle'=>'小单','smalldouble'=>'小双'];
        $qianduo = ['qianduo'=>'前多','houduo'=>'后多'];
        $danshuangduo = ['danduo'=>'单多','shuangduo'=>'双多'];
        $wuxing = ['jin'=>'金','mu'=>'木','shui'=>'水','huo'=>'火','tu'=>'土'];

        foreach ($balls as $key => $ball){
            switch ($key){
                case 'zh':
                    $items = $zonghe;
                    break;
                case 'zhgg':
                    $items = $zongheguoguan;
                    break;
                case 'qhd':
                    $items = $qianduo;
                    break;
                case 'dsd':
                    $items = $danshuangduo;
                    break;
                case 'wx':
                    $items = $wuxing;
                    break;
                default:
                    $items = [];
                    break;
            }

            foreach ($items as $k => $q){
                $wanfa = new \App\Models\Wanfa();
                $wanfa->grandpa = $grandpa;
                $wanfa->category = '双面';
                $wanfa->category_title = 'sm';
                $wanfa->name = $ball .'-'.$q;
                $wanfa->title = $key . '-'.$k;
                $wanfa->rate = 1.985;
                $wanfa->ball = $ball;
                $wanfa->maxodds = 9999999;
                $wanfa->maxbet = 9999;
                $wanfa->minpay = 1;
                $wanfa->maxpay = 9999999;
                $wanfa->status = 1;
                $wanfa->save();
            }
        }

        foreach (range(1,80) as $key => $item){
            $wanfa = new \App\Models\Wanfa();
            $wanfa->grandpa = $grandpa;
            $wanfa->category = '正码';
            $wanfa->category_title = 'zm';
            $wanfa->name = $item;
            $wanfa->title = $item;
            $wanfa->rate = 3.81;
            $wanfa->ball = $item;
            $wanfa->maxodds = 9999999;
            $wanfa->maxbet = 9999;
            $wanfa->minpay = 1;
            $wanfa->maxpay = 9999999;
            $wanfa->status = 1;
            $wanfa->save();
        }

    }
}
