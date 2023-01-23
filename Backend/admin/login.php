<!DOCTYPE html>
<?php
    @session_start();
    $logErrFlag = 0; // 登录错误标识符
    $sessionDataAdmin = array(
        "idAdm", "loginStatAdm"
    ); // 管理员相关的状态信息
    if (!isset($_SESSION['loginStatAdm']))
        //初次进入，初始化为未登录状态
        $_SESSION['loginStatAdm'] = 0;
    if ($_SESSION['loginStatAdm'] == 1)
    {   // 已登录-重置登录信息
        unset($_SESSION['idAdm']);
        $_SESSION['loginStatAdm'] = 0;
    }
    elseif ($_SESSION['loginStatAdm'] == -1)
    {
        // 登录错误
        $_SESSION['loginStatAdm'] = 0; // 重置提示
        $logErrFlag = 1;
    }
?>
<html xmlns="http://www.w3.org/1999/xhtml"><!--Head--><head>
    <meta charset="utf-8">
    <title>管理系统登录界面</title>
    <meta name="description" content="login page">
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
<!--Head Ends-->
<!--Body-->

<body>
    <div class="login-container animated fadeInDown">
        <form action="login_proc.php" method="POST">
            <div class="loginbox bg-white">
                <div class="loginbox-title">管理员登录</div>
                <div class="loginbox-textbox">
                    <input class="form-control" name="username" placeholder="用户名/手机号/邮箱" type="text"
                    <?= isset($_SESSION['loginInput_name']) ? 'value="'.$_SESSION['loginInput_name'].'"' : '' ?>>
                </div>
                <div class="loginbox-textbox">
                    <input class="form-control" name="password" placeholder="密码" type="password">
                </div>
                <div class="loginbox-submit">
                    <input class="btn btn-primary btn-block" name="loginBtn" value="登 录" type="submit">
                </div>
            </div>
        </form>
        <?php if ($logErrFlag): ?>
        <div class="logobox">
            <p class="text-center" style="font-family:'Microsoft YaHei'; color:#df2b30;">
                用户名或密码错误<br/><a href="forget_pwd.php">忘记密码？</a></p>
        </div>
        <?php endif; ?>
    </div>
    <!--Basic Scripts-->
    <script src="../style/jquery.js"></script>
    <script src="../style/bootstrap.js"></script>
    <script src="../style/jquery_002.js"></script>
    <!--Beyond Scripts-->
    <script src="../style/beyond.js"></script>

</body>
</html>