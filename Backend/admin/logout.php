<!DOCTYPE html>
<?php @session_start() ?>
<html>
<head>
    <meta charset="UTF-8">
    <title>退出登录</title>
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
            if (isset($_SESSION['nameAdm']))
                $name = $_SESSION['nameAdm'];
            else
                $name = '管理员';
            $seProcArr = array('idAdm', 'nameAdm', 'perAdm');
            foreach ($seProcArr as $v)
                unset($_SESSION[$v]); // 清空登录相关信息
            $_SESSION['loginStatAdm'] = 0;
        ?>
        <div class="loginbox-title">
            <span style="color:dodgerblue"><?=$name?></span>&nbsp;已退出登录
        </div><br/>
        <div class="loginbox-submit">
            <a href="login.php">
                <input class="btn btn-primary btn-block" type="button" value="重新登录">
            </a>
        </div>
        <div class="loginbox-submit" style="display:none">
            <input class="btn btn-primary btn-block" type="button" value="备用">
        </div>
    </div></div>
</body>
</html>