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
            
                <div class="test-table-reload-btn" style="margin-bottom: 10px;float:left">
                    <button class="layui-btn addMember">添加会员</button>
                </div>
                <div class="test-table-reload-btn" style="margin-bottom: 10px;float:right">
                    会员账号：
                    <div class="layui-inline">
                        <input class="layui-input" name="keyWord" autocomplete="off" >
                    </div>
                    <button class="layui-btn reloadBtn">搜索</button>
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


    <div id="resetPasswordBox" style="display: none; padding: 10px;">
        <div class="layui-form"  style="padding: 20px 0 0 0;">
            <input type="hidden" name="member_id" >
            <div class="layui-form-item">
                <label class="layui-form-label">账号:</label>
                <div class="layui-input-inline">
                    <div class="layui-form-mid" id="resetMemberAccount"></div>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">重置密码:</label>
                <div class="layui-input-inline">
                    <input type="text" name="resetPassword" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-layer-btn layui-layer-btn-">
                <a class="layui-layer-btn0">确定</a>
                <a class="layui-layer-btn1">取消</a>
            </div>
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
    </div>
</div>
<script type="text/html" id="tableBarButton">
  <a class="layui-btn layui-btn-xs" lay-event="resetPassword">重置密码</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>

 
<script src="{{ config('view.admin_assets') }}/layui/layui.js"></script>
<script>
    //JavaScript代码区域
    layui.use(['element', 'table'], function(){
        var element = layui.element;
        var table = layui.table;
        var $ = layui.$;
        var form = layui.form;

        table.render({
            elem: '#demo',
            url: '{{ route("admin.index.index")  }}',
            page: true,
            parseData: function(res){ //res 即为原始返回的数据
                return {
                "code": res.errcode, //解析接口状态
                "msg": res.msg, //解析提示文本
                "count": res.total, //解析数据长度
                "data": res.data //解析数据列表
                };
            },
            cols: [[
                {field: 'id', title: 'ID', width:80,  fixed: 'left'},
                {field: 'account', title: '用户账号'},
                {field: 'created_at', title: '创建时间'},
                {field: '', title: '状态',templet:function (d) {
                        if (d.status == 1) {
                            return '启用';
                        } else {
                            return '禁用';
                        }
                    }
                },
                {field:'status', title:'状态', unresize: true, templet: function(d){
                
                    if(d.status == 1){
                        return '<input type="checkbox" name="status" value="'+d.id+'" lay-skin="switch" lay-text="启用|禁用" lay-filter="tableStatus" checked >';
                    }else{
                        return '<input type="checkbox" name="status" value="'+d.id+'" lay-skin="switch" lay-text="启用|禁用" lay-filter="tableStatus" >';
                    }
                }},
                {fixed: 'right',title: '操作', align:'center', toolbar: '#tableBarButton'} 
            ]],
        });


        table.on('tool(memberList)', function(obj){

            var data = obj.data;
            if(obj.event == 'resetPassword'){

                $('input[name=member_id]').val(data.id);
                $('#resetMemberAccount').text(data.account);
                layer.open({
                    type: 1,
                    title: '重置密码',
                    area: ['430px','250px'], //宽高
                    content: $('#resetPasswordBox'),
                    end: function () {
                        //    - 层销毁后触发的回调
                        // $('#userlist_keyword').val('');
                        $('input[name=member_id],input[name=resetPassword]').val('');
                    },
                    yes: function(index) {
                    
                        var member_id = $('input[name=member_id]').val();
                        var password = $('input[name=resetPassword]').val();
                        if(!member_id){
                                layer.msg('出现错误，请刷新页面', {icon: 2});
                                return false;
                        }
                        if(!password){
                                layer.msg('请填写密码', {icon: 2});
                                return false;
                        }
                        $.ajax({
                                url: '{{ route("admin.index.resetMemberPassword") }}',
                                type: 'POST',
                                dataType: 'json',
                                data: {_token: '{{csrf_token()}}','member_id':member_id,'password':password},
                            })
                            .done(function(res) {
                                if (res.errcode == 0) {
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
                    
            }else if(obj.event == 'delete'){

                layer.confirm('是否确认删除该账号？', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        url: '{{ route("admin.index.deleteMember") }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {_token: '{{csrf_token()}}','member_id':data.id},
                    })
                    .done(function(res) {
                        if (res.errcode == 0) {
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

        //监听状态操作
        form.on('switch(tableStatus)', function(obj){

            $.ajax({
                url: '{{ route("admin.index.changeMemberStatus") }}',
                type: 'POST',
                dataType: 'json',
                data: {_token: '{{csrf_token()}}','member_id':this.value},
            })
            .done(function(res) {
                if (res.errcode == 0) {
                    layer.msg(res.msg, {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 2});
                }
            })
            .fail(function() {
                layer.msg('网络繁忙', {icon: 2});
            });
        });
        
        $('.addMember').on('click', function() {



            
            layer.open({
                type: 1,
                title: '添加会员',
                area: ['430px','250px'], //宽高
                content: $('#openMemberBox'),
                end: function () {
                    //    - 层销毁后触发的回调
                    // $('#userlist_keyword').val('');
                    $('input[name=account],input[name=password]').val('');
                    
                },
                yes: function(index) {
                   
                   var account = $('input[name=account]').val();
                   var password = $('input[name=password]').val();
                   var acc = layer.msg('会员数据生成中...', {icon: 16, shade: 0.3, time: 0});
                   if(!account && !password){
                        layer.msg('请填写账号和密码', {icon: 2});
                        return false;
                   }
                    $.ajax({
                            url: '{{ route("admin.index.addMember") }}',
                            type: 'POST',
                            dataType: 'json',
                            data: {_token: '{{csrf_token()}}','account':account,'password':password},
                        })
                        .done(function(res) {
                            layer.close(acc);
                            if (res.errcode == 0) {
                                layer.msg(res.msg, {icon: 1});
                                layer.close(index);
                                tableReload();
                            } else {
                                layer.msg(res.msg, {icon: 2});
                                return false;
                            }
                        })
                        .fail(function() {
                            layer.close(acc);
                            layer.msg('网络繁忙', {icon: 2});
                        });
                }
            });

        });

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