<?php

namespace App\Http\Controllers\Api;


// use App\User;
use App\Models\AlMemberSearchRecord;
use App\Models\AlRouteSearch;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use http\Client\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use App\Repositorys\CisTeacherRepository;
// use App\Repositorys\FinaFinaceRepository;
class UserController extends Controller
{


    /**
     * 授权登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
      
        $credentials = request(['account', 'password']);
        $jwt_token = null;
        if (!$jwt_token = auth('api')->attempt($credentials)) {
            throw new Exception("Invalid Account or Password");

        }
        return response()->json([
            'code' => 200,
            'msg' => 'success',
            'token' => $jwt_token,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * 获取用户信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo()
    {



        $user = auth('api')->user()->toArray();
        return response()->json([
            'code' => 200,
            'msg' => 'success',
            'data'=>[
                'account'=>$user["account"],
                'create_time'=>$user["created_at"],
            ]
        ]);
    }

    /**
     * 注销
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'code' => 200,
            'msg' => 'Successfully logged out'
        ]);
    }

    /**
     * 刷新token
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json([
            'code' => 200,
            'msg' => 'success',
            'token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function airLineSearch(Request $request){

        $keyword = $request->input("keyword");
        $limit = $request->input("limit") ?? 10;
        if(empty($keyword)){
            throw new Exception("Keywords cannot be empty");
        }

        $user = auth('api')->user();

        AlMemberSearchRecord::create([
            'user_id'=>$user->id,
            'keyword'=>$keyword
        ]);

        $result = AlRouteSearch::where("destination",$keyword)->orderBy('id','desc')->paginate($limit)->toArray();


        $res_data = [
            'long_distance_fuel_costs'=>$result['data'][0]['long_fuel'] ?? '',
            'short_distance_fuel_costs'=>$result['data'][0]['short_fuel'] ?? '',
            'expire_date'=>date('Y-m-d'),
            'list'=>$result['data']
        ];


        return response()->json([
            'code' => 200,
            'msg' => 'success',
            'data' => $res_data,
            'has_next' => ($result['current_page'] == $result['last_page']) ? false:true,
            'total' => $result['total'],
        ]);

    }

}
