<?php
namespace App\Repositorys;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\AlMember;
use Monolog\Handler\ElasticSearchHandlerTest;


class MemberRepository
{
   
    public function getMember($account){
        return AlMember::where('account',$account)->first();
    }

    public function getMemberList($keyWord,$limit = 20){

        $list = AlMember::when($keyWord,function($query) use ($keyWord){
                            $query->where('account','like','%'.$keyWord.'%');
                        })
                        ->select('id','account','status','created_at')
                        ->orderBy('id','desc')
                        ->paginate($limit)->toArray();
        return ['errcode'=>0,'msg'=>'查询成功','data'=>$list['data'],'total'=>$list['total']];
    }
    public function saveMember($data){

        if(empty($data['member_id'])){
            $member = $this->getMember($data['account']);
            if($member){
                return ['errcode'=>1,'msg'=>'账号已存在'];
            }

            $res = AlMember::create([
                'account'=>$data['account'],
                'password'=>Hash::make($data['password'])
                ]);
            if($res){
                return ['errcode'=>0,'msg'=>'账号信息添加成功'];
            }
        }else{

            $member = AlMember::find($data['member_id']);

            $member->password = Hash::make($data['password']);
          
            $res = $member->save();
            if($res){
                return ['errcode'=>0,'msg'=>'账号信息更新成功'];
            }

        }
        return ['errcode'=>1,'msg'=>'账号信息保存失败'];
    }

    public function changeMemberStatus($id){

        $member = AlMember::find($id);
        if(!$member){
            return ['errcode'=>0,'msg'=>'此账号不存在'];
        }
        $member->status = $member['status'] == 1 ? 0:1;

        $res = $member->save();

        if($res){
            return ['errcode'=>0,'msg'=>'账号状态修改成功'];
        }else{
            return ['errcode'=>1,'msg'=>'账号状态修改失败'];
        }
    }
    public function deleteMember($id){

        $member = AlMember::find($id);
        if(!$member){
            return ['errcode'=>0,'msg'=>'此账号不存在'];
        }

        $res = $member->delete();

        if($res){
            return ['errcode'=>0,'msg'=>'账号删除成功'];
        }else{
            return ['errcode'=>1,'msg'=>'账号删除失败'];
        }
    }
}