<div class="row">
    <div class="col-md-4">
        <div id="metric-card-n4sQ8CGC" class="card" user="" style=" min-height:130px;">
            <div class="card-header d-flex justify-content-between align-items-start pb-0">
                <div>
                    <h4 class="card-title mb-1">{{ trans('系统总入金') }}</h4>
                    <div class="metric-header"></div>
                </div>
            </div>
            <div class="metric-content">
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="text-left">
                        <h1 class="ml-1 font-lg-1">{{ $totalWithdraw['total_deposit'] }} ￥</h1></div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <style>
            h4,h1{color: #ffffff}
            #metric-card-kIjEg62w{
                background-image: url({{ asset('image/1.png') }});
                background-repeat:no-repeat;
                background-size:100% 100%;
                -moz-background-size:100% 100%;
            }
            #metric-card-n4sQ8CGC{
                background-image: url({{ asset('image/2.png') }});
                background-repeat:no-repeat;
                background-size:100% 100%;
                -moz-background-size:100% 100%;
            }
            #metric-card-EfSF6Hd8{
                background-image: url({{ asset('image/3.png') }});
                background-repeat:no-repeat;
                background-size:100% 100%;
                -moz-background-size:100% 100%;
            }
            #metric-card-EfSF6Hd9{
                background-image: url({{ asset('image/3.jpg') }});
                background-repeat:no-repeat;
                background-size:100% 100%;
                -moz-background-size:100% 100%;
            }
            #metric-card-EfSF6Hd10{
                background-image: url({{ asset('image/4.jpg') }});
                background-repeat:no-repeat;
                background-size:100% 100%;
                -moz-background-size:100% 100%;
            }
            #metric-card-EfSF6Hd11{
                background-image: url({{ asset('image/5.jpg') }});
                background-repeat:no-repeat;
                background-size:100% 100%;
                -moz-background-size:100% 100%;
            }
        </style>

        <div id="metric-card-kIjEg62w" class="card" user="" style=" min-height:130px;">
            <div class="card-header d-flex justify-content-between align-items-start pb-0">
                <div>
                    <h4 class="card-title mb-1">{{ trans('系统总出金') }}</h4>
                    <div class="metric-header"></div>
                </div>
            </div>
            <div class="metric-content">
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="text-left">
                        <h1 class="ml-1 font-lg-1">{{ $totalWithdraw['total_withdraw'] }} ￥</h1></div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div id="metric-card-EfSF6Hd8" class="card" user="" style=" min-height:130px;">
            <div class="card-header d-flex justify-content-between align-items-start pb-0">
                <div>
                    <h4 class="card-title mb-1">{{ trans('总会员数') }}</h4>
                    <div class="metric-header"></div>
                </div>
            </div>
            <div class="metric-content">
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="text-left">
                        <h1 class="ml-1 font-lg-1">{{ $totalWithdraw['total_member'] }}</h1></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div id="metric-card-EfSF6Hd10" class="card" user="" style=" min-height:130px;">
            <div class="card-header d-flex justify-content-between align-items-start pb-0">
                <div>
                    <h4 class="card-title mb-1">{{ trans('今日入金') }}</h4>
                    <div class="metric-header"></div>
                </div>
            </div>
            <div class="metric-content">
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="text-left">
                        <h1 class="ml-1 font-lg-1">{{ $totalWithdraw['day_deposit'] }} ￥</h1></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div id="metric-card-EfSF6Hd11" class="card" user="" style=" min-height:130px;">
            <div class="card-header d-flex justify-content-between align-items-start pb-0">
                <div>
                    <h4 class="card-title mb-1">{{ trans('今日出金') }}</h4>
                    <div class="metric-header"></div>
                </div>
            </div>
            <div class="metric-content">
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="text-left">
                        <h1 class="ml-1 font-lg-1">{{ $totalWithdraw['day_withdraw'] }} ￥</h1></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div id="metric-card-EfSF6Hd9" class="card" user="" style=" min-height:130px;">
            <div class="card-header d-flex justify-content-between align-items-start pb-0">
                <div>
                    <h4 class="card-title mb-1">今日注册会员</h4>
                    <div class="metric-header"></div>
                </div>
            </div>
            <div class="metric-content">
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="text-left">
                        <h1 class="ml-1 font-lg-1">{{ $totalWithdraw['day_member'] }} </h1></div>
                </div>
            </div>
        </div>
    </div>

</div>