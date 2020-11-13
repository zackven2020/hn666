<style>
    .dashboard-title .links {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .dashboard-title .links span{
        color: white;
        font-weight: bold;
    }
    .dashboard-title .links > a {
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
        color: #eeeeee;
    }
    .dashboard-title h1 {
        font-weight: 200;
        font-size: 2.5rem;
    }
    .dashboard-title .avatar {
        background: #fff;
        border: 2px solid #fff;
        width: 70px;
        height: 70px;
    }
</style>

<div class="dashboard-title card bg-primary">
    <div class="card-body">
        <div class="text-center ">
            <img class="avatar img-circle shadow mt-1" src="{{ admin_asset('@admin/images/logo.png') }}">

            <div class="text-center mb-1">
                <h1 class="mb-3 mt-2 text-white">數據概覽</h1>
                <div class="links">
                    <a href="javascript:void(0);">已開設 <span> 150 </span>天</a>
                    <a href="javascript:void(0);">縂充值 <span> 10000分 </span></a>
                    <a href="javascript:void(0);">縂盈利 <span> 50000分 </span></a>
                    <a href="javascript:void(0);">當前層級 <span> 團長 </span></a>
                </div>
            </div>
        </div>
    </div>
</div>
