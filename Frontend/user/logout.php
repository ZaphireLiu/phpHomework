<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>注销账号</title>
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
    /*
        proc返回到login的错误值：
        值|描述
        --|--
        0 |用户名/密码为空 or 其他情况
        1 |用户名/密码错误
        2 |用户不存在
    */
    require_once '../../Comm/function.php';
    setcookie('userID',     '',     time()-1, '/');
    setcookie('username',   '',     time()-1, '/');
    setcookie('isLoggedIn', false,  time()-1, '/');
    if (isset($_GET['from']))
        jumpToURL('../'.$_GET['from']);
    else
        jumpToURL('../index.php');
    ?>

</body>
</html>