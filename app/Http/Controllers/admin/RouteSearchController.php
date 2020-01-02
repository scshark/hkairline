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

        if(!empty($request->file('file'))){
            $file = $request->file('file');


            try {
                $data_arr = [];
                //获取excel 数据
                Excel::load($file->getPathname(), function ($reader) use (&$data_arr) {


                    $reader->each(function ($sheet) use (&$data_arr) {//这里的$sheet变量就是sheet对象了,excel里的每一个sheet
                        $data = $this->dataFormater(array_values($sheet->toArray()));

                        if ($data) {

                            $dateTime = date('Y-m-d H:i:s');
                            $data_arr[] = [
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
                        }


                    });

                }, 'UTF-8');

                $res = DB::table('al_route_search')->insert($data_arr);
                if ($res) {
                    return response()->json([
                        'code' => 200,
                        'msg' => '导入成功',
                    ]);
                } else {
                    return response()->json([
                        'code' => 10001,
                        'msg' => '导入失败，请核对数据模板',
                    ]);
                }

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


}
