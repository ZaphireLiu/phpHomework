<!DOCTYPE html>
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1); // 初始化&登录检查
setcookie('confirmRst', 0, time()+600);
if (!isset($_GET['id']))
{   // 参数错误
    popWarn('参数错误！');
    jumpToURL('adm_list.php');
}
$link = link_SQL();

// 检查被操作账号权限
$rs = getRet_SQL(mysqli_query($link, "SELECT * FROM `user_account` WHERE `id`={$_GET['id']}"));
$del_ID   = $rs['id'];
$del_name = $rs['name'];

echo <<<EOF
    <script type="text/javascript">
    if (confirm("是否确定重置ID为{$del_ID}，用户名为{$del_name}的账号的密码？") == true) {
        document.cookie="confirmRst=1";
    }
    else {
        document.cookie="confirmRst=0";
        window.location.href = 'list.php';
    }
    </script>
EOF;

if ($_COOKIE['confirmRst'])
{
    setcookie('confirmRst', 0, time()-60);
    $qurey = "UPDATE `user_account` SET `pwd_rst`=1 WHERE `id`={$_GET['id']}";
    $rs = mysqli_query($link, $qurey);
    if ($rs)
    {
        if (isset($_GET['id']))
        {
            $msg = '操作成功！即将返回列表';
            jumpToURL('list.php', array(), 2);
        }
        else
        {
            $msg = '操作成功！即将退出登录';
            jumpToURL('logout.php', array(), 2);
        }
    }
    else
    {
        $msg = '<span class="red">数据库操作失败！即将返回列表</span>';
        jumpToURL('list.php', array(), 2);
    }
}
else
    jumpToURL('list.php');
?>
<html>

<head>
    <meta charset="utf-8">
    <title>重置用户密码</title>
    <?php load_cssFile()
    // 加载css文件 ?>
</head>

<body>

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
                    '重置用户密码' => ''
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