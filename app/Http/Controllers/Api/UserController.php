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
    public function login(Request $request)
    {

        $credentials = request(['account', 'password']);
        $jwt_token = null;
        if (!$jwt_token = auth('api')->attempt($credentials)) {
            throw new Exception("Invalid Account or Password");

        }
        $user = auth('api')->user()->toArray();

        if (!$user['status']) {
            throw new Exception("Account is blocked");
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
            'data' => [
                'account' => $user["account"],
                'create_time' => $user["created_at"],
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

    public function airLineSearch(Request $request)
    {

        $keyword = $request->input("keyword");
        $limit = $request->input("limit") ?? 10;
        if (empty($keyword)) {
            throw new Exception("Keywords cannot be empty");
        }

        $user = auth('api')->user();

        AlMemberSearchRecord::create([
            'user_id' => $user->id,
            'keyword' => $keyword
        ]);

        $result = AlRouteSearch::where("destination", 'like', '%' . $keyword . '%')->orderBy('id', 'desc')->paginate($limit)->toArray();


        $list_data = [];
        if (!empty($result['data'])) {

            foreach ($result['data'] as $item) {

                $table_data = (empty($item['table_data']))?'':json_decode($item['table_data'], true);


                if (empty($table_data)) {
                    $list_data[] = $item;
                    continue;
                }

                $table_data_formate = [];

                //数据格式转换
                foreach ($table_data as $table) {

                    $space_pos = strpos($table['title'], ' ');

                    $t_name = substr($table['title'], $space_pos + 1);
                    $t_prefix = substr($table['title'], 0, $space_pos);

                    $table_data_formate[$t_name][$t_prefix] = $table['val'];
                }

                foreach ($table_data_formate as $key => $t_data) {

                    $item['tableTitle'][] = $key;

                    $item['table']['bup'][] = (!empty($t_data['BUP'])) ? $t_data['BUP']:($t_data['bup'] ?? '0.00');
                    $item['table']['bulk'][] = (!empty($t_data['BULK'])) ? $t_data['BULK']:($t_data['bulk'] ?? '0.00');

                }
                $list_data[] = $item;
            }
        }
        $res_data = [
            'long_distance_fuel_costs' => $result['data'][0]['long_fuel'] ?? '',
            'short_distance_fuel_costs' => $result['data'][0]['short_fuel'] ?? '',
            'expire_date' => date('Y-m-d'),
            'list' => $list_data
        ];


        return response()->json([
            'code' => 200,
            'msg' => 'success',
            'data' => $res_data,
            'has_next' => ($result['current_page'] == $result['last_page']) ? false : true,
            'total' => $result['total'],
        ]);

    }

}
