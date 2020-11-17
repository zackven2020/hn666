@servers(['web-1' => 'root@8.134.9.30 -p62150'])
{{--@servers(['web-1' => 'root@161.117.9.120 -p22', 'web-2'=> 'root@192.168.174.134 -p22'])--}}


@task('wlpy', ['on' => ['web-1']])
    {{--cd ../www/root/haidacrm/--}}
    {{--git pull--}}

    cd ../www/wwwroot/nb666.ldds.cc/
    git pull
    {{--php artisan admin:export-seed--}}
    {{--php artisan db:seed --class=AdminTablesSeeder--}}
    {{--php artisan migrate:refresh --seed--}}
    {{--php artisan admin:create-user--}}
    {{--git pull origin {{ $branch }}--}}
    {{--composer update--}}
    {{--php artisan migrate--}}
@endtask

