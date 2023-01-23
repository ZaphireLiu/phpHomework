<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>登录</title>
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
    /*
        proc返回到login的错误值：
        值|描述
        --|--
        0 |用户名/密码为空 or 其他情况
        1 |用户名/密码错误
        2 |用户不存在
    */
    if (isset($_GET['from']))
        $from = $_GET['from'];
    else
        $from = '';
    define('DEBUG', false);
    if (!isset($_POST['btn_login'])) // 未按下登录按钮，非正常情况
        jumpToURL('login.php', array('retVal' => 0, 'from' => $from));
    if (isset($_POST['remember-me']))
        $expTime = time() + 30*24*3600;
    else
        $expTime = time() + 3600;
    $link = link_SQL();
    @$name = $_POST['username'];
    @$pwd = $_POST['password'];
    $pwdValid = md5($name.'salt'.$pwd);
    $pwdValidReset = md5($name.'salt');
    if (strlen($name) == 0)
    {
        mysqli_close($link);
        jumpToURL('login.php', array('retVal' => 1, 'from' => $from));
    }
    $query = <<<str
        SELECT * FROM `user_account` WHERE 
            `name`  = '{$name}'
        or  `phone` = '{$name}'
        or  `email` = '{$name}'
    str;
    $result = mysqli_query($link, $query);
    if ($result -> num_rows > 0)
    {
        $usrAcc = validAcc($result, $name);
        if ($pwdValid == $usrAcc['pwd_md5'])
        {   // 密码验证通过
            setcookie('userID',     $usrAcc['id'],      $expTime, '/');
            setcookie('username',   $usrAcc['name'],    $expTime, '/');
            setcookie('isLoggedIn', true,               $expTime, '/');
            if (!DEBUG)
            {
                $query = "UPDATE `user_account` SET last_login_time=NOW() WHERE `id`={$usrAcc['id']}";
                @mysqli_query($link, $query);
                if (isset($_GET['from']))
                jumpToURL('../'.$_GET['from']);
                else
                jumpToURL('../index.php');
            }
            else
            {
                echo $_COOKIE['isLoggedIn'].'<br>';
                echo $_COOKIE['userID'].'<br>';
                echo $_COOKIE['username'].'<br>';
            }
        }
        elseif ($usrAcc['pwd_rst'])
        {   // 密码为空，指引到重置密码的界面
            // 仍然需要设置Cookie要不不知道是谁
            setcookie('userID',     $usrAcc['id'],      $expTime, '/');
            setcookie('username',   $usrAcc['name'],    $expTime, '/');
            setcookie('isLoggedIn', false,              $expTime, '/');
            jumpToURL('reset_pwd.php', array('flag' => 1, 'from' => $from));
        }
        else 
            // 密码错误
            jumpToURL('login.php', array('retVal' => 2, 'from' => $from));
    }
    else 
        // 用户不存在
        jumpToURL('login.php', array('retVal' => 3, 'from' => $from));

    mysqli_close($link);
    ?>

</body>
</html>