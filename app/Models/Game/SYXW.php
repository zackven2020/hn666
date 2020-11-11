<?php


namespace App\Models\Game;


use App\Models\Wanfa;

class SYXW
{
    public function getData($category)
    {
        $wanfa_list = Wanfa::query()->where('category_title',$category)->where('grandpa','11X5')->get()->groupBy('ball');
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
        $grandpa = '11X5';
        $balls = ['d1q'=>'第一球','d2q'=>'第二球','d3q'=>'第三球','d4q'=>'第四球','d5q'=>'第五球'];
        $zhlhh = ['big'=>'大','small'=>'小','single'=>'单','double'=>'双','long'=>'龙','hu'=>'虎','weida'=>'尾大','weixiao'=>'尾小'];
        $qiu = ['big'=>'大','small'=>'小','single'=>'单','double'=>'双'];
        $shuangmian = range(1,11);

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
            $wanfa->name = '总和-'.$item;
            $wanfa->title = 'zh-'.$key;
            $wanfa->rate = 1.985;
            $wanfa->ball = '总和';
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
                $wanfa->rate = 10.88;
                $wanfa->ball = $ball;
                $wanfa->maxodds = 9999999;
                $wanfa->maxbet = 9999;
                $wanfa->minpay = 1;
                $wanfa->maxpay = 9999999;
                $wanfa->status = 1;
                $wanfa->save();
            }
        }

        $qh = ['rx1'=>'任选一','rx2'=>'任选二','rx3'=>'任选三','rx4'=>'任选四','rx5'=>'任选五','rx6'=>'任选六中五','rx7'=>'任选七中五','rx8'=>'任选八中五'];
        $b = range(1,11);
        foreach ($qh as $key => $ball){
            foreach ($b as $number){
                $wanfa = new \App\Models\Wanfa();
                $wanfa->grandpa = $grandpa;
                $wanfa->category = '任选';
                $wanfa->category_title = 'renxxuan';
                $wanfa->name = $ball.'-'.$number;
                $wanfa->title = $key.'-'.$number;
                $wanfa->rate = 10.88;
                $wanfa->ball = $ball;
                $wanfa->maxodds = 9999999;
                $wanfa->maxbet = 9999;
                $wanfa->minpay = 1;
                $wanfa->maxpay = 9999999;
                $wanfa->status = 1;
                $wanfa->save();
            }
        }
$qh = ['q2zx'=>'前二组选','q3zx'=>'前三组选'];
        foreach ($qh as $key => $ball){
            foreach ($b as $number){
                $wanfa = new \App\Models\Wanfa();
                $wanfa->grandpa = $grandpa;
                $wanfa->category = '组选';
                $wanfa->category_title = 'zuxuan';
                $wanfa->name = $ball.'-'.$number;
                $wanfa->title = $key.'-'.$number;
                $wanfa->rate = 10.88;
                $wanfa->ball = $ball;
                $wanfa->maxodds = 9999999;
                $wanfa->maxbet = 9999;
                $wanfa->minpay = 1;
                $wanfa->maxpay = 9999999;
                $wanfa->status = 1;
                $wanfa->save();
            }
        }

        $qh = ['q2zx'=>'前二直选','q3zx'=>'前三直选'];
        foreach ($qh as $key => $ball){
            foreach ($b as $number){
                $wanfa = new \App\Models\Wanfa();
                $wanfa->grandpa = $grandpa;
                $wanfa->category = '直选';
                $wanfa->category_title = 'zhixuan';
                $wanfa->name = $ball.'-'.$number;
                $wanfa->title = $key.'-'.$number;
                $wanfa->rate = 10.88;
                $wanfa->ball = $ball;
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
