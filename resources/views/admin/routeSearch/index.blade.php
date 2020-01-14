<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>管理后台</title>
    <link rel="stylesheet" href="{{ config('view.admin_assets') }}/css/jquery.toast.css">
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
    .jq-toast-wrap.top-right{
        right: 75px;
        top: 65px;
    }
    .layui-table-body .layui-table-cell{
        height: 80px;
        line-height:80px;
    }
    .layui-table-hover ,.layui-table tbody tr:hover{
        background-color: transparent;
    }
    .layui-table tbody .child_table tr:hover{
        background-color:  #f2f2f2;
    }
    .child_table{
        overflow:auto;
        display: block;
        margin-top: 10px;
    }
    .layui-table-view .child_table th,.layui-table-view .child_table td{
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        height: 32px;
        line-height: 32px;
        padding: 0 15px;
        position: relative;
        box-sizing: border-box;
        min-width: 111px;
        border-width: 1px;
        border-style: solid;
        border-color: #e6e6e6;
    }

    .editBox_delete_btn{
        font-size: 16px;
        height: 38px;
        color: #FF5722;
        line-height: 38px;
        cursor: pointer;
        margin-left: -3px;
    }
    .editBox_item {
        width: 50%;
        margin-right: 0 !important;
        float: left;
    }
    .editBox_item .title_raw {
        width: 100px;
    }
    .editBox_item .body_raw {
        width: 157px;
    }

    .layui-table-body .layui-table-col-special .layui-table-cell{

        line-height: 50px;
    }
    .delete_airline{
        display: block;
        padding: 0;
        margin: -5px 5px 0 !important;
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




                <div class="test-table-reload-btn" id="add_search" style="margin-bottom: 10px;float:left">
                    <button class="layui-btn">添加航线</button>
                </div>
                <div class="test-table-reload-btn" id="import_excel" style=" margin-left:10px;margin-bottom: 10px;float:left">
                    <button class="layui-btn">导入航线</button>
                </div>
                <div class="test-table-reload-btn "  style=" margin-left:10px;margin-bottom: 10px;float:left">
                    <a class="layui-btn  layui-btn-normal" href="{{ config('view.admin_assets') }}/Data Template.xlsx">下载数据模板</a>
                </div>
                <div class="test-table-reload-btn "  style=" margin-left:10px;margin-bottom: 10px;float:left">
                    <a class="layui-btn  layui-btn-normal" href="{{ config('view.admin_assets') }}/Tutorial examples.zip">下载教程</a>
                </div>
                <div class="test-table-reload-btn" style="margin-bottom: 10px;float:right">
                    <div class="layui-inline" style="width:350px;">
                        <input class="layui-input" name="keyWord" autocomplete="off" placeholder="请输入航空公司或目的地">
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

    <div id="editFuelBox" style="display: none; padding: 10px;padding-left: 30px;">
        <div class="layui-form" >
            <form id="editFuel"  enctype="multipart/form-data" >

                <input type="hidden" name="fuel_s_id" >
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="layui-form-item">

                    <div class="layui-inline">
                        <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-2px;">LONG HAUL FUEL :</label>
                        <div class="layui-input-inline" style="width: 150px;">
                            <input type="text" name="long_fuel" autocomplete="off" class="layui-input">
                        </div>
                    </div>


                    <div class="layui-inline">
                        <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-7px;">SHORT HAUL FUEL :</label>
                        <div class="layui-input-inline" style="width: 150px;">
                            <input type="text" name="short_fuel" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">

                    <div class="layui-inline">
                        <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-2px;">FUEL EFFECTIVE DATE :</label>
                        <div class="layui-input-inline" style="width: 430px;">
                            <input type="text" name="fuel_effective_date" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div>

    <div id="editBox" style="display: none; padding: 10px;padding-left: 30px;">
        <div class="layui-form" >
            <form id="editSearch"  enctype="multipart/form-data" style="max-height: 505px !important;overflow-y: scroll;">

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
                    <label class="layui-form-label">BUP FSC :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="bup_fsc" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0;margin-left: -2px">BUP SC:</label>
                    <div class="layui-input-inline" style="width: 222px;">
                        <input type="text" name="bup_sc" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">



                <div class="layui-inline">
                    <label class="layui-form-label">BULK FSC :</label>
                    <div class="layui-input-inline" style="width: 182px;">
                        <input type="text" name="bulk_fsc" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0;margin-left: -2px">BULK SC:</label>
                    <div class="layui-input-inline" style="width: 214px;">
                        <input type="text" name="bulk_sc" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">


                <div class="layui-inline">
                    <label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-2px;">EFFECTIVE DATE
                        :</label>
                    <div class="layui-input-inline" style="width: 469px;">
                        <input type="text" name="effective_date" autocomplete="off" class="layui-input">
                    </div>
                </div>


            </div>


            {{--<div class="layui-form-item">--}}


                {{--<div class="layui-inline">--}}
                    {{--<label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-2px;">LONG HAUL FUEL :</label>--}}
                    {{--<div class="layui-input-inline" style="width: 150px;">--}}
                        {{--<input type="text" name="long_fuel" autocomplete="off" class="layui-input">--}}
                    {{--</div>--}}
                {{--</div>--}}


                {{--<div class="layui-inline">--}}
                    {{--<label class="layui-form-label" style="width: auto;padding-left: 0px;margin-left:-7px;">SHORT HAUL FUEL :</label>--}}
                    {{--<div class="layui-input-inline" style="width: 150px;">--}}
                        {{--<input type="text" name="short_fuel" autocomplete="off" class="layui-input">--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="layui-form-item">

                <div class="layui-inline">
                    <label class="layui-form-label" >REMARK :</label>
                    <div class="layui-input-inline" style="width: 498px;">
                        {{--<input type="text" name="remark" autocomplete="off" class="layui-input">--}}
                        <textarea name="remark"  class="layui-textarea" style="width:100%;height:196px"></textarea>

                    </div>
                </div>
            </div>

            <div id="edit_input_box" class="clearfix">

            </div>
            <div class="layui-form-item">


                <div class="layui-inline">

                    <label class="layui-form-label add_input_box" style="width: auto;color: #1E9FFF;cursor: pointer;padding-left: 0 ">
                        <i class="layui-icon" style="font-size: 16px; color: #1E9FFF;">&#xe654;</i>
                        Add Input Box
                    </label>
                </div>

            </div>

            {{--<div class="layui-form-item">--}}
                {{--<div class="layui-inline editBox_item">--}}
                    {{--<div class="layui-input-inline title_raw">--}}
                        {{--<input type="text" name="divergence_fule" autocomplete="off" class="layui-input">--}}
                    {{--</div>--}}
                    {{--<span style="float: left;width: 13px;height: 38px;line-height: 38px;">  :</span>--}}
                    {{--<div class="layui-input-inline body_raw">--}}
                        {{--<input type="text" name="divergence_fule" autocomplete="off" class="layui-input">--}}
                    {{--</div>--}}
                    {{--<a  class="layui-icon editBox_delete_btn" >&#xe640;</a>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="layui-layer-btn layui-layer-btn-" style="padding-top: 0;">--}}
                {{--<a class="layui-layer-btn0">确定</a>--}}
                {{--<a class="layui-layer-btn1">取消</a>--}}
            {{--</div>--}}
            </form>
        </div>

    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
    </div>
</div>
<script type="text/html" id="tableBarButton">
  <a class="layui-btn layui-btn-xs" lay-event="editSearch">编辑</a>
  <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="delete">删除</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs delete_airline" lay-event="delete_airline">删除航线</a>
</script>

<script src="{{ config('view.admin_assets') }}/js/jquery.min.js"></script>
<script src="{{ config('view.admin_assets') }}/layui/layui.js"></script>
<script src="{{ config('view.admin_assets') }}/js/jquery.toast.js"></script>
<script>

    function showMsg(text, icon, hideAfter) {
        if (heading == undefined) {
            var heading = "提示";
        }
        $.toast({
            text: text,//消息提示框的内容。
            heading: heading,//消息提示框的标题。
            icon: icon,//消息提示框的图标样式。
            showHideTransition: 'fade',//消息提示框的动画效果。可取值：plain，fade，slide。
            allowToastClose: true,//是否显示关闭按钮。(true 显示，false 不显示)
            hideAfter: hideAfter,//设置为false则消息提示框不自动关闭.设置为一个数值则在指定的毫秒之后自动关闭消息提框
            stack: 999,//消息栈。同时允许的提示框数量
            position: 'top-right',//消息提示框的位置：bottom-left, bottom-right,bottom-center,top-left,top-right,top-center,mid-center。
            textAlign: 'left',//文本对齐：left, right, center。
            loader: true,//是否显示加载条
            //bgColor: '#FF1356',//背景颜色。
            //textColor: '#eee',//文字颜色。
            loaderBg: '#ffffff',//加载条的背景颜色。
        });
    }
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


                    layer.alert('导入Excel数据共 '+res.total_num+' 条<br/>成功 '+res.success_num+' 条<br/>失败 '+res.error_num+' 条 <br/>(失败详情查看右侧提示)'); //这时如果你也还想执行yes回调，可以放在第三个参数中。
                    if(res.error_index.length > 0){
                        $.each(res.error_index,function (k,v) {
                            //50000 + k*5000
                            showMsg('第 '+v.index+' 行导入失败，请检查Excel数据后重试','error',false);
                        })
                    }


                } else {
                    layer.msg(res.msg, {icon: 2});
                }
                tableReload();
            }
        });
        //new

        $('.add_input_box').click(function () {



            var input_box = '   <div class="layui-inline editBox_item">\n' +
                '                    <div class="layui-input-inline title_raw">\n' +
                '                        <input type="text" name="td_title[]" autocomplete="off" class="layui-input">\n' +
                '                    </div>\n' +
                '                    <span style="float: left;width: 13px;height: 38px;line-height: 38px;">  :</span>\n' +
                '                    <div class="layui-input-inline body_raw">\n' +
                '                        <input type="text" name="td_body[]" autocomplete="off" class="layui-input">\n' +
                '                    </div>\n' +
                '                    <a href="javascript:;" class="layui-icon editBox_delete_btn" >&#xe640;</a>\n' +
                '                </div>\n';


            if($('.editBox_item').length % 2 < 1){
                //新开一个
                input_box = '<div class="layui-form-item">\n' +input_box + '</div>';
                $('#edit_input_box').append(input_box);
            }else{
                //在同一行在加一个

                $('#edit_input_box .layui-form-item:last').append(input_box);
            }

            $('#editSearch').scrollTop($('#editSearch').get()[0].scrollHeight);
            $('#edit_input_box .layui-form-item:last .title_raw input').focus();
        })

        $(document).on('click','.editBox_delete_btn',function () {

            var box_item = $(this).parent();
            console.log();
            if(box_item.siblings().length > 0){
                box_item.remove();
            }else{
                box_item.parent().remove();
            }
        })
        $('#add_search').click(function () {
            $('#editBox input[type=text],#editBox textarea').val('');

            var flag = false;
            layer.open({
                type: 1,
                title: 'Adding route',
                area: ['710px'], //宽高
                content: $('#editBox'),
                btn: ['确认', '取消']
                ,btn1: function(index) {

                    var formData = new FormData(document.getElementById("editSearch"));
                    $.ajax({
                        url: '{{ route("admin.routeSearch.addSearch") }}',
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

                            }  else if(res.code == 10002) {
                                layer.msg(res.msg, {icon: 2});
                                return false;
                            }else{
                                layer.msg(res.msg, {icon: 2});
                            }
                            layer.close(index);
                            tableReload();
                        })
                        .fail(function() {
                            layer.close(index);
                            layer.msg('网络繁忙', {icon: 2});
                        });
                },
                end: function (index) {
                    //    - 层销毁后触发的回调
                    // $('#userlist_keyword').val('');
                    $('#edit_input_box').html('');
                    layer.close(index);

                },
                cancel:function(index){
                    layer.close(index);
                }
            });
        });


        $(document).on('click','.edit_fuel',function () {
                var s_id = $(this).data('s_id');
                if(!s_id){
                    layer.msg('网络繁忙,请刷新页面', {icon: 2});
                }
                $.ajax({
                    url: '{{ route("admin.routeSearch.fuelInfo") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {_token: '{{csrf_token()}}','s_id':s_id},
                })
                .done(function(res) {

                    if (res.code == 200) {

                        var res_data = res.data;

                        $('input[name=fuel_effective_date]').val(res_data.fuel_effective_date);
                        $('input[name=long_fuel]').val(res_data.long_fuel);
                        $('input[name=short_fuel]').val(res_data.short_fuel);
                        $('input[name=fuel_s_id]').val(res_data.id);


                        layer.open({
                            type: 1,
                            title: '修改燃油费信息',
                            area: ['710px'], //宽高
                            content: $('#editFuelBox'),
                            btn: ['确认', '取消']
                            ,btn1: function(index) {

                                var formData = new FormData(document.getElementById("editFuel"));

                                $.ajax({
                                    url: '{{ route("admin.routeSearch.editFuel") }}',
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

                                    } else if(res.code == 10002) {
                                        layer.msg(res.msg, {icon: 2});
                                        return false;
                                    }else{
                                        layer.msg(res.msg, {icon: 2});
                                    }
                                    layer.close(index);
                                    tableReload();
                                })
                                .fail(function() {
                                    layer.close(index);
                                    layer.msg('网络繁忙', {icon: 2});
                                });
                            }
                            ,end: function (index) {
                                //    - 层销毁后触发的回调
                                // $('#userlist_keyword').val('');
                                layer.close(index);
                            },
                            cancel:function(index){
                                layer.close(index);
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

        });
        table.render({
            elem: '#demo',
            url: '{{ route("admin.routeSearch.index")  }}',
            page: true,
            limit: 5,
            limits: [5,10,20,30,40,50,60,70,80,90],
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
                {field: 'company_name', title: 'AIRLINE', width:151},
                { title: 'DESTINATION', width:128, templet: function (d) {

                        var des_htm = '<span class="destination_name">'+d.destination+'</span>' +
                            '<label class="layui-form-label edit_fuel" data-s_id ='+d.id+' style="width: auto;color: #1E9FFF;cursor: pointer;padding: 0 ">\n' +
                            '                        修改燃油费信息\n' +
                            '                    </label>';
                        return des_htm;
                    }
                },
                {field: 'air_line', title: 'ROUTE', width:181},
                {
                    field: 'table_data', title: 'Table Data', width: 1800, templet: function (d) {

                        var table_data = JSON.parse(d.table_data);
                        if(!table_data){
                            return '';
                        }
                        var table_head = '';
                        var table_body = '';
                        $.each(table_data, function (k, v) {
                            table_head += '<th>'+v.title+'</th>';
                            table_body += '<td>'+v.val+'</td>';
                        });
                        var child_htm = '<div class="layui-form" >\n' +
                            '  <table class="layui-table child_table">\n' +
                            '    <thead>\n' +
                            '      <tr>\n' +
                            table_head +
                            '      </tr> \n' +
                            '    </thead>\n' +
                            '    <tbody>\n' +
                            '      <tr>\n' +
                            table_body +
                            '      </tr>\n' +
                            '    </tbody>\n' +
                            '  </table>\n' +
                            '</div>'
                        ;
                        return child_htm;
                    }
                },
                {field: 'bup_fsc', title: 'BUP FSC', width:181},
                {field: 'bup_sc', title: 'BUP SC', width:181},
                {field: 'bulk_fsc', title: 'BULK FSC', width:181},
                {field: 'bulk_sc', title: 'BULK SC', width:181},
                {field: 'effective_date', title: 'EFFECTIVE DATE', width:181},
                {field: 'remark', title: 'REMARK', width:181},
                // {field: 'long_fuel', title: 'LONG HAUL FUEL', width:181},
                // {field: 'short_fuel', title: 'SHORT HAUL FUEL', width:181},
                // {field: 'fuel_effective_date', title: 'FUEL EFFECTIVE DATE', width:191},
                {field: 'created_at', title: 'Created Date', width:181},
                {fixed: 'right',title: 'Operation', width:121, align:'center', toolbar: '#tableBarButton'}
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
                        var input_box = '';

                        $('input[name=company_name]').val(res_data.company_name);
                        $('input[name=air_line]').val(res_data.air_line);
                        $('input[name=destination]').val(res_data.destination);
                        $('input[name=effective_date]').val(res_data.effective_date);
                        // $('input[name=long_fuel]').val(res_data.long_fuel);
                        $('textarea[name=remark]').val(res_data.remark);
                        // $('input[name=short_fuel]').val(res_data.short_fuel);
                        $('input[name=bup_fsc]').val(res_data.bup_fsc);
                        $('input[name=bup_sc]').val(res_data.bup_sc);
                        $('input[name=bulk_fsc]').val(res_data.bulk_fsc);
                        $('input[name=bulk_sc]').val(res_data.bulk_sc);
                        $('input[name=s_id]').val(res_data.id);
                        if(res_data.table_data){


                            var table_data = JSON.parse(res_data.table_data);
                            $.each(table_data, function (k, v) {


                                var box_htm = '   <div class="layui-inline editBox_item">\n' +
                                    '                    <div class="layui-input-inline title_raw">\n' +
                                    '                        <input type="text" name="td_title[]" autocomplete="off" value="'+v.title+'" class="layui-input">\n' +
                                    '                    </div>\n' +
                                    '                    <span style="float: left;width: 13px;height: 38px;line-height: 38px;">  :</span>\n' +
                                    '                    <div class="layui-input-inline body_raw">\n' +
                                    '                        <input type="text" name="td_body[]" value="'+v.val+'" autocomplete="off" class="layui-input">\n' +
                                    '                    </div>\n' +
                                    '                    <a href="javascript:;" class="layui-icon editBox_delete_btn" >&#xe640;</a>\n' +
                                    '                </div>\n';

                                if(k % 2 < 1){
                                    input_box += '<div class="layui-form-item">' + box_htm;
                                }else{
                                    input_box +=  box_htm + '</div>';
                                }

                            });

                            $('#edit_input_box').html(input_box);

                        }
                        layer.open({
                            type: 1,
                            title: 'edit',
                            area: ['710px'], //宽高
                            content: $('#editBox'),
                            btn: ['确认', '取消']
                            ,btn1: function(index) {

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

                                        } else if(res.code == 10002) {
                                            layer.msg(res.msg, {icon: 2});
                                            return false;
                                        }else{
                                            layer.msg(res.msg, {icon: 2});
                                        }
                                        layer.close(index);
                                        tableReload();
                                    })
                                    .fail(function() {
                                        layer.close(index);
                                        layer.msg('网络繁忙', {icon: 2});
                                    });
                            }
                            ,end: function (index) {
                                //    - 层销毁后触发的回调
                                // $('#userlist_keyword').val('');
                                $('#edit_input_box').html('');
                                layer.close(index);
                            },
                            cancel:function(index){
                                layer.close(index);
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
                
              
            }else if(obj.event == 'delete_airline'){
                layer.confirm('是否确认删除该航线下所有记录？', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        url: '{{ route("admin.routeSearch.deleteAirLine") }}',
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