<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RouteSearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            dd(123);
            // $page = $request->input('page');
            // $limit = $request->input('limit');
            // $name = $request->input('name','');

            // $virtualRepository = new VirtualRepository();
            // $list = $virtualRepository->getCourseList($page, $limit, $name);
            // return response()->json($list);
        } else {
            return view('admin.routeSearch.index');
        }
    }



}
