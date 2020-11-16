<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentInfo extends Model
{
    use HasFactory;

    protected $table = 'agent_info';

    protected $fillable = [
        'day_deposit','day_withdraw','win_and_lose','day_agent',
        'day_member','day_total_member','agent_id'
    ];


    public function agent()
    {
        return $this->belongsTo(Agent::class, 'id', 'agent_id');
    }





}
