<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AlMemberSearchRecord  extends model
{
    use Notifiable;
    //使用软删除
    use SoftDeletes;
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'al_member_search_record';
    //隐藏字段，指定的字段不会返回

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //不会被更新到数据表中的字段
    protected $guarded = [];


}
