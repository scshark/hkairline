<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>管理后台</title>
    <link rel="stylesheet" href="{{ config('view.admin_assets') }}/layui/css/layui.css">
    <style>
        .selectCourse.active{
            background: #1E9FFF;
        }
        .buyCourse.active{
            background: #FF5722;
        }
    </style>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">后台管理平台</div>

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    {{ Session::get('login_name')  }}
                </a>
            </li>
            <li class="layui-nav-item"><a href="{{ route('admin.login.loginout')  }}">退了</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">会员管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{ route('admin.index.add')  }}">添加虚拟会员</a></dd>
                        <dd><a href="{{ route('admin.index.addOrder')  }}">购买课程</a></dd>
                        <dd><a href="{{ route('admin.index.index')  }}">会员列表</a></dd>
                        {{--<dd><a href="{{ route('admin.index.orderlist')  }}">订单列表</a></dd>--}}
                        <dd><a href="{{ route('admin.index.mobile')  }}">导入号码</a></dd>
                    </dl>

                </li>
{{--                <li class="layui-nav-item layui-nav-itemed">--}}
{{--                    <a class="" href="javascript:;">订单管理</a>--}}
{{--                    <dl class="layui-nav-child">--}}
{{--                        <dd><a href="{{ route('admin.virtual.courseList')  }}">课程列表</a></dd>--}}
{{--                    </dl>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <form class="layui-form" action="#">
                @csrf
                <div class="layui-form-item">
                    <label class="layui-form-label">选择地区</label>
                    <div class="layui-input-block">
                         <div class="layui-input-inline" id="province_val">
                            <select name="P1" lay-filter="province" id="province">
                                <option></option>
                            </select>
                        </div>
                        <div class="layui-input-inline" id="city_val">
                            <select name="C1" lay-filter="city" id="city">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">会员类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="isvip" value="2" title="普通会员" checked lay-filter="isvip">
                        <input type="radio" name="isvip" value="1" title="VIP会员" lay-filter="isvip">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">用户账号</label>
                    <div class="layui-input-inline">
                        <input type="hidden" name="user_id" id="user_id" lay-verify="user_id" >
                        <input type="text" name="user_account" id="user_account" disabled="disabled"  lay-verify="user_mobile" placeholder="点击按钮选取用户账号" autocomplete="off" class="layui-input layui-disabled" style="color:#000 !important;">
                    </div>
                    {{--<div class="layui-form-mid layui-word-aux"><button type="button" class="layui-btn layui-btn-sm create-mobile" data-ele="user_mobile">生成</button></div>--}}
                    {{--<div class="layui-form-mid layui-word-aux"><button type="button" class="layui-btn layui-btn-sm create-mobile2" data-ele="user_mobile">随机</button></div>--}}
                    <div class="layui-form-mid layui-word-aux" style="padding-top: 0 !important;"><button type="button" class="layui-btn  getUserList" >选取账号</button></div>
                </div>





                <div class="layui-form-item vip-users-group ">
                    <label class="layui-form-label">老师查询</label>
                    <div class="layui-input-inline">
                        <input type="text" name="teacher_keyword" placeholder="输入老师姓名或昵称" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux" style="padding-top: 0 !important;"><button type="button" data-vip_status = "1" class="layui-btn teacherSearch">查询</button></div>
                </div>

                <div class="layui-form-item vip-users-group">
                    <label class="layui-form-label">选择老师</label>
                    <div class="layui-input-inline" style="width: 450px;">
                        <select name="teacherList" lay-filter="teacherList"  lay-search="teacherList" lay-verify="teacherList">
                            <option value="">请选择老师</option>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item  courseGroup layui-hide">
                    <label class="layui-form-label">选择课程</label>
                    <div class="layui-input-inline" style="width: auto">
                        <table id="courseList" lay-filter="courseList"></table>
                    </div>
                </div>


                <div class="layui-form-item  sectionGroup layui-hide" >
                    <label class="layui-form-label">选择章节</label>
                    <div class="layui-input-inline" style="width: auto">

                        <table  id="sectionList" lay-filter="sectionList"></table>

                    </div>
                </div>




                <div class="layui-form-item vip-group ">
                    <label class="layui-form-label">支付方式</label>
                    <div class="layui-input-block">
                        <input type="radio" name="paytype" value="1" title="支付宝" checked>
                        <input type="radio" name="paytype" value="2" title="微信">
                        <input type="radio" name="paytype" value="4" title="苹果">
                    </div>
                </div>


                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-primary" onclick="window.location.reload()">重置</button>
                        <button class="layui-btn" type="button" lay-submit lay-filter="formDemo">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="openUserBox" style="display: none; padding: 10px;">
        <div style="margin-bottom: 10px;">
            <span>账号：</span>
            <div class="layui-inline">
                <input type="text" autocomplete="off" name="userlist_keyword" id="userlist_keyword" placeholder="请输入账号或昵称" class="layui-input" style="height:32px;" >
            </div>
            <button class="layui-btn layui-btn-sm" id="searchAreaUser" ><i class="layui-icon layui-icon-search"></i>&nbsp;查询</button>
        </div>
        <table id="openUserListable" lay-filter="openUserListable"></table>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
    </div>
</div>


<script src="{{ config('view.admin_assets') }}/layui/layui.js"></script>
<script>
    layui.config({
        base: '{{ config('view.admin_assets') }}/layui/lay/modules/'//拓展模块的根目录
    }).extend({
        pca: 'pca'
    });

    layui.use(['element', 'form','table','laydate', 'layedit','upload', "jquery", "pca"], function(){
        var element = layui.element;
        var form = layui.form;
        var $ = layui.$;
        var laydate = layui.laydate;
        var pca = layui.pca;
        var table = layui.table;

        laydate.render({
            elem: '#test1', //指定元素
            type: 'datetime',
            max: 0
        });
        pca.init('select[name=P1]', 'select[name=C1]');

        var agent_type = 1;
        form.verify({
            user_mobile: function(val) {
                if (!val) {
                    return '请选取用户账号';
                }
            },
            user_id: function(val) {
                if (!val) {
                    return '请选取用户账号';
                }
            },
            teacherList: function(val) {
                if (!val) {
                    return '请选择老师';
                }
            }
        });
        /**
         * 用户手机号码生成
         */
        $('.create-mobile').on('click', function() {
            var ele = $(this).data('ele');
            
            var province_val = $("#province_val input[type='text']").val();
            var city_val = $("#city_val input[type='text']").val();
            var acc = layer.msg('手机号码生成中...', {icon: 16, shade: 0.3, time: 0});
            var mobile = '';
            $.ajax({
                url: '{{ route("admin.virtual.createMobile") }}',
                type: 'POST',
                dataType: 'json',
                data: {_token: '{{csrf_token()}}','province':province_val,'city':city_val},
            })
            .done(function(res) {
                layer.close(acc);
                if (res.errcode == 0) {
                    $('input[name="'+ele+'"]').val(res.mobile);
                    layer.msg(res.errmsg, {icon: 1});
                } else {
                    layer.msg(res.errmsg, {icon: 2});
                }
            })
            .fail(function() {
                layer.close(i);
                layer.msg('网络繁忙', {icon: 2});
            })
            .always(function() {
                console.log("complete");
            });

        });
        $('.create-mobile2').on('click', function() {
            var ele = $(this).data('ele');
            var province_val = $("#province_val input[type='text']").val();
            var city_val = $("#city_val input[type='text']").val();
            var acc = layer.msg('手机号码抽取中...', {icon: 16, shade: 0.3, time: 0});
            var mobile = '';
            $.ajax({
                url: '{{ route("admin.virtual.getMobile") }}',
                type: 'POST',
                dataType: 'json',
                data: {_token: '{{csrf_token()}}','province':province_val,'city':city_val},
            })
            .done(function(res) {
                layer.close(acc);
                if (res.errcode == 0) {
                    $('input[name="'+ele+'"]').val(res.mobile);
                    layer.msg(res.errmsg, {icon: 1});
                } else {
                    layer.msg(res.errmsg, {icon: 2});
                }
            })
            .fail(function() {
                layer.close(i);
                layer.msg('网络繁忙', {icon: 2});
            })
            .always(function() {
                console.log("complete");
            });
            $('input[name="'+ele+'"]').val(mobile);
        });

        /**
         * 切换平台或代理商
         */
        form.on('radio(agent_type)', function(data) {
            agent_type = data.value;
            if (agent_type == 1) {
                // 平台
                $('.agent-group,.users-group,.vip-users-group').removeClass('layui-show').addClass('layui-hide');
            } else if (agent_type == 2) {
                // 代理商
                $('.users-group').addClass('layui-hide');
                $('.vip-users-group').addClass('layui-hide');
                $('.agent-group').removeClass('layui-hide').addClass('layui-show');
            } else if(agent_type == 3) {
                // 用户
                $('.agent-group').addClass('layui-hide');
                $('.vip-users-group').addClass('layui-hide');
                $('.users-group').removeClass('layui-hide').addClass('layui-show');
            }else if(agent_type == 4) {
                // VIP用户
                $('.users-group').addClass('layui-hide');
                $('.agent-group').addClass('layui-hide');
                $('.vip-users-group').removeClass('layui-hide').addClass('layui-show');
            }
        });
        // 会员类型
        form.on('radio(isvip)', function(data) {
            if (data.value == 1) {
                // vip
                $('.vip-group').removeClass('layui-hide').addClass('layui-show');
                $('[name="agent_type"][value="3"]').prop('disabled', false);
                $('[name="agent_type"][value="1"]').trigger('click');
                $('.agent-group,.users-group').removeClass('layui-show').addClass('layui-hide');
                form.render();
            } else {
                $('[name="createprev"][value="0"]').trigger('click');
                $('.vip-group').removeClass('layui-show').addClass('layui-hide');
                $('[name="agent_type"][value="3"]').prop('disabled', false);
                $('.create-group').removeClass('layui-show').addClass('layui-hide');
                form.render();
            }
        });
        // 是否生成上级账号
        form.on('radio(createprev)', function(data) {
            if (data.value == 1) {
                $('.create-group').removeClass('layui-hide').addClass('layui-show');
                // $('.prevBtn').trigger('click');
            } else {
                $('.create-group').removeClass('layui-show').addClass('layui-hide');
            }
        });

        // 关键字查询代理商
        $('.seach-agent').on('click', function() {
            var keywords = $('input[name="keywords"]').val();
            if (!keywords) {
                layer.msg('请输入关键字', {icon: 2});
                return false;
            }
            var i = layer.msg('数据查找中...', {icon: 16, shade: 0.3, time: 0});
            $.ajax({
                url: '{{ route("admin.index.getAgent") }}',
                type: 'POST',
                dataType: 'json',
                data: {keywords: keywords, _token: '{{csrf_token()}}'},
            })
            .done(function(res) {
                layer.close(i);
                layer.msg(res.errmsg, {icon: 1});

                var htmls = '<option value="">请选择代理商</option>';
                $.each(res.data, function(index, val) {
                    htmls += '<option value="'+val.user_id+'">姓名：'+val.name+' | 手机：'+val.mobile+'</option>';
                });
                $('select[name="agent_id"]').empty().append(htmls);

                form.render('select');
            })
            .fail(function() {
                layer.close(i);
                layer.msg('网络繁忙', {icon: 2});
            })
            .always(function() {
                console.log("complete");
            });
        });
        // 关键字查询用户
        $('.teacherSearch').on('click', function() {
            var teacher_keyword = $('input[name="teacher_keyword"]').val();
            if (!teacher_keyword) {
                layer.msg('请输入关键字', {icon: 2});
                return false;
            }

            if(!$('.courseGroup').hasClass('layui-hide')){
                $('.courseGroup').addClass('layui-hide');
            }
            if(!$('.sectionGroup').hasClass('layui-hide')){
                $('.sectionGroup').addClass('layui-hide');
            }

            var i = layer.msg('数据查找中...', {icon: 16, shade: 0.3, time: 0});
            $.ajax({
                    url: '{{ route("admin.index.getTeacherList") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {keywords: teacher_keyword , _token: '{{csrf_token()}}'},
                })
                .done(function(res) {
                    layer.close(i);
                    layer.msg(res.errmsg, {icon: 1});

                    var htmls = '<option value="">请选择老师</option>';
                    $.each(res.data, function(index, val) {
                        htmls += '<option value="'+val.id+'">姓名：'+val.name+' | 昵称：'+val.nickname+' | 账号：'+val.account+'</option>';
                    });
                    $('select[name="teacherList"]').empty().append(htmls)

                    form.render('select');
                })
                .fail(function() {
                    layer.close(i);
                    layer.msg('网络繁忙', {icon: 2});
                })
                .always(function() {
                    console.log("complete");
                });
        });

        form.on('submit(formDemo)', function(data) {


            var course_id = 0;
            var section_id = 0;

            $('.buyCourse').each(function (k,v) {
                if($(this).hasClass('active')){
                    course_id = $(this).data('course_id');
                    return false;
                }
            });

            //不是购买全章
            if(!course_id){
                var checkStatus = table.checkStatus('sectionList');
                if(checkStatus.data[0] && checkStatus.data[0]['id']){
                    section_id = checkStatus.data[0]['id'];
                }
            }
            if(course_id == 0 && section_id == 0){
                layer.msg('请选择课程或课程章节', {icon: 2});
                return false;
            }
            var i = layer.msg('数据添加中...', {icon: 16, shade: 0.3, time: 0});
            var sub_field = data.field;
            sub_field.course_id = course_id;
            sub_field.section_id = section_id;


            // if(sub_field.agent_type == 4 && sub_field.users_id2){
            //     sub_field.users_id = sub_field.users_id2;
            // }
            $.ajax({
                url: '{{ route("admin.index.addOrder") }}',
                type: 'POST',
                dataType: 'json',
                data: sub_field,
            })
            .done(function(res) {
                layer.close(i);
                if (res.errcode == 0) {
                    layer.msg(res.errmsg, {icon: 1}, function () {
                        window.location.href = res.url;
                    });
                } else {
                    layer.msg(res.errmsg, {icon: 2});
                }
            })
            .fail(function() {
                layer.close(i);
                layer.msg('网络繁忙', {icon: 2});
            })
            .always(function() {
                console.log("complete");
            });
            
            return false;
        });

        //监听表格复选框选择
        // table.on('checkbox(test)', function(obj){
        //     console.log(obj)
        // });
        //监听工具条
        // table.on('tool(demo)', function(obj){
        //     var data = obj.data;
        //     if(obj.event === 'detail'){
        //         layer.msg('ID：'+ data.id + ' 的查看操作');
        //     } else if(obj.event === 'del'){
        //         layer.confirm('真的删除行么', function(index){
        //             obj.del();
        //             layer.close(index);
        //         });
        //     } else if(obj.event === 'edit'){
        //         layer.alert('编辑行：<br>'+ JSON.stringify(data))
        //     }
        // });

        // var $ = layui.$, active = {
        //     getCheckData: function(){ //获取选中数据
        //         var checkStatus = table.checkStatus('idTest')
        //             ,data = checkStatus.data;
        //         layer.alert(JSON.stringify(data));
        //     }
        //     ,getCheckLength: function(){ //获取选中数目
        //         var checkStatus = table.checkStatus('idTest')
        //             ,data = checkStatus.data;
        //         layer.msg('选中了：'+ data.length + ' 个');
        //     }
        //     ,isAll: function(){ //验证是否全选
        //         var checkStatus = table.checkStatus('idTest');
        //         layer.msg(checkStatus.isAll ? '全选': '未全选')
        //     }
        // };

        // $('.demoTable .layui-btn').on('click', function(){
        //     var type = $(this).data('type');
        //     active[type] ? active[type].call(this) : '';
        // });
        //
        // table.render({
        //     elem: '#sectionList'
        //     ,url:'/test/table/demo1.json'
        //     ,cols: [[
        //         {type:'checkbox',field:'id', fixed: 'left'}
        //         ,{field:'title', width:300,title:'课程章节标题', fixed: true}
        //         ,{field:'price', width:100,title:'价格', fixed: true}
        //
        //     ]]
        //     ,text: {
        //         none: '暂无相关数据' //默认：无数据。注：该属性为 layui 2.2.5 开始新增
        //     }
        // });


        //选取账号按钮
        $('.getUserList').on('click', function() {



            layer.open({
                type: 1,
                title: '选取账号',
                area: ['1148px','610px'], //宽高
                content: $('#openUserBox'),
                end: function () {
                    //    - 层销毁后触发的回调
                    $('#userlist_keyword').val('');
                },
                success: function() {
                    getAreaUserList();
                }
            });

        });

        //选择账号弹出层中的 关键词查询按钮
        $('#searchAreaUser').click(function(){
            getAreaUserList();
        });

        form.on('select(teacherList)',function (data) {


            var teacher_id = data.value;

            if(teacher_id){
                $('.courseGroup').removeClass('layui-hide');
            }

            if(!$('.sectionGroup').hasClass('layui-hide')){
                $('.sectionGroup').addClass('layui-hide');
            }

            table.render({
                elem: '#courseList',
                id: 'courseList',
                height: 500,
                method: 'post', //接口http请求类型，默认：get
                url: '{{ route("admin.index.getCourseList") }}',
                where: {
                    teacher_id: teacher_id,
                    _token: '{{csrf_token()}}'
                }
                ,response: {
                    statusName: 'errcode', //规定数据状态的字段名称，默认：code
                    statusCode: 0, //规定成功的状态码，默认：0
                    msgName: 'errmsg', //规定状态信息的字段名称，默认：msg
                    countName: 'total', //规定数据总数的字段名称，默认：count
                    dataName: 'data', //规定数据列表的字段名称，默认：data
                }
                ,page:true
                ,cols: [
                    [{
                        field: 'id', //字段名
                        title: '课程ID', //标题
                        width: 120,
                        //fixed: 'left' //固定列
                    }, {
                        field: 'name', //字段名
                        title: '课程标题', //标题
                        width: 300,
                        //fixed: 'left' //固定列
                    }, {
                        field: 'type', //字段名
                        title: '课程类型', //标题
                        width: 100,
                        templet: function(d) {
                            if (d.type == 1) {
                                return '免费课程'
                            } else if(d.type == 2){
                                return '付费课程'
                            } else if(d.type == 3){
                                return '互动直播'
                            } else if(d.type == 4){
                                return 'VIP课程'
                            }
                        }
                        //fixed: 'left' //固定列
                    }, {
                        field: 'price', //字段名
                        title: '价格', //标题
                        width: 110,
                        //fixed: 'left' //固定列
                    }, {
                        field: 'status', //字段名
                        title: '状态', //标题
                        width: 80,
                        templet: function(d) {
                            if (d.status == 1) {
                                return '正常'
                            }  else if(d.status == 2){
                                return '审核中'
                            } else if(d.status == 3){
                                return '不通过'
                            } else if(d.status == 4){
                                return '已下架'
                            }
                        }
                        //fixed: 'left' //固定列
                    }, {
                        field: 'created_at', //字段名
                        title: '创建日期', //标题
                        width: 200,
                        //fixed: 'left' //固定列
                    }, {
                        // field: 'id', //字段名
                        title: '操作', //标题
                        width: 205,
                        templet: function(d) {
                            return '<button type="button" class="layui-btn layui-btn-sm buyCourse"  data-course_id="'+d.id+'" >购买全章</button>' +
                                '<button type="button" class="layui-btn layui-btn-sm selectCourse"  data-course_id="'+d.id+'" >显示章节</button>'
                        },
                        // sort: true //是否允许排序 默认：false
                        //fixed: 'left' //固定列
                    }]
                ]
            });

        });
        $(document).on('click','.buyCourse',function(e){

            $('.buyCourse').removeClass('active').text('购买全章');
            $('.selectCourse').removeClass('active').text('显示章节');
            $(this).addClass('active').text('已选购买全章');
            if(!$('.sectionGroup').hasClass('layui-hide')){
                $('.sectionGroup').addClass('layui-hide');
            }
        });
        $(document).on('click','.selectCourse',function(e){

            var course_id = $(this).data('course_id');
            $('.buyCourse').removeClass('active').text('购买全章');
            $('.selectCourse').removeClass('active').text('显示章节');
            $(this).addClass('active').text('已显示章节');

            if(course_id){
                $('.sectionGroup').removeClass('layui-hide');
            }

            table.render({
                elem: '#sectionList',
                id: 'sectionList',
                height: 500,
                method: 'post', //接口http请求类型，默认：get
                url: '{{ route("admin.index.getSectionList") }}',
                where: {
                    course_id: course_id,
                    _token: '{{csrf_token()}}'
                }
                ,response: {
                    statusName: 'errcode', //规定数据状态的字段名称，默认：code
                    statusCode: 0, //规定成功的状态码，默认：0
                    msgName: 'errmsg', //规定状态信息的字段名称，默认：msg
                    countName: 'total', //规定数据总数的字段名称，默认：count
                    dataName: 'data', //规定数据列表的字段名称，默认：data
                }
                // ,page:true
                ,cols: [
                    [ {
                        type:'radio',
                        field:'id',
                    },{
                        field: 'id', //字段名
                        title: '章节ID', //标题
                        width: 150,
                    },{
                        field: 'name', //字段名
                        title: '章节标题', //标题
                        width: 350,
                    },{
                        field: 'price', //字段名
                        title: '价格', //标题
                        width: 130,
                    },{
                        field: 'is_try', //字段名
                        title: '是否免费', //标题
                        width: 100,
                        templet: function(d) {
                            if (d.is_try == 1) {
                                return '是'
                            }  else if(d.is_try == 2){
                                return '否'
                            }
                        }
                    }, {
                        field: 'created_at', //字段名
                        title: '创建日期', //标题
                        width: 232,
                    }]
                ]
            });
        });


        $(document).on('click','.selectUser',function(e){


            $('#user_account').val($(this).data('account'));
            $('#user_id').val($(this).data('user_id'));
            layer.close(layer.index);
        });

        //动态获取用户列表数据 table
        function getAreaUserList() {
            var is_vip = $('input[name=isvip]:checked').val();
            var province = $('#province option:selected').val();
            var city = $('#city option:selected').val();
            var keyword = $('#userlist_keyword').val();
            table.render({
                elem: '#openUserListable',
                id: 'openUserListable',
                height: 480,
                method: 'post', //接口http请求类型，默认：get
                url: '{{ route("admin.index.getAreaUserList") }}',
                where: {
                    is_vip: is_vip,
                    province: province,
                    city: city,
                    keyword: keyword,
                    _token: '{{csrf_token()}}'
                }
                ,response: {
                    statusName: 'errcode', //规定数据状态的字段名称，默认：code
                    statusCode: 0, //规定成功的状态码，默认：0
                    msgName: 'errmsg', //规定状态信息的字段名称，默认：msg
                    countName: 'total', //规定数据总数的字段名称，默认：count
                    dataName: 'data', //规定数据列表的字段名称，默认：data
                }
                ,page:true
                ,cols: [
                    [{
                        field: 'id', //字段名
                        title: 'ID', //标题
                        width: 120,
                        //fixed: 'left' //固定列
                    }, {
                        field: 'account', //字段名
                        title: '账号', //标题
                        width: 200,
                        //fixed: 'left' //固定列
                    }, {
                        field: 'nickname', //字段名
                        title: '昵称', //标题
                        width: 200,
                        //fixed: 'left' //固定列
                    }, {
                        field: 'mobile_area', //字段名
                        title: '地区', //标题
                        width: 200,
                        //fixed: 'left' //固定列
                    }, {
                        field: 'vip_status', //字段名
                        title: '会员类型', //标题
                        width: 120,
                        templet: function(d) {
                            if (d.vip_status == 1) {
                                return 'VIP会员'
                            } else {
                                return '普通会员'
                            }
                        }
                        //fixed: 'left' //固定列
                    }, {
                        field: 'created_at', //字段名
                        title: '生成日期', //标题
                        width: 200,
                        //fixed: 'left' //固定列
                    }, {
                        // field: 'id', //字段名
                        title: '操作', //标题
                        width: 80,
                        templet: function(d) {
                            return '<button class="layui-btn layui-btn-sm selectUser" data-user_id="'+d.id+'" data-account="'+d.account+'" >选取</button>'
                        },
                        // sort: true //是否允许排序 默认：false
                        //fixed: 'left' //固定列
                    }]
                ]
            });

        }

    });


    

</script>
</body>
</html>