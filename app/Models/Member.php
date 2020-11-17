<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Traits\MemberTraits;



class Member extends Authenticatable implements JWTSubject
{
    use HasDateTimeFormatter, MemberTraits;

    protected $table = 'member';

    protected $fillable = [
        'account','phone','password','avatar','name'
    ];

    /**
     *  代理
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class,'agent_id','id');
    }

    /**
     * 分公司
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(System::class,'pid','id');
    }

    /**
     * 存款记录
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deposit()
    {
        return $this->hasMany(Deposit::class,'user_id','id');
    }

    public function withdraw()
    {
        return $this->hasMany(Withdraw::class,'user_id','id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return  [];
    }


}
