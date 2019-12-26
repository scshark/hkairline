<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
                        <dd><a href="{{ route('admin.index.index')  }}">会员列表</a></dd>
                        {{--<dd><a href="{{ route('admin.index.orderlist')  }}">订单列表</a></dd>--}}
                    </dl>
                </li>
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <table id="demo" lay-filter="test"></table>
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
    </div>
</div>
<script src="{{ config('view.admin_assets') }}/layui/layui.js"></script>
<script>
    //JavaScript代码区域
    layui.use(['element', 'table'], function(){
        var element = layui.element;
        var table = layui.table;

        table.render({
            elem: '#demo',
            url: '{{ route("admin.index.orderlist")  }}',
            page: true,
            cols: [[
                {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'},
                {field: 'nickname', title: '用户昵称'},
                // {field: 'created_at', title: '入驻时间'},
                {field: 'account', title: '手机号码'},
                // {field: '', title: '身份', templet: function (d) {
                //         if (d.vip_status == 1) {
                //             return 'VIP';
                //         } else {
                //             return '普通';
                //         }
                //     }},
                {field: '', title: '上级用户'},
                {field: '', title: '上级手机'},
                {field: '', title: '上级收益'},
                {field: '', title: '代理商'},
                {field: '', title: '代理手机'},
                {field: '', title: '代理收益'},
                // {field: 'user_type', title: '会员身份', templet: function (d) {
                //         var $user_type = {
                //             1: '学员',
                //             2: '老师',
                //             3: '代理商',
                //             4: '机构'
                //         };
                //         return $user_type[d.user_type];
                //     }},
                // {field: '', title: 'VIP有效期', templet: function (d) {
                //     if (d.vip_status == 1) {
                //         return d.viplog.vip_start_time_day + " - " + d.viplog.vip_end_time_day;
                //     } else {
                //         return '';
                //     }
                //     }},
                // {field: 'status', title: '状态', templet: function (d) {
                //         var $status = {
                //             1: '启用',
                //             2: '禁用'
                //         };
                //         return $status[d.status];
                //     }},
                // {field: 'account', title: '余额', templet: function (d) {
                //         return parseInt(d.balance) + parseInt(d.ios_recharge);
                //     }},
            ]],
        });
    });
</script>
</body>
</html>