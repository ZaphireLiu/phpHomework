<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once '../load_resources.php';
preLoad(1, true);

$errMsg = '';
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>忘记密码</title>
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
        .input-select {
            height: 45px;
            width: 100%;
        }
        .input-option{
            font-size: 16px;
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
                        &nbsp;&nbsp;&nbsp;&nbsp;重&nbsp;置&nbsp;密&nbsp;码&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <span class="titleLine"></span>
                </div>
                <p class="errMsg">
                    &nbsp;<?=$errMsg?>&nbsp;</p><!-- 加俩空格占位就不用display和visibility了 -->
                <form class="login100-form validate-form" style="width: 700px" action="forget_proc.php" method="post">
                    <!-- 输入 -->
                    <div class="wrap-input100 validate-input m-b-26" data-validate="用户名不能为空">
                        <span class="label-input100" style="user-select:none;">用户名</span>
                        <input class="input100" type="text" name="username" placeholder="请输入用户名">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 m-b-26">
                        <span class="label-input100" style="user-select:none;">验证方式</span>
                        <select class="input-select" name="sel">
                            <option class="input-option" value="phone">手机号</option>
                            <option class="input-option" value="email">邮箱地址</option>
                        </select>
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-26" data-validate="信息不能为空">
                        <span class="label-input100" style="user-select:none;">验证信息</span>
                        <input class="input100" type="text" name="valid" placeholder="请输入手机号/邮箱">
                        <span class="focus-input100"></span>
                    </div>
                    <!-- 按钮 -->
                    <div class="container-login100-form-btn" style="margin: auto">
                        <input class="login100-form-btn" type="submit" name="btn" value="验   证" style="margin: auto">
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