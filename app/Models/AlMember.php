<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AlMember  extends Authenticatable implements JWTSubject
{
    use Notifiable;
    //使用软删除
    use SoftDeletes;
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'al_member';
    //隐藏字段，指定的字段不会返回
    protected $hidden = [
        'password', 'remember_token'
    ];
    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //不会被更新到数据表中的字段
    protected $guarded = [];

    /**
     * 获取会储存到 jwt 声明中的标识
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 返回包含要添加到 jwt 声明中的自定义键值对数组
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ['role' => 'AlMember'];
    }
    

}
