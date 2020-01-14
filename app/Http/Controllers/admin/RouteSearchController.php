<?php

namespace App\Http\Controllers\admin;

use App\Models\AlRouteSearch;
use function GuzzleHttp\Promise\all;
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
                    $query->orWhere('company_name','like','%'.$keyWord.'%');
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


                    //这里的$sheet变量就是sheet对象了,excel里的每一个sheet
                    $reader->each(function ($sheet) use (&$data_arr,&$total_num,&$success_num,&$error_index) {


                        $excel_data = $sheet->toArray();

                        if(empty($excel_data)){
                            return false;
                        }

                        $dateTime = date('Y-m-d H:i:s');
                        foreach ($excel_data as $e_data){
                            $total_num++;

                            if(empty($e_data['AIRLINE']) || empty($e_data['DESTINATION']) || empty($e_data['ROUTE'])){
                                $error_index[] = ['index'=>$total_num,'type'=>1];
                                return true;
                            }

                            $e_data = $this->dataFormater($e_data);

                            $sql_data =  [
                                'company_name' => $e_data['AIRLINE'],
                                'destination' => $e_data['DESTINATION'],
                                'air_line' => $e_data['ROUTE'],
                                'effective_date' => $e_data['EFFECTIVE DATE']->toDateString(),
                                'remark' => $e_data['REMARK'],
//                                'long_fuel' => $e_data['LONG HAUL FUEL'],
//                                'short_fuel' => $e_data['SHORT HAUL FUEL'],
                                'bup_fsc' => $e_data['BUP FSC'],
                                'bup_sc' => $e_data['BUP SC'],
                                'bulk_fsc' => $e_data['BULK FSC'],
                                'bulk_sc' => $e_data['BULK SC'],
                                'table_data'=>$this->getExcelTableData($e_data),
                                'created_at' => $dateTime,
                                'updated_at' => $dateTime
                            ];

                            $search = AlRouteSearch::where('company_name',$sql_data['company_name'])
                                ->where('destination',$sql_data['destination'])
                                ->where('air_line',$sql_data['air_line'])
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
        foreach ($data as $key=>&$item) {
            if(is_float($item)){
                $item = sprintf("%1\$.2f", $item);
            }
            if(is_null($item) && $key != 'REMARK' && $key != 'EFFECTIVE DATE'){
                $item = '0.00';
            }
        }
        unset($item);

        return $data;

    }
    public function getExcelTableData($data){

        if(empty($data)){
            return '';
        }
        $table_data = [];
        foreach ($data as $key=>$item) {

            if(in_array($key,['BUP FSC','BUP SC','BULK FSC','BULK SC'])){
                continue;
            }
            if(strstr($key,'BUP') || strstr($key,'BULK')){
                $table_data[] = ['title'=>$key,'val'=>$item];
            }

        }

        return json_encode($table_data);
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

        $other_search = AlRouteSearch::where('id','<>',$sid)
                                    ->where('company_name',$request_data['company_name'])
                                    ->where('destination',$request_data['destination'])
                                    ->where('air_line',$request_data['air_line'])
                                    ->exists();

        if($other_search){
            return response()->json([
                'code' => 10002,
                'msg' => '已存在此航线，请重新填写航线信息',
            ]);
        }

        $table_data = [];
        if(!empty($request_data['td_title'])){

            $td_body = $request_data['td_body'];

            foreach ($request_data['td_title'] as $key => $td_title){
                if (!$td_title) {
                    continue;
                }
                $table_data[] = ['title'=>$td_title,'val'=>$td_body[$key] ?? '0.00'];
            }
        }
        $save_data = [
            'company_name'=>$request_data['company_name'],
            'destination'=>$request_data['destination'],
            'air_line'=>$request_data['air_line'],
            'effective_date'=>$request_data['effective_date'],
//            'long_fuel'=>$request_data['long_fuel'],
//            'short_fuel'=>$request_data['short_fuel'],
            'bup_fsc'=>$request_data['bup_fsc'],
            'bup_sc'=>$request_data['bup_sc'],
            'bulk_fsc'=>$request_data['bulk_fsc'],
            'bulk_sc'=>$request_data['bulk_sc'],
            'remark'=>$request_data['remark'],
            'table_data'=>json_encode($table_data)
        ];

        if($search->update($save_data)){
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

        $table_data = [];
        if(!empty($request_data['td_title'])){

            $td_body = $request_data['td_body'];

            foreach ($request_data['td_title'] as $key => $td_title){
                if (!$td_title) {
                    continue;
                }
                $table_data[] = ['title'=>$td_title,'val'=>$td_body[$key] ?? '0.00'];
            }
        }
        $save_data = [
            'company_name'=>$request_data['company_name'],
            'destination'=>$request_data['destination'],
            'air_line'=>$request_data['air_line'],
            'effective_date'=>$request_data['effective_date'],
//            'long_fuel'=>$request_data['long_fuel'],
//            'short_fuel'=>$request_data['short_fuel'],
            'remark'=>$request_data['remark'],
            'bup_fsc'=>$request_data['bup_fsc'],
            'bup_sc'=>$request_data['bup_sc'],
            'bulk_fsc'=>$request_data['bulk_fsc'],
            'bulk_sc'=>$request_data['bulk_sc'],
            'table_data'=>json_encode($table_data)
        ];

        $res = AlRouteSearch::create($save_data);

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

    public function deleteAirLine(Request $request){


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


        $res = AlRouteSearch::where('company_name',$search['company_name'])->delete();


        if($res){
            return response()->json([
                'code' => 200,
                'msg' => '删除成功',
            ]);
        }else{
            return response()->json([
                'code' => 200,
                'msg' => '删除失败',
            ]);
        }


    }


    public function fuelInfo(Request $request){

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

    public function editFuel(Request $request){

        $request_data = $request->input();
//        $sid = $request->input('fuel_s_id');
//
//        if (empty($sid)) {
//            return response()->json([
//                'code' => 10001,
//                'msg' => '参数错误',
//            ]);
//        }
//        $search = AlRouteSearch::where('id', $sid)->first();
//
//        if (!$search) {
//            return response()->json([
//                'code' => 10001,
//                'msg' => '未找到此记录',
//            ]);
//        }


        $updata_data = [
            'long_fuel'=>$request_data['long_fuel'],
            'short_fuel'=>$request_data['short_fuel'],
            'fuel_effective_date'=>$request_data['fuel_effective_date']
        ];
        $res = AlRouteSearch::update($updata_data);

        if($res){
            return response()->json([
                'code' => 200,
                'msg' => '修改成功',
            ]);
        }else{
            return response()->json([
                'code' => 200,
                'msg' => '修改失败',
            ]);
        }

    }
}
