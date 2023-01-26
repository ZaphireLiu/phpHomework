<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1);
$link = link_SQL();

if (!isLoggedIn())
    jumpToURL('login.php');
if (!isset($_POST['btn']))
    jumpToURL('edit_info.php');

$query = "SELECT * FROM `user_account` WHERE `id`={$_COOKIE['userID']}";
$user  = getRet_SQL(mysqli_query($link, $query));
// ----- 手机号
if (isset($_POST['phone']))
{
    if (query_SQL($link, "SELECT `id` FROM `user_account` WHERE `phone`='{$_POST['phone']}'"))
        if ($user['phone'] != $_POST['phone'])
            jumpToURL('edit_info.php', array('ret' => 1));
    else
        $qPhone = "`phone`='{$_POST['phone']}',";
}
else
    $qPhone = '';
// ----- 邮箱
if (isset($_POST['mail']))
{
    if (query_SQL($link, "SELECT `id` FROM `user_account` WHERE `email`='{$_POST['mail']}'"))
        if ($user['email'] != $_POST['mail'])
            jumpToURL('edit_info.php', array('ret' => 2));
    else
        $qEmail = "`email`='{$_POST['mail']}'";
}
else
    $qEmail = '';
// ----- SQL操作
if ($qPhone || $qEmail)
{
    $query  = "UPDATE `user_account` SET {$qPhone} {$qEmail} WHERE `id`={$_COOKIE['userID']}";
    $result = mysqli_query($link, $query);
    if (!$result)
        popWarn("SQL操作错误！");
}
// ----- 头像
if ($_FILES['img']['error'] != 4)
{   // 上传
    if (!$_FILES['img']['error'])
    {   // 没错误
        $suffix = @array_pop(explode('.', $_FILES['img']['name']));
        $sufArr = array("bmp", "gif", "jpeg", "jpg", "png", "wbmp", "webp");
        if (!in_array($suffix, $sufArr))
            // 文件格式错误
            jumpToURL('edit_info.php', array('retVal' => 60));
        $retVal = saveResizedImg('img', $_COOKIE['userID'], LOC.'../Data/userAvatar');
        if ($retVal)
        {
            $retVal = -1*$retVal + 63;
            jumpToURL('edit_info.php', array('retVal' => $retVal));
        }
    }
    elseif ($_FILES['avatar']['error'] != 4)
        // 上传错误 61/62/63
        jumpToURL('edit_info.php', array('retVal' => 60 + $_FILES['avatar']['error']));
}
else
    // 没有上传
    $retVal = 0;

// 处理完毕且没有错误，返回个人空间
jumpToURL('space.php');
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>编辑个人资料</title>
    <?php load_cssFile() ?>
</head>

<body class="single2">

    <?php load_header()
    // 页首栏 
    ?>

</body>

</html>