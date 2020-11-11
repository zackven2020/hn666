<?php


namespace App\Models\Game;


use App\Models\Wanfa;

class K3
{
    public function getData($category)
    {

        $wanfa_list = Wanfa::query()->where('category_title',$category)->where('grandpa','K3')->get()->groupBy('ball');
       
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
   
    $grandpa = 'K3';
    $shaizi = range(1,6);
    $daxiao = ['big'=>'大','small'=>'小'];


    foreach ($shaizi as $key => $balls){
        $wanfa = new \App\Models\Wanfa();
        $wanfa->grandpa = $grandpa;
        $wanfa->category = '整合';
        $wanfa->category_title = 'zh';
        $wanfa->name = '三军-' . $balls;
        $wanfa->title = 'sanjun-' . $balls;
        $wanfa->rate = 1.98;
        $wanfa->ball = '三军';
        $wanfa->maxodds = 9999999;
        $wanfa->maxbet = 9999;
        $wanfa->minpay = 1;
        $wanfa->maxpay = 9999999;
        $wanfa->status = 1;
        $wanfa->save();
    }

    foreach ($shaizi as $key => $balls){
        $wanfa = new \App\Models\Wanfa();
        $wanfa->grandpa = $grandpa;
        $wanfa->category = '整合';
        $wanfa->category_title = 'zh';
        $wanfa->name = '围骰-' . $balls;
        $wanfa->title = 'ws-' . $balls;
        $wanfa->rate = 168;
        $wanfa->ball = '围骰';
        $wanfa->maxodds = 9999999;
        $wanfa->maxbet = 9999;
        $wanfa->minpay = 1;
        $wanfa->maxpay = 9999999;
        $wanfa->status = 1;
        $wanfa->save();
    }
    $wanfa = new \App\Models\Wanfa();
    $wanfa->grandpa = $grandpa;
    $wanfa->category = '整合';
    $wanfa->category_title = 'zh';
    $wanfa->name = '围骰-全骰';
    $wanfa->title = 'ws-all';
    $wanfa->rate = 26;
    $wanfa->ball = '围骰';
    $wanfa->maxodds = 9999999;
    $wanfa->maxbet = 9999;
    $wanfa->minpay = 1;
    $wanfa->maxpay = 9999999;
    $wanfa->status = 1;
    $wanfa->save();

    foreach ($daxiao as $key => $balls){
        $wanfa = new \App\Models\Wanfa();
        $wanfa->grandpa = $grandpa;
        $wanfa->category = '整合';
        $wanfa->category_title = 'zh';
        $wanfa->name = '总和大小-' . $balls;
        $wanfa->title = 'zhdx-' . $key;
        $wanfa->rate = 1.988;
        $wanfa->ball = '总和大小';
        $wanfa->maxodds = 9999999;
        $wanfa->maxbet = 9999;
        $wanfa->minpay = 1;
        $wanfa->maxpay = 9999999;
        $wanfa->status = 1;
        $wanfa->save();
    }

    $ds = range(3,18);
    foreach ($ds as $key => $balls){
        $wanfa = new \App\Models\Wanfa();
        $wanfa->grandpa = $grandpa;
        $wanfa->category = '整合';
        $wanfa->category_title = 'zh';
        $wanfa->name = '点数-' . $balls;
        $wanfa->title = 'ds-' . $balls;
        $wanfa->rate = 10;
        $wanfa->ball = '点数';
        $wanfa->maxodds = 9999999;
        $wanfa->maxbet = 9999;
        $wanfa->minpay = 1;
        $wanfa->maxpay = 9999999;
        $wanfa->status = 1;
        $wanfa->save();
    }
    $cp = ['1-2','1-3','1-4','1-5','1-6','2-3','2-4','2-5','2-6','3-4','3-5','3-6','4-5','4-6','5-6'];
    $dp = ['1-1','2-2','3-3','4-4','5-5','6-6'];

    foreach ($cp as $key => $balls){
        $wanfa = new \App\Models\Wanfa();
        $wanfa->grandpa = $grandpa;
        $wanfa->category = '整合';
        $wanfa->category_title = 'zh';
        $wanfa->name = '长牌-' . $balls;
        $wanfa->title = 'cp-' . $balls;
        $wanfa->rate = 5.8;
        $wanfa->ball = '长牌';
        $wanfa->maxodds = 9999999;
        $wanfa->maxbet = 9999;
        $wanfa->minpay = 1;
        $wanfa->maxpay = 9999999;
        $wanfa->status = 1;
        $wanfa->save();
    }

    foreach ($dp as $key => $balls){
        $wanfa = new \App\Models\Wanfa();
        $wanfa->grandpa = $grandpa;
        $wanfa->category = '整合';
        $wanfa->category_title = 'zh';
        $wanfa->name = '短牌-' . $balls;
        $wanfa->title = 'dp-' . $balls;
        $wanfa->rate = 5.8;
        $wanfa->ball = '短牌';
        $wanfa->maxodds = 9999999;
        $wanfa->maxbet = 9999;
        $wanfa->minpay = 1;
        $wanfa->maxpay = 9999999;
        $wanfa->status = 1;
        $wanfa->save();
    }

    $animal = ['shayu','xia','hulu','yuanbao','pangxie','ji'];
    foreach ($animal as $key => $balls){
        $wanfa = new \App\Models\Wanfa();
        $wanfa->grandpa = $grandpa;
        $wanfa->category = '鱼虾蟹';
        $wanfa->category_title = 'yxx';
        $wanfa->name = '鱼虾蟹-' . $balls;
        $wanfa->title = 'yxx-' . $balls;
        $wanfa->rate = 1.975;
        $wanfa->ball = '鱼虾蟹';
        $wanfa->maxodds = 9999999;
        $wanfa->maxbet = 9999;
        $wanfa->minpay = 1;
        $wanfa->maxpay = 9999999;
        $wanfa->status = 1;
        $wanfa->save();
    }
}

}
