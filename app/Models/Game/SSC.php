<?php


namespace App\Models\Game;


use App\Models\Wanfa;

class SSC
{
    public function getData($category)
    {
        $wanfa_list = Wanfa::query()->where('category_title',$category)->where('grandpa','SSC')->get()->groupBy('ball');
        
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
        $grandpa = 'SSC';
        $balls = ['d1q'=>'第一球','d2q'=>'第二球','d3q'=>'第三球','d4q'=>'第四球','d5q'=>'第五球'];
        $zhlhh = ['big'=>'大','small'=>'小','single'=>'单','double'=>'双','long'=>'龙','hu'=>'虎','he'=>'和'];
        $qiu = ['big'=>'大','small'=>'小','single'=>'单','double'=>'双','zhi'=>'质','he'=>'和'];
        $shuangmian = range(0,9);
        $xuanhao = range(0,9);

        foreach ($balls as $key => $ball){
            foreach ($qiu as $k => $q){
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
        foreach ($zhlhh as $key => $item){
            $wanfa = new \App\Models\Wanfa();
            $wanfa->grandpa = $grandpa;
            $wanfa->category = '双面';
            $wanfa->category_title = 'sm';
            $wanfa->name = '总和龙虎和-'.$item;
            $wanfa->title = 'zhlhh-'.$key;
            $wanfa->rate = 1.985;
            $wanfa->ball = '总和龙虎和';
            $wanfa->maxodds = 9999999;
            $wanfa->maxbet = 9999;
            $wanfa->minpay = 1;
            $wanfa->maxpay = 9999999;
            $wanfa->status = 1;
            $wanfa->save();
        }

        foreach ($balls as $key => $ball){
            foreach ($shuangmian as $number){
                $wanfa = new \App\Models\Wanfa();
                $wanfa->grandpa = $grandpa;
                $wanfa->category = '选号';
                $wanfa->category_title = 'xh';
                $wanfa->name = $ball.'-'.$number;
                $wanfa->title = $key.'-'.$number;
                $wanfa->rate = 9.85;
                $wanfa->ball = $ball;
                $wanfa->maxodds = 9999999;
                $wanfa->maxbet = 9999;
                $wanfa->minpay = 1;
                $wanfa->maxpay = 9999999;
                $wanfa->status = 1;
                $wanfa->save();
            }
        }

        $qh = ['qs'=>'前三','zs'=>'中三','hs'=>'后三'];
        $animal = ['baozi'=>'豹子','shunzi'=>'顺子','duizi'=>'对子','banshun'=>'半顺','zaliu'=>'杂六'];

        foreach ($qh as $key => $item){
            foreach ($animal as $k => $ani){
                $wanfa = new \App\Models\Wanfa();
                $wanfa->grandpa = $grandpa;
                $wanfa->category = '前中后三';
                $wanfa->category_title = 'qzhs';
                $wanfa->name = $item.'-'.$ani;
                $wanfa->title = $key.'-'.$k;
                $wanfa->rate = 61;
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
}
