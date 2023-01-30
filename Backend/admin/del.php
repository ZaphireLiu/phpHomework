<!DOCTYPE html>
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1); // 初始化&登录检查
setcookie('confirmDelAdm', 0, time()+60);
if (!PER_ADM && !isset($_GET['self']))
{   // 权限不够（把自己删了这种情况就不用权限了）
    popWarn('权限不足！');
    jumpToURL(LOC.'index.php');
}
if (!isset($_GET['id']) && !isset($_GET['self']))
{   // 参数错误
    popWarn('参数错误！');
    jumpToURL('adm_list.php');
}
$link = link_SQL();
if (isset($_GET['id']))
{   // 检查被操作账号权限
    $rs = getRet_SQL(mysqli_query($link, "SELECT * FROM `admin_account` WHERE `id`={$_GET['id']}"));
    if ($rs['permission'])
    {
        popWarn('超级管理员账号只能自己删除！');
        jumpToURL('adm_list.php');
    }
    else
    {
        $del_ID = $rs['id'];
        $del_name = $rs['name'];
    }
}
elseif (isset($_GET['self']))
{
    $del_ID = ID_ADM;
    $del_name = NAME_ADM;
}


@unlink(LOC.'../Data/adminAvatar/'.$del_ID.'.png');
$qurey = "DELETE FROM `admin_account` WHERE `id`={$del_ID}";
$rs = mysqli_query($link, $qurey);
if ($rs)
{
    if (isset($_GET['id']))
    {
        $msg = '删除成功！即将返回列表';
        jumpToURL('adm_list.php', array(), 2);
    }
    elseif (isset($_GET['self']))
    {
        $msg = '删除成功！即将退出登录';
        jumpToURL('logout.php', array(), 2);
    }
}
else
{
    $msg = '<span class="red">数据库操作失败！即将返回列表</span>';
    jumpToURL('adm_list.php', array(), 2);
}

// 不知道为啥在多次重复操作时会读到上次的Cookie
// 目前的解决方案是php和js各删一遍
setcookie('confirmDelAdm', 0, time()-1);
echo <<<EOF
    <script type="text/javascript">
        document.cookie="confirmDelAdm=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
    </script>
EOF;
?>

<html>
<!-- <?= var_dump($_COOKIE); ?> -->
<head>
    <meta charset="utf-8">
    <title>删除管理员</title>
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
                    '管理员' => '',
                    '管理员列表' => 'adm_list.php',
                    '删除管理员' => ''
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