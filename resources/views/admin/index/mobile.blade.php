<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <title>管理后台</title>
    <link rel="stylesheet" href="{{ config('view.admin_assets') }}/layui/css/layui.css">
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
                    <label class="layui-form-label">导入Excel</label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" id="upload_file">
                            <i class="layui-icon">&#xe67c;</i>上传Excel
                        </button>
                    </div>
                </div>

                
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        <button class="layui-btn" lay-submit lay-filter="formDemo">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
    </div>
</div>

<script id="demo" type="text/html">
    
</script>
<script src="{{ config('view.admin_assets') }}/layui/layui.js"></script>
<script>
    layui.config({
        base: '{{ config('view.admin_assets') }}/layui/lay/modules/'//拓展模块的根目录
    }).extend({
        pca: 'pca'
    });

    layui.use(['element', 'form','laydate', 'layedit','upload', "jquery", "pca"], function(){
        var element = layui.element;
        var form = layui.form;
        var $ = layui.$;
        var laydate = layui.laydate;
        var pca = layui.pca;
        var upload = layui.upload;
        //带初始值进行初始化
        pca.init('select[name=P1]', 'select[name=C1]');
        laydate.render({
            elem: '#test1', //指定元素
            type: 'datetime',
            max: 0
        });

        //执行实例
        var uploadInst = upload.render({
            elem: '#upload_file', //绑定元素
            auto:false,
            accept:'file'
            // data: {
            //     _token: '{{csrf_token()}}'
            // }
            // ,url: '{{ route("admin.index.mobile") }}' //上传接口
            // ,done: function(res){
            // //上传完毕回调

            //     console.log(res);
            // }
            // ,error: function(){
            // //请求异常回调
            // }
        });
        var agent_type = 1;
        form.verify({
            user_mobile: function(val) {
                if (!val) {
                    return '请生成手机号码';
                }
            },
            agent_id: function(val) {
                if (agent_type == 2 && !val) {
                    return '请选择代理商';
                }
            }
        });
        /**
         * 用户手机号码生成
         */
        $('.create-mobile').on('click', function() {
            var ele = $(this).data('ele');
            var mobile = createMobile();
            $('input[name="'+ele+'"]').val(mobile);
        });
        $('.create-mobile2').on('click', function() {
            var ele = $(this).data('ele');
            var mobile = createMobile2();
            $('input[name="'+ele+'"]').val(mobile);
        });

        /**
         * 切换平台或代理商
         */
        form.on('radio(agent_type)', function(data) {
            agent_type = data.value;
            if (agent_type == 1) {
                // 平台
                $('.agent-group,.users-group').removeClass('layui-show').addClass('layui-hide');
            } else if (agent_type == 2) {
                // 代理商
                $('.users-group').addClass('layui-hide');
                $('.agent-group').removeClass('layui-hide').addClass('layui-show');
            } else {
                // 用户
                $('.agent-group').addClass('layui-hide');
                $('.users-group').removeClass('layui-hide').addClass('layui-show');
            }
        });
        // 会员类型
        form.on('radio(isvip)', function(data) {
            if (data.value == 1) {
                // vip
                $('.vip-group').removeClass('layui-hide').addClass('layui-show');
                $('[name="agent_type"][value="3"]').prop('disabled', true);
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
        $('.seach-users').on('click', function() {
            var keywords = $('input[name="keywords2"]').val();
            if (!keywords) {
                layer.msg('请输入关键字', {icon: 2});
                return false;
            }
            var i = layer.msg('数据查找中...', {icon: 16, shade: 0.3, time: 0});
            $.ajax({
                url: '{{ route("admin.index.getUserList") }}',
                type: 'POST',
                dataType: 'json',
                data: {keywords: keywords, _token: '{{csrf_token()}}'},
            })
                .done(function(res) {
                    layer.close(i);
                    layer.msg(res.errmsg, {icon: 1});

                    var htmls = '<option value="">请选择用户</option>';
                    $.each(res.data, function(index, val) {
                        htmls += '<option value="'+val.id+'">姓名：'+val.nickname+' | 手机：'+val.account+'</option>';
                    });
                    $('select[name="users_id"]').empty().append(htmls);

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




            var myfile=$("input[name='file']")[0].files[0]
            var formdata=new FormData()
            formdata.append('myfile',myfile)
            formdata.append('_token','{{csrf_token()}}')
            formdata.append('province_val',$("#province_val input[type='text']").val())
            formdata.append('city_val',$("#city_val input[type='text']").val())

            var i = layer.msg('号码导入中...', {icon: 16, shade: 0.3, time: 0});
            $.ajax({
                url: '{{ route("admin.index.mobile") }}',
                type: 'POST',
                // dataType: 'json',
                processData:false,
                contentType:false,
                data:formdata,
            })
            .done(function(res) {
                var res = $.parseJSON(res);
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


        function getVirtualMobile() {
            var i = layer.msg('手机号码分配中...', {icon: 16, shade: 0.3, time: 0});
            var mobile = '';
            $.ajax({
                url: '{{ route("admin.virtual.getMobile") }}',
                type: 'POST',
                dataType: 'json',
                data: {_token: '{{csrf_token()}}'},
                async: false
            })
                .done(function(res) {
                    layer.close(i);
                    if (res.errcode == 0) {
                        mobile = res.mobile;
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
            return mobile;
        }

        /**
         * 生成手机号码
         * @return {[type]} [description]
         */
        function createMobile()
        {
            // var quhao = [130,131,132,133,134,135,136,137,138,139,180,181,182,183,185,186,187,188,189];
            // var mobile = quhao[Math.floor(Math.random()*quhao.length)].toString();
            // for (var i = 10; i > 2; i--) {
            //     mobile += Math.floor(Math.random()*9).toString();
            // }
            // return mobile;

            var mobile = getVirtualMobile();
            return mobile;
        }
        /**
         * 生成手机号码
         * @return {[type]} [description]
         */
        function createMobile2()
        {
            var quhao = [130,131,132,133,134,135,136,137,138,139,180,181,182,183,185,186,187,188,189];
            var mobile = quhao[Math.floor(Math.random()*quhao.length)].toString();
            for (var i = 10; i > 2; i--) {
                mobile += Math.floor(Math.random()*9).toString();
            }
            return mobile;
        }
    });


    

</script>
</body>
</html>