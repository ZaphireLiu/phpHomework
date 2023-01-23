<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1);
if (!isLoggedIn())
    jumpToURL('login.php');

$id   = $_COOKIE['userID'];
$link = link_SQL();
$user = getRet_SQL(mysqli_query($link, "SELECT * FROM `user_account` WHERE `id`={$id}"));
$msg  = isset($_GET['ret']) ? array(
    1 => '手机号已被使用！',
    2 => '邮箱已被使用！',
    60 => '头像文件格式错误，请重新选择头像文件',
    61 => '头像文件过大，请重新选择头像文件',       // 上传的文件超过了php.ini中upload_max_filesize选项限制的值
    62 => '头像文件过大，请重新选择头像文件',       // 上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值
    63 => '头像文件上传不成功，请重新上传',         // 文件只有部分被上传
    64 => '头像文件上传不成功，请重新上传',         // 移动临时文件失败
    65 => '头像文件格式错误，请重新选择头像文件',   // 同60，函数检查出错误
    66 => '头像文件格式错误，请重新选择头像文件'    // 文件格式与后缀名不符
)[@$_GET['ret']] : '';
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>编辑个人资料</title>
    <?php load_cssFile() ?>
    <link rel="stylesheet" href="<?= LOC ?>style/basic-grey.css" type="text/css" />
    <style type="text/css">
        #wrapper {
            background-color: #ffffff;
        }
        .single_entry {
            margin-top: 30px;
        }
    </style>
</head>

<body class="single2">

    <?php load_header()
    // 页首栏 
    ?>

    <div id="wrapper">
        <!-- 页面内容 -->
        <div class="single_entry page_entry">
            <!-- <div class="entry"> -->
            <div class="user-info" style="width: 60%; padding-top: 30px; margin-left: 20%; border-bottom: 0px">
                <div class="user-info-sub" style="float: left">
                    <img class="img user-avatar" src="<?= getAvatar(LOC, $id) ?>" alt="<?= $user['name'] ?>"
                    style="padding-top: 12px;">
                    <div class="user-name"><?= $user['name'] ?></div>
                </div>
            </div>

            <form action="../../../Asset/Test/printForm.php" method="post" class="basic-grey" enctype="multipart/form-data">
                <div class="red" style="padding-left: 21%; padding-bottom: 15px; font-size: medium;"><?= $msg ?></div>

                <label id="img">
                    <span>更改头像：</span>
                    <input id="img" type="file" name="img" />
                </label>

                <label id="phone">
                    <span>手机号：</span>
                    <input id="phone" type="text" name="phone" placeholder="输入手机号，用于密码找回和供需信息发布" value="<?= $user['phone'] ?>" />
                </label>

                <label id="mail">
                    <span>邮箱：</span>
                    <input id="mail" type="text" name="mail" placeholder="输入邮箱，用于密码找回和供需信息发布" value="<?= $user['email'] ?>" />
                </label>

                <label>
                    <span style="user-select: none;">&nbsp;</span>
                </label>
                <input id="submitBtn" type="submit" class="button" name="btn" value="保  存" />

            </form>
            <div class="clear"></div>
        </div>
        <!-- 页面内容 -->
    </div>

    <?php
    unset($_POST);
    load_footer();
    // 页尾栏 
    ?>

</body>
</html>