<!DOCTYPE HTML>
<html lang="zxx">

<head>
    <title>Login</title>
    <!-- Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta-Tags -->
    <!-- Stylesheets -->
    <link href="{{ config('view.admin_assets') }}/css/style.css" rel='stylesheet' type='text/css' />
    <!--// Stylesheets -->
    <!--online fonts-->
    <!--<link href="http://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">-->
    <!--//online fonts-->
</head>

<body>
<h1>Admin Login Form</h1>
<div class="w3ls-login box">
{{--    <img src="{{ config('view.admin_assets') }}/images/logo.png" alt="logo_img" />--}}
    <!-- form starts here -->
    <form action="#" method="post" class="layui-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="agile-field-txt">
            <input type="text" name="account" placeholder="Your account" required="" lay-verify="account"/>
        </div>
        <div class="agile-field-txt">
            <input type="password" name="password" placeholder="password" required="" id="myInput" lay-verify="password"/>
        </div>
        <div class="w3ls-bot">
            <input type="submit" value="LOGIN" lay-submit lay-filter="submit">
        </div>
    </form>
</div>
<!-- //form ends here -->
<!--copyright-->

<!--//copyright-->
<script src="{{ config('view.admin_assets') }}/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="{{ config('view.admin_assets') }}/layui/layui.js"></script>
<script type="text/javascript">

    layui.use('form', function(){
        var form = layui.form;

        form.verify({
            account: function(val) {
                if (!val) {
                    return '请输入账号';
                }
            },
            password: function(val) {
                if (!val) {
                    return '请输入密码';
                }
            }
        });

        form.on('submit(submit)', function(data){
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            var i = layer.msg('登录中...', {icon: 16, time: 0, shade: 0.3});

            $.ajax({
                url: '{{ url("/admin/login") }}',
                type: 'POST',
                dataType: 'json',
                data: data.field,
            })
            .done(function(res) {
                layer.close(i);
                if (res.errcode == 0) {
                    layer.msg(res.errmsg, {icon: 1}, function(){
                        window.location.href = res.url;
                    });
                } else {
                    layer.msg(res.errmsg, {icon: 2});
                }
            })
            .fail(function() {
                layer.close(i);
                layer.msg('网络繁忙', {icn: 2});
            })
            .always(function() {
                console.log("complete");
            });
            
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    });
</script>
</body>

</html>