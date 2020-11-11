<?php


namespace App\Models\Game;


use App\Models\Wanfa;

class PK10
{
    public function getData($category)
    {
        $wanfa_list = Wanfa::query()->where('category_title',$category)->where('grandpa','PK10')->get()->groupBy('ball');
        $balls = ['冠亚和','冠军','亚军','第三名','第四名','第五名','第六名','第七名','第八名','第九名','第十名','冠亚和'];
        $data['lists'] = [];
        $data['rule-info'] = '';
        $i = 1;
        foreach ($wanfa_list as $key => $wanfa){
            $list['title'] = $balls[$key];
            $list['name'] = $i++;
            $list['list'] = [];
            foreach ($wanfa as $items){
                $name = str_replace($balls[$key].'-','',$items->name);
                array_push($list['list'],[
                    'odds'=>$items->rate,'value'=>$name,'active' => false
                ]);
            }
            array_push($data['lists'],$list);
        }
        return $data;
    }
    
    // 转换 数字 1 为冠军等...
 public function createRules(){
    $wanfa_list = ['冠军','亚军','第三名','第四名','第五名','第六名','第七名','第八名','第九名','第十名'];
    $wanfa2_list = ['冠军','亚军','第三名','第四名','第五名','第六名','第七名','第八名','第九名','第十名','冠亚和'];

    $shuangmian = ['big'=>'大','small'=>'小','single'=>'单','double'=>'双','long'=>'龙','hu'=>'虎'];
    $guanyahe = range(3,19);
    $xuanhao = range(1,10);
    $grandpa = 'PK10';
    // 选号
    foreach ($wanfa_list as $key => $item) {
        foreach ($xuanhao as $kb => $balls) {
            $wanfa = new \App\Models\Wanfa();
            $wanfa->grandpa = $grandpa;
            $wanfa->category = '选号';
            $wanfa->category_title = 'xh';
            $wanfa->name = $item . '-' . $balls;
            $wanfa->title = 'd' . ($key + 1) . 'q-' . $balls;
            $wanfa->rate = 9.85;
            $wanfa->ball = ($key+1);
            $wanfa->maxodds = 9999999;
            $wanfa->maxbet = 9999;
            $wanfa->minpay = 1;
            $wanfa->maxpay = 9999999;
            $wanfa->status = 1;
            $wanfa->save();
        }
    }

    // 双面
    foreach ($wanfa2_list as $key => $item){
        foreach ($shuangmian as $kb => $balls){
            $wanfa = new \App\Models\Wanfa();
            $wanfa->grandpa = $grandpa;
            $wanfa->category = '双面';
            $wanfa->category_title = 'sm';
            $wanfa->name = $item.'-'.$balls;
            $wanfa->title = 'd'.($key+1).'q-'.$kb;
            $wanfa->rate = 1.98;
            $wanfa->ball = ($key+1);
            $wanfa->maxodds = 9999999;
            $wanfa->maxbet = 9999;
            $wanfa->minpay = 1;
            $wanfa->maxpay = 9999999;
            $wanfa->status = 1;
            $wanfa->save();
        }
    }
    // 冠亚和
    foreach ($guanyahe as $key => $balls){
        $wanfa = new \App\Models\Wanfa();
        $wanfa->grandpa = $grandpa;
        $wanfa->category = '冠亚和';
        $wanfa->category_title = 'gyh';
        $wanfa->name = '冠亚和-'.$balls;
        $wanfa->title = 'gyhz-'.$balls;
        $wanfa->ball = 0;
        $wanfa->rate = 10.22;
        $wanfa->maxodds = 9999999;
        $wanfa->maxbet = 9999;
        $wanfa->minpay = 1;
        $wanfa->maxpay = 9999999;
        $wanfa->status = 1;
        $wanfa->save();
    }
    echo 1;

}

}
