<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    require_once '../load_resources.php';
    preLoad(1, true);
    if (isset($_GET['retVal']) || @$_GET['retVal'])
        // 其实能拿到具体为啥错误，但是为了账号安全考虑就只有一条提示信息
        $errMsg = '用户名或密码错误！';
    else
        $errMsg = '';
    if (isset($_GET['from']))
        $formTarget = "login_proc.php?from={$_GET['from']}";
    else
        $formTarget = 'login_proc.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>登录</title>
    <?php load_cssFile() ?>
    <link rel="stylesheet" type="text/css" href="login-asset/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="login-asset/css/util.css">
    <link rel="stylesheet" type="text/css" href="login-asset/css/main.css">
    <style type="text/css">
        html,
        body {
            position: relative;
            height: auto;
            min-height: 100%;
            background-color: #222;
        }
        #wrapper {
            padding: 100px;
        }
        #loginWindow {
            align-items: center;
            border-radius: 10px;
            overflow: hidden;
            width: auto;
            height: auto;
            background-color: #fff;
        }
        .title {
            width: 700px;
            line-height: 30px;
            text-align: center;
            padding-top: 40px;
            user-select:none;
        }
        .titleText {
            padding-top: 40px;
            padding-bottom: 20px;
            color: #353535;
            font-size: 24px;
        }
        .titleLine {
            display: inline-block;
            width: 200px;
            border-top: 2px solid #cccccc;
            vertical-align: 5px;
        }
        .errMsg {
            text-align: center;
            color: #D30300;
            font-size: medium;
            user-select:none;
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
</head>

<body class="single2">

    <?php load_header()
    // 页首栏 
    ?>

    <div id="wrapper" style="align-items: center;">
        <!-- 页面内容 -->
        <div class="wrap-login100" style="margin: auto; width: 700px; align-items:center; background-color: #222">
            <!-- <div class="login100-form-title" style="background-image: url(login-asset/image/bg-01.jpg);">
                <span class="login100-form-title-1">登 录</span>
            </div> -->
            <div id="loginWindow">
                <div class="title">
                    <span class="titleLine"></span>
                    <span class="titleText">
                        &nbsp;&nbsp;&nbsp;&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <span class="titleLine"></span>
                </div>
                <p class="errMsg">
                    &nbsp;<?=$errMsg?>&nbsp;</p><!-- 加俩空格占位就不用display和visibility了 -->
                <form class="login100-form validate-form" style="width: 700px" action="<?= $formTarget ?>" method="post">
                    <!-- 输入 -->
                    <div class="wrap-input100 validate-input m-b-26" data-validate="用户名不能为空">
                        <span class="label-input100" style="user-select:none;">账号</span>
                        <input class="input100" type="text" name="username" placeholder="请输入用户名/手机号/邮箱">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-18" data-validate="密码不能为空">
                        <span class="label-input100" style="user-select:none;">密码</span>
                        <input class="input100" type="password" name="password" placeholder="请输入密码">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="flex-sb-m w-full p-b-30">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                            <label class="label-checkbox100" for="ckb1">记住我</label>
                        </div>
                        <div>
                            <a href="login_forgetPwd.php" class="txt1">忘记密码？</a>
                        </div>
                    </div>
                    <!-- 按钮 -->
                    <div class="container-login100-form-btn" style="margin: auto">
                        <input class="login100-form-btn" type="submit" name="btn_login" value="登   录" style="margin: auto">
                        <a href="signup.php">
                            <input class="login100-form-btn" type="button" name="btn_signup" value="注   册" style="margin: auto">
                        </a>
                    </div>
                </form>
                <div style="padding: 20px 45px 45px 45px; text-align: center">
                </div>
            </div>

        </div>
        <!-- /页面内容 -->
    </div>

    <?php load_footer(1)
    // 页尾栏 
    ?>

    <script src="login-asset/js/jquery-3.2.1.min.js"></script>
    <script src="login-asset/js/main.js"></script>

</body>

</html>