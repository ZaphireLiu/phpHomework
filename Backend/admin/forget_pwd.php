<!DOCTYPE html>
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
@session_start();
if (isset($_GET['ret']))
{
    if ($_GET['ret'] == 1)
        jumpToURL('login.php', array(), 2.5);
    $errMsg = array(
        1 => '用户不存在！',
        2 => '请填写联系信息以验证！',
        3 => '填写的信息与保存的不符！'
    )[$_GET['ret']];
}
else
    $errMsg = '';
?>
<html xmlns="http://www.w3.org/1999/xhtml"><!--Head--><head>
    <meta charset="utf-8">
    <title>忘记密码</title>
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
        <form action="forget_proc.php" method="POST">
            <div class="loginbox bg-white">
                <div class="loginbox-title">忘记密码</div>
                <div class="loginbox-textbox">
                    <input class="form-control" name="username" placeholder="输入用户名" type="text"
                    <?= isset($_SESSION['loginInput_name']) ? "value='{$_SESSION['loginInput_name']}'" : '' ?>>
                </div>
                <div class="loginbox-textbox" style="color: #777">
                    选择验证方式：
                </div>
                <div class="loginbox-textbox">
                    <select class="form-control" name="validSel">
                        <option selected value="phone">使用手机验证</option>
                        <option value="email">使用邮箱验证</option>
                    </select>
                </div>
                <div class="loginbox-textbox">
                    <input class="form-control" name="valid" placeholder="输入预留的联系信息" type="text">
                </div>
                <div class="loginbox-submit">
                    <input class="btn btn-primary btn-block" name="btn" value="验 证" type="submit">
                </div>
            </div>
        </form>

        <?php if (strlen($errMsg) > 0): ?>
        <div class="logobox">
            <p class="text-center" style="font-family:'Microsoft YaHei'; color:#df2b30;">
                <?= $errMsg ?>
        </div>
        <?php endif; ?>

    </div>
    <!--Basic Scripts-->
    <script src="../style/jquery.js"></script>
    <script src="../style/bootstrap.js"></script>
    <script src="../style/jquery_002.js"></script>
    <!--Beyond Scripts-->
    <script src="../style/beyond.js"></script>

</body><!--Body Ends--></html>