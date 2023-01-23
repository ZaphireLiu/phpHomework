<!DOCTYPE html>
<?php
    @session_start();
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
    <span style="color:#eeeeee">
    <?php
        foreach ($_SESSION as $k => $v)
            echo $k.':'.$v.'<br/>';
    ?>
    </span>
    <div class="login-container animated fadeInDown">
        <form action="pwd_edit_proc.php?from=pwd_set.php&to=login.php" method="POST">
            <div class="loginbox bg-white">
                <div class="loginbox-title">&nbsp;重置密码&nbsp;</div>
                <div class="loginbox-textbox">
                <input name="id" type="text" value="<?=$_SESSION['idAdm']?>" style="display: none">
                <div class="loginbox-textbox">
                    <input class="form-control" name="pwd" placeholder="密码" type="password">
                </div>
                <div class="loginbox-textbox">
                    <input class="form-control" name="pwd_valid" placeholder="再次输入密码" type="password">
                </div>
                <div class="loginbox-submit">
                    <input class="btn btn-primary btn-block" name="loginBtn" value="确 认" type="submit">
                </div>
            </div>
        </form>
    </div>
    <!--Basic Scripts-->
    <script src="../style/jquery.js"></script>
    <script src="../style/bootstrap.js"></script>
    <script src="../style/jquery_002.js"></script>
    <!--Beyond Scripts-->
    <script src="../style/beyond.js"></script>

</body><!--Body Ends--></html>