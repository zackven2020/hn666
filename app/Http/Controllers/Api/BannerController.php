<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function lists()
    {
        $banner = [
            'https://tradeimg.500.com/upimages/wap/img/20200817170709102.jpg',
            'https://tradeimg.500.com/upimages/wap/img/20191219140923109.jpg',
            'https://tradeimg.500.com/upimages/wap/img/20200902135007613.png',
            'https://tradeimg.500.com/upimages/wap/img/20200922111359911.jpg'
            ];
        return response()->success('平台轮播图',$banner);
    }
}
