<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>重置密码</title>
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
    </style>
</head>

<body class="single2">

    <?php
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
        $query = "SELECT * FROM `user_account` WHERE `id` = '{$id}";
        $res = getRet_SQL(mysqli_query($link, $query));
        if ($pwdValid != $res['pwd_md5'])
            jumpToURL('reset_pwd.php', array('flag' => 2));
    }
    if ($_POST['password'] != $_POST['password'])
        // 输入密码两次不一致
        jumpToURL('reset_pwd.php', array('flag' => 3));
    $new_MD5 = md5($name.'salt'.$_POST['password']);
    $query = "UPDATE user_account SET pwd_rst=0, pwd_md5={$new_MD5} WHERE id={$id}";
    $rs = mysqli_query($link, $query);
    $msg = '';
    if ($rs)
    {
        $msg = '重置密码成功！<br/>即将跳转登录页面';
        jumpToURL('login.php', array(), 2);
    }
    else
    {   // 数据库插入数据失败
        $msg = '<span style="color: red">操作失败，请重试或联系管理员<br/>正在返回...</span>';
        jumpToURL('reset_pwd.php', array(), 2);
    }
    ?>

</body>
</html>