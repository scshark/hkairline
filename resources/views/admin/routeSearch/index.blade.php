<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>管理后台</title>
    <link rel="stylesheet" href="{{ config('view.admin_assets') }}/layui/css/layui.css">
    <style>
    .clearfix:after{content:".";display:block;height:0;clear:both;visibility:hidden}
    .clearfix{*+height:1%;}
    .layui-layer-content{
        height:auto !important;
        
    }
    .layui-form-item{
        margin-bottom: 10px;
    }
    </style>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">后台管理平台</div>

        <ul class="layui-nav layui-layout-right">
            {{--<li class="layui-nav-item">--}}
                {{--<a href="javascript:;">--}}
                    {{--<img src="http://t.cn/RCzsdCq" class="layui-nav-img">--}}
                    {{--{{ Session::get('login_name')  }}--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="layui-nav-item"><a href="{{ route('admin.login.loginout')  }}">退出</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">工作台</a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{ route('admin.index.index')  }}">会员管理</a></dd>
                    </dl>
                    <dl class="layui-nav-child">
                        <dd><a href="{{ route('admin.routeSearch.index')  }}">航线管理</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
        

            <div class="clearfix">

                <div class="test-table-reload-btn "  style=" margin-right:10px;margin-bottom: 10px;float:left">
                    <a class="layui-btn  layui-btn-normal" href="{{ config('view.admin_assets') }}/layui/layui.js">下载数据模板</a>
                </div>

                <div class="test-table-reload-btn" id="import_excel" style="margin-bottom: 10px;float:left">
                    <button class="layui-btn">导入航线</button>
                </div>
                <div class="test-table-reload-btn" style="margin-bottom: 10px;float:right">
                    目的地：
                    <div class="layui-inline" style="width:350px;">
                        <input class="layui-input" name="keyWord" autocomplete="off" >
                    </div>
                    <button class="layui-btn reloadBtn">查询</button>
                </div>
            </div>   
            <table id="demo" lay-filter="memberList"></table>
        </div>
    </div>



    <div id="openMemberBox" style="display: none; padding: 10px;">
        <div class="layui-form" id="layuiadmin-form-useradmin" style="padding: 20px 0 0 0;">
            <div class="layui-form-item">
                <label class="layui-form-label">账号:</label>
                <div class="layui-input-inline">
                    <input type="text" name="account" lay-verify="required" placeholder="请输入账号" autocomplete="off" class="layui-input">
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">密码:</label>
                <div class="layui-input-inline">
                    <input type="text" name="password" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-layer-btn layui-layer-btn-">
                <a class="layui-layer-btn0">确定</a>
                <a class="layui-layer-btn1">取消</a>
            </div>
        </div>
    </div>


    <div id="editBox" style="display: none; padding: 10px;padding-left: 30px;">
        <div class="layui-form" >
            <form id="editSearch"  enctype="multipart/form-data" style="max-height: 520px !important;">

            <input type="hidden" name="s_id" >
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="layui-form-item">



                <div class="layui-inline">
                    <label class="layui-form-label">AIRLINE :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="company_name" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0;margin-left: -2px">DESTINATION :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="destination" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label">ROUTE :</label>
                    <div class="layui-input-inline" style="width: 498px;">
                        <input type="text" name="air_line" autocomplete="off" class="layui-input">
                    </div>
                </div>

            </div>


            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label">BUP MIN :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="board_min" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label">BUP N :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="board_n" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label">BUP +45K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="board_45k" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 13px;">BUP +100K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="board_100k" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 14px;">BUP +500K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="board_500k" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 5px;">BUP +1000K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="board_1000k" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 6px;">BUP +2000K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="board_2000k" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 3px;">FSC（BUP） :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="board_fule" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>



            <div class="layui-form-item">

                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 12px;">SC（BUP） :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="board_security" autocomplete="off" class="layui-input">
                    </div>
                </div>

            </div>
            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label">BULK MIN :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="divergence_min" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" >BULK N :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="divergence_n" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 13px;">BULK +45K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="divergence_45k" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 6px;">BULK +100K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="divergence_100k" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 5px;">BULK +500K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="divergence_500k" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-2px;">BULK +1000K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="divergence_1000k" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-2px;">BULK +2000K :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="divergence_2000k" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-6px;">FSC（BULK） :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="divergence_fule" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>



            <div class="layui-form-item">

                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 3px;">SC（BULK） :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="divergence_security" autocomplete="off" class="layui-input">
                    </div>
                </div>

            </div>

            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-2px;">EFFECTIVE DATE
                        :</label>
                    <div class="layui-input-inline" style="width: 154px;">
                        <input type="text" name="effective_date" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" >REMARK :</label>
                    <div class="layui-input-inline" style="width: 180px;">
                        <input type="text" name="remark" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>


            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-2px;">LONG HAUL FUEL :</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <input type="text" name="divergence_2000k" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-12px;">SHORT HAUL FUEL :</label>
                    <div class="layui-input-inline" style="width: 150px;">
                        <input type="text" name="divergence_fule" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-layer-btn layui-layer-btn-" style="padding-top: 0;">
                <a class="layui-layer-btn0">确定</a>
                <a class="layui-layer-btn1">取消</a>
            </div>
            </form>
        </div>

    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
    </div>
</div>
<script type="text/html" id="tableBarButton">
  <a class="layui-btn layui-btn-xs" lay-event="editSearch">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>

 
<script src="{{ config('view.admin_assets') }}/layui/layui.js"></script>
<script>
    //JavaScript代码区域
    layui.use(['element', 'table', 'upload'], function(){
        var element = layui.element;
        var table = layui.table;
        var $ = layui.$;
        var form = layui.form;
        var upload = layui.upload;



        //new

        //指定允许上传的文件类型
        upload.render({
            elem: '#import_excel'
            ,url: '{{ route("admin.routeSearch.importExcel") }}'
            ,data: {
                _token: '{{csrf_token()}}'
            }
            ,accept: 'file' //普通文件
            ,exts: 'xls|xlsx' //只允许上传压缩文件
            ,before: function(obj){ //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                layer.msg('数据导入中...', {icon: 16, shade: 0.3, time: 0});
            },done: function(res){
                layer.closeAll('dialog'); //关闭loading
                if (res.code == 200) {
                    layer.msg(res.msg, {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 2});
                }
                tableReload();
            }
        });
        //new


        table.render({
            elem: '#demo',
            url: '{{ route("admin.routeSearch.index")  }}',
            page: true,
            // width: 892,
            parseData: function(res){ //res 即为原始返回的数据
                return {
                    "code": res.errcode, //解析接口状态
                    "msg": res.msg, //解析提示文本
                    "count": res.total, //解析数据长度
                    "data": res.data //解析数据列表
                };
            },
            cols: [[
                {field: 'company_name', title: 'AIRLINE', width:181, fixed: 'left'},
                {field: 'destination', title: 'DESTINATION', width:181, fixed: 'left'},
                {field: 'air_line', title: 'ROUTE', width:181, fixed: 'left'},
                {field: 'board_min', title: 'BUP MIN', width:181},
                {field: 'board_n', title: 'BUP N', width:181},
                {field: 'board_45k', title: 'BUP +45K', width:181},
                {field: 'board_100k', title: 'BUP +100K', width:181},
                {field: 'board_500k', title: 'BUP +500K', width:181},
                {field: 'board_1000k', title: 'BUP +1000K', width:181},
                {field: 'board_2000k', title: 'BUP +2000K', width:181},
                {field: 'board_fule', title: 'FSC（BUP）', width:181},
                {field: 'board_security', title: 'SC（BUP）', width:181},
                {field: 'divergence_min', title: 'BULK MIN', width:181},
                {field: 'divergence_n', title: 'BULK N', width:181},
                {field: 'divergence_45k', title: 'BULK +45K', width:181},
                {field: 'divergence_100k', title: 'BULK +100K', width:181},
                {field: 'divergence_500k', title: 'BULK +500K', width:181},
                {field: 'divergence_1000k', title: 'BULK +1000K', width:181},
                {field: 'divergence_2000k', title: 'BULK +2000K', width:181},
                {field: 'divergence_fule', title: 'FSC（BULK）', width:181},
                {field: 'divergence_security', title: 'SC（BULK）', width:181},
                {field: 'effective_date', title: 'EFFECTIVE DATE', width:181},
                {field: 'remark', title: 'REMARK', width:181},
                {field: 'long_fuel', title: 'LONG HAUL FUEL', width:181},
                {field: 'short_fuel', title: 'SHORT HAUL FUEL', width:181},
                {field: 'created_at', title: 'Created Date', width:181},
                {fixed: 'right',title: 'Operation', width:141, align:'center', toolbar: '#tableBarButton'}
            ]],
        });


        table.on('tool(memberList)', function(obj){

            var data = obj.data;
            if(obj.event == 'editSearch'){


                $.ajax({
                    url: '{{ route("admin.routeSearch.searchInfo") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {_token: '{{csrf_token()}}','s_id':data.id},
                })
                .done(function(res) {

                    if (res.code == 200) {

                        var res_data = res.data;

                        $('input[name=company_name]').val(res_data.company_name);
                        $('input[name=air_line]').val(res_data.air_line);
                        $('input[name=board_45k]').val(res_data.board_45k);
                        $('input[name=board_100k]').val(res_data.board_100k);
                        $('input[name=board_500k]').val(res_data.board_500k);
                        $('input[name=board_1000k]').val(res_data.board_1000k);
                        $('input[name=board_2000k]').val(res_data.board_2000k);
                        $('input[name=board_fule]').val(res_data.board_fule);
                        $('input[name=board_min]').val(res_data.board_min);
                        $('input[name=board_n]').val(res_data.board_n);
                        $('input[name=board_security]').val(res_data.board_security);
                        $('input[name=destination]').val(res_data.destination);
                        $('input[name=divergence_45k]').val(res_data.divergence_45k);
                        $('input[name=divergence_100k]').val(res_data.divergence_100k);
                        $('input[name=divergence_500k]').val(res_data.divergence_500k);
                        $('input[name=divergence_1000k]').val(res_data.divergence_1000k);
                        $('input[name=divergence_2000k]').val(res_data.divergence_2000k);
                        $('input[name=divergence_fule]').val(res_data.divergence_fule);
                        $('input[name=divergence_min]').val(res_data.divergence_min);
                        $('input[name=divergence_n]').val(res_data.divergence_n);
                        $('input[name=divergence_security]').val(res_data.divergence_security);
                        $('input[name=effective_date]').val(res_data.effective_date);
                        $('input[name=long_fuel]').val(res_data.long_fuel);
                        $('input[name=remark]').val(res_data.remark);
                        $('input[name=short_fuel]').val(res_data.short_fuel);
                        $('input[name=s_id]').val(res_data.id);

                        layer.open({
                            type: 1,
                            // title: '重置密码',
                            area: ['710px'], //宽高
                            content: $('#editBox'),
                            end: function () {
                                //    - 层销毁后触发的回调
                                // $('#userlist_keyword').val('');
                            },
                            yes: function(index) {

                                var formData = new FormData(document.getElementById("editSearch"));

                                $.ajax({
                                    url: '{{ route("admin.routeSearch.editSearch") }}',
                                    type: 'POST',
                                    dataType: 'json',
                                    cache: false,        // 不缓存数据
                                    processData: false,  // 不处理数据
                                    contentType: false,  // 不设置内容类型
                                    data: formData,
                                    })
                                    .done(function(res) {
                                        if (res.code == 200) {
                                            layer.msg(res.msg, {icon: 1});
                                        } else {
                                            layer.msg(res.msg, {icon: 2});
                                        }
                                        layer.close(index);
                                        tableReload();
                                    })
                                    .fail(function() {
                                        layer.close(acc);
                                        layer.msg('网络繁忙', {icon: 2});
                                    });
                            }
                        });

                    } else {
                        layer.msg(res.errmsg, {icon: 2});

                    }
                })
                .fail(function() {
                    layer.msg('网络繁忙', {icon: 2});
                })
                .always(function() {
                    console.log("complete");
                });



                    
            }else if(obj.event == 'delete'){

                layer.confirm('是否确认删除该记录？', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        url: '{{ route("admin.routeSearch.deleteSearch") }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {_token: '{{csrf_token()}}','s_id':data.id},
                    })
                    .done(function(res) {
                        if (res.code == 200) {
                            layer.msg(res.msg, {icon: 1});
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                        tableReload();
                    })
                    .fail(function() {
                        layer.msg('网络繁忙', {icon: 2});
                    });
                });   
                
              
            }

        })


        $('.reloadBtn').on('click', function () {
            tableReload();
        });


        function tableReload(){
            var keyWord = $('input[name="keyWord"]').val();
            //执行重载
            table.reload('demo', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    keyWord: keyWord
                }
            });
        }
    });
</script>
</body>
</html>