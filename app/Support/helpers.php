<?php

use Illuminate\Support\Facades\DB;

function CURL_GET($url, $params=array()) {
    $t11  	 = microtime(true);
    $timeout = isset($params['timeout']) ? $params['timeout'] : 4;
    $referer = isset($params['referer']) ? $params['referer'] : '';
    $cookie  = isset($params['cookie']) ? $params['cookie'] : '';
    $ckjar   = isset($params['cookiejar']) ? $params['cookiejar'] : '';
    $ckfile  = isset($params['cookiefile']) ? $params['cookiefile'] : '';
    $agent   = isset($params['agent']) ? $params['agent'] : '';
    $header  = isset($params['header']) ? $params['header'] : array();
    $post 	 = isset($params['post']) ? $params['post'] : array();
    $getinfo = isset($params['getinfo']) ? $params['getinfo'] : 0;
    $location	= isset($params['location']) ? (int)$params['location'] : 1;
    $getcookie 	= isset($params['getcookie']) ? $params['getcookie'] : 0;
    if (!$agent) {
        $agents = array(
            'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)',
            'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727; InfoPath.2; AskTbPTV/5.17.0.25589; Alexa Toolbar)',
            'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.94 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0',
        );
    } else {
        $agents = array($agent);
    }
    //伪造IP头
    $cip 	= '123.125.68.'.mt_rand(0,254);
    $xip 	= '125.90.88.'.mt_rand(0,254);
    $header = array_merge($header, array(
        'CLIENT-IP:'.$cip,
        'X-FORWARDED-FOR:'.$xip,
    ));
    $curl = curl_init();
    $SSL = substr($url, 0, 8) == "https://" ? 1 : 0;
    if ($SSL) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_HEADER, $getcookie); //0表示不输出Header，1表示输出
    curl_setopt($curl, CURLOPT_REFERER, $referer);
    curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    if ($ckjar) {
        curl_setopt($curl, CURLOPT_COOKIEJAR, $ckjar);
    }
    if ($ckfile) {
        curl_setopt($curl, CURLOPT_COOKIEFILE, $ckfile);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_USERAGENT, $agents[array_rand($agents)]);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, $location); //重定向次数
    if ($timeout > 0) {
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout+1); //执行超时
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout); //连接超时
    }
    if ($post) {
        $_post = '';
        if (is_array($post)) {
            foreach ($post as $k => $v) {
                $_post .= "$k=$v&";
            }
            $_post = substr($_post,0,-1);
        }
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_post);
    }
    $content = curl_exec($curl);
    $err_num = curl_errno($curl); //返回0时表示程序执行成功 如何从curl_errno返回值获取错误信息
    $infos 	 = curl_getinfo($curl);
    //$status  = curl_getinfo($curl, CURLINFO_HTTP_CODE); //响应码
    $status  = isset($infos['http_code']) ? $infos['http_code'] : 0;
    curl_close($curl);
    //echo "Elapsed:".round(microtime(true)-$t11,2)."s\n";die;
    if ($getinfo) return $infos;
    if ($err_num === 0) {
        if ($getcookie) { //只取cookie内容
            list($_header, $body) = explode("\r\n\r\n", $content, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $_header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }
        return $content;
    }
    return array($err_num,$status);
}

function CURL_URL($code, $date='', $count=50, $page=1){
    $exec_started_at = microtime(true);
    $time_start = strtotime($date) ? strtotime($date) : time();
    $time_0600 = strtotime(date('Y-m-d 06:00',$time_start));
    $start_time = $time_0600 - ($time_start < $time_0600 ? 86400 : 0) - 3600; //当天开始时间
    $end_time = $start_time+86400;

    $ret = array('msg'=>'','status'=>0,'elapsed'=>0);
    $url = 'http://121.42.161.50:13642/index.php/Index/Index/getdata?username=test1&token=5f9d9dcaafbefabad11782eaa9adadce&code='.$code;
//    $url1 = "{$url}&start_time={$start_time}&end_time={$end_time}&pagesize={$count}&page={$page}";
    $url1 = "{$url}&pagesize={$count}&page={$page}";

    $pids = array('gdklsf'=>1,'cqssc'=>2,'pk10'=>3,'jsk3'=>4,'cqxync'=>48,'xyft'=>62,'jssc'=>74,'jsssc'=>86);
    if (!isset($pids[$code])){
        return $ret;
    }

    $data = get_content($url1);
    $r = $data ? save_lottery($data,$code) : 1;

//    fallrate($pid); //降賠
//    if ($r) $r = chk_lottery($pid,$url); //檢查無獎號、漏開獎等
    if ($r) $ret['status'] = 1;
    $ret['elapsed'] = round(microtime(true)-$exec_started_at,2);
    return $ret;
}

//获取内容处理
function get_content($url) {
    $c = CURL_GET($url);
    $c = json_decode($c,TRUE);
    $c = ($c && $c['status']) ? $c['data'] : array();
    if ($c) $c = array_reverse($c);
    return $c;
}

// 开奖结果插入数据库
function save_lottery($data, $gametype){
    
    
    
    $history = \App\Models\OpenHistory::query()
        ->where('game_type',$gametype)
        ->orderBy('term','DESC')
        ->limit(1)
        ->first();
//    array_multisort (array_column( $data , 'term' ),SORT_DESC, $data );

    foreach ($data as $item){
        if(isset($history->term) && $history->term >= $item['term']){
            // 有這個開獎結果,跳過
        }else{
            $d= [
                'game_type'=>$gametype,
                'n1'=>$item['n1']??NULL,
                'n2'=>$item['n2']??NULL,
                'n3'=>$item['n3']??NULL,
                'n4'=>$item['n4']??NULL,
                'n5'=>$item['n5']??NULL,
                'n6'=>$item['n6']??NULL,
                'n7'=>$item['n7']??NULL,
                'n8'=>$item['n8']??NULL,
                'n9'=>$item['n9']??NULL,
                'n10'=>$item['n10']??NULL,
                'term'=>$item['term'],
                'term_time'=>$item['term_time'],
                'number'=>$item['number'],
                'from'=>$item['from'],
                'elapsed'=>$item['elapsed'],
                'add_time'=>date('Y-m-d H:i:s',$item['add_time']),
                'created_at'=>\Carbon\Carbon::now()->toDateTimeString(),
            ];
            DB::table('open_history')->insert($d);
        }
    }

    return true;
}

