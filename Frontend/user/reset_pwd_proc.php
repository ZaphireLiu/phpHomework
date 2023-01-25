<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
require_once '../load_resources.php';
preLoad(1, true);
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>重置密码</title>
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
            user-select: none;
        }

        .titleText {
            text-align: center;
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
            user-select: none;
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
</head>

<body class="single2">

    <?php 
        /*
        proc返回到reset的错误值：
        值|描述
        --|--
        0 |用户名/密码为空 or 其他情况
        1 |用户名/密码错误
        2 |用户不存在
        */
        require_once '../../Comm/function.php';
        define('DEBUG', false);
        $link = link_SQL();
        if (!isset($_COOKIE['userID']) || !isset($_COOKIE['username']))
            // Cookie正好过期
            jumpToURL('login.php');
        @$id = $_COOKIE['userID'];
        @$name = $_COOKIE['username'];
        if (!isset($_GET['flag']) || @$_GET['flag'] != 1)
        {   // 正常重置，检查原密码
            @$pwdOri = $_POST['passwordOri'];
            $pwdValid = md5($name.'salt'.$pwdOri);
            $query = "SELECT * FROM `user_account` WHERE `id`={$id}";
            $res = getRet_SQL(mysqli_query($link, $query));
            if ($pwdValid != $res['pwd_md5'] && !DEBUG)
                jumpToURL('reset_pwd.php', array('flag' => 2));
        }
        if ($_POST['password'] != $_POST['passwordValid'])
        {   // 输入密码两次不一致
            jumpToURL('reset_pwd.php', array('flag' => 3));
            die();
        }
        $new_MD5 = md5($name.'salt'.$_POST['password']);
        $query = "UPDATE user_account SET pwd_rst=0, pwd_md5='{$new_MD5}' WHERE id={$id}";
        $rs = mysqli_query($link, $query);
        $msg = '';
        if ($rs)
        {
            $msg = '重置密码成功！<br/>即将跳转登录页面';
            if (!DEBUG)
                jumpToURL('login.php', array(), 2);
        }
        else
        {   // 数据库插入数据失败
            $msg = '<span style="color: red">操作失败，请重试或联系管理员<br/>正在返回...</span>';
            if (!DEBUG) 
                jumpToURL('reset_pwd.php', array(), 2);
        }
        load_header()
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
                        &nbsp;&nbsp;&nbsp;&nbsp;重置账号密码&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <span class="titleLine"></span>
                    <span class="titleText" style="width: 700px;">
                    <br/><br/><?= $msg ?>
                </span>
                </div>
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