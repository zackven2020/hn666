<?php


namespace App\Models\Game;


use App\Models\Wanfa;

class LHC
{
    public function getData($category)
    {
        $wanfa_list = Wanfa::query()->where('category_title',$category)->where('grandpa','LHC')->get()->groupBy('ball');
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
        

    }
}
