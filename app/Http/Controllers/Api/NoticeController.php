<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function lists()
    {
        $notice = [
            '伊布2球!米兰2-0开门红 顶级联赛连杀22年',
            '英超:丁丁传射福登热苏斯破门 曼城3-1狼队开门红',
            '冰铃铛：克拉斯主场制胜 斯拉维亚稳健可信',
            ];
        return response()->success('平台公告信息',$notice);
    }
}
