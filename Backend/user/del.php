<!DOCTYPE html>
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1); // 初始化&登录检查
// setcookie('confirmDelUser', 0, time()+60);
if (!isset($_GET['id']))
{   // 参数错误
    popWarn('参数错误！');
    jumpToURL('list.php');
}
$link = link_SQL();

// 获取信息
$rs = getRet_SQL(mysqli_query($link, "SELECT * FROM `user_account` WHERE `id`={$_GET['id']}"));
$del_ID   = $rs['id'];
$del_name = $rs['name'];

// 用户数据和供求数据相关，只清除账号数据不删除ID
@unlink(LOC.'../Data/userAvatar/'.$del_ID.'.png');
$qurey = "UPDATE `user_account` SET `name`='已注销账号', `phone`='', `email`='', `pwd_md5`='', `pwd_rst`='', `create_time`=0, `last_login_time`=0, `cancelled`=1 WHERE `id`={$_GET['id']}";
$rs = mysqli_query($link, $qurey);
if ($rs)
{
    $msg = '删除成功！即将返回列表';
    jumpToURL('list.php', array(), 2);
}
else
{
    $msg = '<span class="red">数据库操作失败！即将返回列表</span>';
    jumpToURL('list.php', array(), 2);
}

// 不知道为啥在多次重复操作时会读到上次的Cookie
// 目前的解决方案是php和js各删一遍
// 1.19: 问题找到了，改为在list里提前调用js弹出提示框
// setcookie('confirmDelUser', 0, time()-1);
// echo <<<EOF
// <script type="text/javascript">
//     document.cookie="confirmDelUser=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
// </script>
// EOF;
?>

<html>
<!-- <?= var_dump($_COOKIE); ?> -->
<head>
    <meta charset="utf-8">
    <title>删除用户</title>
    <?php load_cssFile()
    // 加载css文件 ?>
</head>

<body>

    <!-- <?= var_dump($_COOKIE); ?> -->

    <?php load_navBar(); 
    // 导航栏 ?>

    <div class="main-container container-fluid">
        <div class="page-container">
            <?php load_sideBar()
            // 侧边栏 ?>
            <div class="page-content">
                <?php load_breadcrumb(array(
                    '管理面板' => LOC.'index.php',
                    '用户管理' => '',
                    '用户列表' => 'list.php',
                    '删除用户' => ''
                )) ?>
                <!-- Page Body: 页面的主要内容 -->
                <div class="page-body">
                    <div style="text-align:center; line-height:1000%; font-size:24px;">
                        <?= $msg ?><br>
                    </div>
                </div>
                <!-- /Page Body -->
            </div>
        </div>
    </div>

    <?php load_jsFile()  
    // 实现一些效果的js脚本文件 ?>

</body>

</html>