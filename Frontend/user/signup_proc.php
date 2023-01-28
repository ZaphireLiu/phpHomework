<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
require_once '../load_resources.php';
preLoad(1, true);
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>注册</title>
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
        /**
         * 检查某项是否已被占用
         * @param mysqli $link 与数据库的连接
         * @param string $name 字段名
         * @param string $val  字段值
         */
        function isUsed($link, $table, $name, $val)
        {
            $query = "SELECT * FROM {$table} WHERE `{$name}`='{$val}'";
            $result = mysqli_query($link, $query);
            if ($result -> num_rows == 0)
                return false;
            else
                return true;
        }
        if (isset($_GET['from']))
            $from = $_GET['from'];
        else
            $from = '';
        $link = link_SQL();
        $checkUsed = array(
            'name'  => 1, 
            'phone' => 2, 
            'email' => 3 );
        foreach ($checkUsed as $k => $v)
        {
            if (!isset($_POST[$k]))
                continue;
            if (isUsed($link, 'user_account', $k, $_POST[$k]))
            {   // 某一项已被占用
                jumpToURL('signup.php', array('retVal' => $v, 'from' => $from));
            }
        }
        foreach ($checkUsed as $k => $v)
        {
            if (isUsed($link, 'user_account', $k, $_POST['name']))
            {   // 某一项已被占用
                jumpToURL('signup.php', array('retVal' => (10+$v), 'from' => $from));
            }
        }
        if ($_POST['name'] == '已注销账号')
            jumpToURL('signup.php', array('retVal' => 5, 'from' => $from));
        if ($_POST['password'] != $_POST['passwordValid']) 
            // 两次输入密码不匹配
            jumpToURL('signup.php', array('retVal' => 4, 'from' => $from));
        $id = genID($link, 'user_account');
        $pwd_md5 = md5($_POST['username'].'salt'.$_POST['password']);
        $insertList = array(
            $id,
            $_POST['username'],
            $_POST['phone'] ?? '',
            $_POST['email'] ?? '',
            $pwd_md5,
            0
        );
        $query = <<<str
            INSERT INTO `user_account`(id, name, phone, email, pwd_md5, pwd_rst)
            VALUES('{$insertList[0]}', '{$insertList[1]}', '{$insertList[2]}', '{$insertList[3]}', '{$insertList[4]}', '{$insertList[5]}');
        str;
        $res = mysqli_query($link, $query);
        mysqli_close($link);
        if ($res)
        {
            $signupMsg = '注册成功！跳转到登录页面。。。';
            jumpToURL('login.php', array('from' => $from), 2);
        }
        else
        {   // 数据库插入数据失败
            $signupMsg = '注册失败，请重试或联系管理员<br/>即将返回注册页面';
            jumpToURL('signup.php', array('from' => $from), 2);
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
                        &nbsp;&nbsp;&nbsp;&nbsp;注册新账号&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <span class="titleLine"></span>
                    <span class="titleText" style="width: 700px;">
                    <br/><br/><?= $signupMsg ?>
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