<!DOCTYPE html>
<?php @session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>忘记密码</title>
    <style>
        body {
            background-color: #eeeeee;
        }
    </style>
</head>
<body>
    <?php
    require_once '../../Comm/function.php';
    $link = link_SQL();
    // ------ 输入验证
    if (!isset($_POST['btn']) || !isset($_POST['username']))
        jumpToURL('forget_pwd.php');
    // ------ 用户名验证
    $query = "SELECT * FROM `user_account` WHERE `name`='{$_POST['username']}'";
    $result = mysqli_query($link, $query);
    if ($result -> num_rows > 0)
        $user = getRet_SQL($result);
    else
        jumpToURL('forget_pwd.php', array('ret' => 1));
    // ------ 验证信息
    if (!isset($_POST['valid']))
        jumpToURL('forget_pwd.php', array('ret' => 2));
    if ($user['phone'] != $_POST['valid'] && $_POST['validSel'] == 'phone')
        // 信息错误 - phone
        jumpToURL('forget_pwd.php', array('ret' => 3));
    elseif ($user['email'] != $_POST['valid'] && $_POST['validSel'] == 'email')
        // 信息错误 - email
        jumpToURL('forget_pwd.php', array('ret' => 3));
    else
    {
        $query = "UPDATE `user_account` SET `pwd_rst`=1 WHERE `id`={$user['id']}";
        $result = mysqli_query($link, $query);
        if (!$result)
            popWarn("SQL错误！");
        setcookie('username', $user['name'], time()+3600, '/');
        setcookie('userID', $user['id'], time()+3600, '/');
        jumpToURL('reset_pwd.php', array('flag' => 1));
    }
    mysqli_close($link);
    ?>
</body>
</html>

<!-- 
<input class="form-control" name="username" placeholder="输入用户名" type="text"
<select class="form-control" name="validSel">
<option selected value="phone">使用手机验证</option>
<option value="email">使用邮箱验证</option>
</select>
<input class="form-control" name="valid" placeholder="输入预留的联系信息" type="text">
<input class="btn btn-primary btn-block" name="loginBtn" value="提 交" type="submit">
-->