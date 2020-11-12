<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
	use HasDateTimeFormatter,ModelTree;

    protected $table = 'agent';

    // 返回空值即可禁用 order 字段
    public function getOrderColumn()
    {
        return null;
    }

    public function member()
    {
        return $this->hasMany(Member::class, 'agent_id', 'id');
    }

    /**
     * 获取子模块
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenModule()
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    /**
     * 递归获取子模块
     * @return mixed
     */
    public function children()
    {
        return $this->childrenModule()->with('children');
    }

}
