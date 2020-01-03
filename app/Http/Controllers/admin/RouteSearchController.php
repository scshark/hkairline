<?php

namespace App\Http\Controllers\admin;

use App\Models\AlRouteSearch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Nexmo\Response;

class RouteSearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
             $limit = $request->input('limit',10);
             $keyWord = $request->input('keyWord','');


             $list = AlRouteSearch::when($keyWord,function ($query) use ($keyWord){

                    $query->where('destination','like','%'.$keyWord.'%');
                })
                 ->orderBy('id','desc')
                 ->paginate($limit)->toArray();



             return response()->json(['errcode'=>0,'msg'=>'获取成功','data'=>$list['data'],'total'=>$list['total']]);
        } else {
            return view('admin.routeSearch.index');
        }
    }


    public function importExcel(Request $request){

        set_time_limit(0);

        if(!empty($request->file('file'))){

            $file = $request->file('file');


            try {
                $data_arr = [];
                $total_num = 0;
                $success_num = 0;
                $error_index = [];
                //error type 1 缺少唯一数据   2 更新失败
                //获取excel 数据
                Excel::load($file->getPathname(), function ($reader) use (&$data_arr,&$total_num,&$success_num,&$error_index) {


                    $reader->each(function ($sheet) use (&$data_arr,&$total_num,&$success_num,&$error_index) {//这里的$sheet变量就是sheet对象了,excel里的每一个sheet
                        $total_num++;
                        $data = $this->dataFormater(array_values($sheet->toArray()));

                        if(empty($data[0]) || empty($data[1]) || empty($data[2])){
                            $error_index[] = ['index'=>$total_num,'type'=>1];
                            return true;
                        }

                        $dateTime = date('Y-m-d H:i:s');
                        $sql_data =  [
                            'company_name' => $data[0],
                            'destination' => $data[1],
                            'air_line' => $data[2],
                            'board_min' => $data[3],
                            'board_n' => $data[4],
                            'board_45k' => $data[5],
                            'board_100k' => $data[6],
                            'board_500k' => $data[7],
                            'board_1000k' => $data[8],
                            'board_2000k' => $data[9],
                            'board_fule' => $data[10],
                            'board_security' => $data[11],
                            'divergence_min' => $data[12],
                            'divergence_n' => $data[13],
                            'divergence_45k' => $data[14],
                            'divergence_100k' => $data[15],
                            'divergence_500k' => $data[16],
                            'divergence_1000k' => $data[17],
                            'divergence_2000k' => $data[18],
                            'divergence_fule' => $data[19],
                            'divergence_security' => $data[20],
                            'effective_date' => $data[21]->toDateString(),
                            'remark' => $data[22],
                            'long_fuel' => $data[23],
                            'short_fuel' => $data[24],
                            'created_at' => $dateTime,
                            'updated_at' => $dateTime
                        ];

                        $search = AlRouteSearch::where('company_name',$data[0])
                                            ->where('destination',$data[1])
                                            ->where('air_line',$data[2])
                                            ->first();



                        if($search){

                            unset($sql_data['created_at']);
                            $res = $search->update($sql_data);
                            if($res){
                                $success_num++;
                            }else{
                                $error_index[] = ['index'=>$total_num,'type'=>2];
                            }

                        }else{
                            $data_arr[] = $sql_data;
                            $success_num++;
                        }



                    });

                }, 'UTF-8');

                if(!empty($data_arr)){
                    $res = DB::table('al_route_search')->insert($data_arr);
                    if (!$res) {
                        return response()->json([
                            'code' => 10001,
                            'msg' => '导入失败，请核对数据模板,刷新页面后重试',
                        ]);
                    }
                }

                return response()->json([
                    'code' => 200,
                    'msg' => '导入成功',
                    'total_num' => $total_num,
                    'success_num' => $success_num,
                    'error_num' => $total_num - $success_num,
                    'error_index' => $error_index
                ]);

            } catch (\Exception $exception) {
                return response()->json([
                    'code' => 10001,
                    'msg' => '导入失败，请核对数据模板 原因：'.$exception->getMessage(),
                ]);
            }

        }

        return response()->json([
            'code'=>10001,
            'msg'=>'无法检测到文件',
        ]);

    }

    public function dataFormater($data){

        if(empty($data)){
            return false;
        }
        foreach ($data as &$item) {
            if(is_float($item)){
                $item = sprintf("%1\$.2f", $item);
            }
        }
        unset($item);

        return $data;

    }

    public function deleteSearch(Request $request){


        $sid = $request->input('s_id');

        if (empty($sid)) {
            return response()->json([
                'code' => 10001,
                'msg' => '参数错误',
            ]);
        }
        $search = AlRouteSearch::where('id', $sid)->first();

        if (!$search) {
            return response()->json([
                'code' => 10001,
                'msg' => '未找到此记录',
            ]);
        }
        $search->delete();


        return response()->json([
            'code' => 200,
            'msg' => '删除成功',
        ]);


    }


    public function searchInfo(Request $request){

        $sid = $request->input('s_id');

        if (empty($sid)) {
            return response()->json([
                'code' => 10001,
                'msg' => '参数错误',
            ]);
        }

        $search = AlRouteSearch::where('id', $sid)->first();

        if (!$search) {
            return response()->json([
                'code' => 10001,
                'msg' => '未找到此记录',
            ]);
        }


        return response()->json([
            'code' => 200,
            'msg' => '查询成功',
            'data'=>$search
        ]);

    }

    public function editSearch(Request $request){

        $request_data =$request->input();
        $sid = $request_data['s_id'];

//        unset($request_data['s_id']);
        if (empty($sid)) {
            return response()->json([
                'code' => 10001,
                'msg' => '参数错误',
            ]);
        }

        if(empty($request_data['company_name']) || empty($request_data['destination']) || empty($request_data['air_line'])){
            return response()->json([
                'code' => 10002,
                'msg' => '请完整填写数据参数',
            ]);
        }

        $search = AlRouteSearch::where('id', $sid)->first();

        if (!$search) {
            return response()->json([
                'code' => 10001,
                'msg' => '未找到此记录',
            ]);
        }


        //检测是否有相同航线存在

        $other_search = AlRouteSearch::where('company_name',$request_data['company_name'])
                                    ->where('destination',$request_data['destination'])
                                    ->where('air_line',$request_data['air_line'])
                                    ->exists();
        if($other_search){
            return response()->json([
                'code' => 10002,
                'msg' => '已存在此航线，请重新填写航线信息',
            ]);
        }

        if($search->update($request_data)){
            return response()->json([
                'code' => 200,
                'msg' => '修改成功',
            ]);
        }else{
            return response()->json([
                'code' => 10001,
                'msg' => '修改失败'
            ]);
        }



    }


    public function addSearch(Request $request){



        $request_data = $request->input();
        if(empty($request_data['company_name']) || empty($request_data['destination']) || empty($request_data['air_line'])){
            return response()->json([
                'code' => 10002,
                'msg' => '请完整填写数据参数',
            ]);
        }
        //检测是否有相同航线存在

        $other_search = AlRouteSearch::where('company_name',$request_data['company_name'])
            ->where('destination',$request_data['destination'])
            ->where('air_line',$request_data['air_line'])
            ->exists();
        if($other_search){
            return response()->json([
                'code' => 10002,
                'msg' => '已存在此航线，无法添加此航线记录',
            ]);
        }

        $res = AlRouteSearch::create($request_data);

        if($res){
            return response()->json([
                'code' => 200,
                'msg' => '添加成功',
            ]);
        }else{
            return response()->json([
                'code' => 10001,
                'msg' => '添加失败'
            ]);
        }
    }

}
