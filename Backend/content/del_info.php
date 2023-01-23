<!DOCTYPE html>
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1); // 初始化&登录检查

if (!isset($_GET['id']))
{   // 参数错误
    popWarn('参数错误！');
    jumpToURL('supdemInfo_list.php');
}
$link = link_SQL();

// 获取信息
$rs = getRet_SQL(mysqli_query($link, "SELECT * FROM `sup_and_dem` WHERE `id`={$_GET['id']}"));
$del_ID   = $rs['id'];
$del_name = $rs['name'];

@unlink(LOC.'../Data/supdemImg/'.$del_ID.'.png');
$qurey = "DELETE FROM `sup_and_dem` WHERE `id`={$del_ID}";
$rs = mysqli_query($link, $qurey);
if ($rs)
{
    if (isset($_GET['id']))
    {
        $msg = '删除成功！即将返回列表';
        jumpToURL('supdemInfo_list.php', array(), 2);
    }
}
else
{
    $msg = '<span class="red">数据库操作失败！即将返回列表</span>';
    jumpToURL('supdemInfo_list.php', array(), 2);
}

?>

<html>

<head>
    <meta charset="utf-8">
    <title>删除供需信息</title>
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
                    '内容管理' => '',
                    '供需信息列表' => 'supdemInfo_list.php',
                    '删除供需信息' => ''
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