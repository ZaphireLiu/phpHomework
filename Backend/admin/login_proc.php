<!DOCTYPE html>
<!--
    To do:
    - 重置密码处理（目前为了测试暂时先直接放进去）
-->
<?php @session_start(); ?>
<html>
<head>
    <meta charset="UTF-8">
    <title>正在登录...</title>
    <meta name="description" content="login check page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Basic Styles-->
    <link href="../style/bootstrap.css" rel="stylesheet">
    <link href="../style/font-awesome.css" rel="stylesheet">
    <!--Beyond styles-->
    <link id="beyond-link" href="../style/beyond.css" rel="stylesheet">
    <link href="../style/demo.css" rel="stylesheet">
    <link href="../style/animate.css" rel="stylesheet">
</head>
<body>
    <div class="login-container animated fadeInDown">
    <div class="loginbox bg-white">
        <?php
            require_once '../../Comm/function.php';
            /**
             * 返回登录页面，并直接停止本页面的程序运行
             * @param int       $retCode 存入Session的返回值，决定是否提示错误信息
             * @param string    $tip 提示的返回信息
             * @return never
             */
            function ret2login($retCode, $tip = '返回登录页面', $name = '')
            {
                $_SESSION['loginStatAdm'] = $retCode;
                if ($name)
                    $_SESSION['loginInput_name'] = $name;
                die(<<<str
                    <div class="loginbox-title">
                        {$tip}
                    </div>
                    <script>
                        setTimeout("javascript:location.href='login.php'", 2000);
                    </script>
                str);
            }
            if (!isset($_POST['loginBtn'])) // 未按下登录按钮，非正常情况
                ret2login(0, '登录操作错误，返回登录页面');
            $link = @mysqli_connect('localhost', 'root', '', 'mgt_sys') or die(<<<str
                <div class="loginbox-title">
                    无法连接数据库
                </div>
            str);
            @$name = $_POST['username'];
            @$pwd = $_POST['password'];
            $pwdValid = md5($name.'salt'.$pwd);
            $pwdValidReset = md5($name.'salt');
            if (strlen($name) == 0)
                ret2login(-1, '输入错误，返回登录页面');
            $query = <<<str
                SELECT * FROM `admin_account` WHERE
                    `name`  = '{$name}'
                or  `phone` = '{$name}'
                or  `email` = '{$name}'
            str;
            $result = mysqli_query($link, $query);
            if ($result -> num_rows > 0)
            {
                $admAcc = validAcc($result, $name);
                if ($pwdValid == $admAcc['pwd_md5'])
                {
                    $_SESSION['idAdm'] = $admAcc['id'];
                    $_SESSION['nameAdm'] = $admAcc['name'];
                    $_SESSION['perAdm'] = $admAcc['permission'];
                    $_SESSION['loginStatAdm'] = 1;
                    $query = "UPDATE `admin_account` SET `last_login_time`=NOW() WHERE `id`={$admAcc['id']}";
                    @mysqli_query($link, $query);
                    echo <<<str
                        <div class="loginbox-title">
                            欢迎您，{$admAcc['name']}！<br/>正在跳转到管理主页
                        </div><br/>
                        <script>
                            setTimeout("javascript:location.href='../index.php'", 2000);
                        </script>
                    str;
                }
                elseif ($admAcc['pwd_rst'] || !$admAcc['pwd_md5'])
                {   // 密码为空，指引到重置密码的界面
                    $query = "UPDATE `admin_account` SET `pwd_rst`=1 WHERE `id`={$admAcc['id']}";
                    @mysqli_query($link, $query);
                    $_SESSION['idAdm'] = $admAcc['id'];
                    $_SESSION['nameAdm'] = $admAcc['name'];
                    $_SESSION['perAdm'] = $admAcc['permission'];
                    $_SESSION['loginStatAdm'] = 1;
                    echo <<<str
                        <div class="loginbox-title">
                            密码未设置！跳转到设置页面
                        </div><br/>
                        <script>
                            setTimeout("javascript:location.href='pwd_set.php'", 2000);
                        </script>
                    str;
                }
                else ret2login(-1, '用户名或密码错误', $name); // 密码错误
            }
            else ret2login(-1, '用户不存在'); // 找不到用户
            mysqli_close($link);
        ?>
    </div></div>
</body>
</html>