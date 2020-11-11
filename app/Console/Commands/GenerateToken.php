<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;
use function Symfony\Component\String\u;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '快速生成 token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->ask('输入用户 id');

        $user = Member::find($userId);

        if(!$user){
            return  $this->error('用户不存在');
        }

        $ttl = 365*24*60;
        $this->info(auth('api')->setTTL($ttl)->login($user));
    }

}
