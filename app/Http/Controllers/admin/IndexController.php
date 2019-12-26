<?php

namespace App\Http\Controllers\admin;

use http\Client\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
// use App\Repositorys\CisUserRepository;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositorys\MemberRepository;
// use App\Repositorys\CisTeacherRepository;
// use App\Repositorys\FinaFinaceRepository;
class IndexController extends Controller
{
    /**
     * 虚拟用户列表
     * @return int
     */
    public function index(Request $request){
        if ($request->ajax()) {
            $data = $request->input();
            $memberRepo = new MemberRepository();
            
            $keyWord = $data['keyWord'] ?? '';

            $result = $memberRepo->getMemberList($keyWord,$data['limit'] ?? 20);
            return response()->json($result);
        } else {
            return view('admin.index.index');
        }
    }


    public function addMember(Request $request){
        if ($request->ajax()) {
            $data = $request->input();
            if(empty($data['account']) || empty($data['account'])){
                return response()->json(['errcode'=>1,'msg'=>'请填写账号和密码']);
            }
            $memberRepo = new MemberRepository();
       
            $result = $memberRepo->saveMember($data);

            return response()->json($result);
        }
    }

    public function changeMemberStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->input();
            if(empty($data['member_id'])){
                return response()->json(['errcode'=>1,'msg'=>'参数错误']);
            }
            $memberRepo = new MemberRepository();
       
            $result = $memberRepo->changeMemberStatus($data['member_id']);

            return response()->json($result);
        }
    }

    public function resetMemberPassword(Request $request){
        if ($request->ajax()) {
            $data = $request->input();
            if(empty($data['member_id']) && empty($data['password'])){
                return response()->json(['errcode'=>1,'msg'=>'参数错误']);
            }
            $memberRepo = new MemberRepository();
       
            $result = $memberRepo->saveMember($data);

            return response()->json($result);
        }
    }

    public function deleteMember(Request $request){

        if ($request->ajax()) {
            $data = $request->input();
            if(empty($data['member_id'])){
                return response()->json(['errcode'=>1,'msg'=>'参数错误']);
            }
            $memberRepo = new MemberRepository();
       
            $result = $memberRepo->deleteMember($data['member_id']);

            return response()->json($result);
        }

    }


    public function airLine(){
        
        if ($request->ajax()) {
            $data = $request->input();
            $memberRepo = new MemberRepository();
            
            $keyWord = $data['keyWord'] ?? '';

            $result = $memberRepo->getMemberList($keyWord,$data['limit'] ?? 20);
            return response()->json($result);
        } else {
            return view('admin.index.index');
        }
    }

}
