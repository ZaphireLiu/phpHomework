<!DOCTYPE html>
<!--
    To do:
    - 错误返回自动填充
    - 手机号、邮箱格式校验
-->
<?php
// 注意手动修改这里的地址和perLoad的层数
// 其他地方的位置、地址等均可动态加载
require_once '../load_resources.php';
require_once '../../Comm/function.php';
preLoad(1); //初始化&登录检查
$link = link_SQL();
// 检验输入 ------ 提交按钮
if (!isset($_POST['submit']) || !isset($_POST['id']))
    // ——非正常到达页面
    jumpToURL('edit.php', array('retVal' => 0));
$targetAcc = getRet_SQL(mysqli_query($link, "SELECT * FROM admin_account WHERE `id`='{$_POST['id']}'"));
// 检验输入 ------ 权限
$query_perm = "`permission`={$_POST['permission']}";
// 检验输入 ------ 密码重置
$query_rstPwd = isset($_POST['rst_pwd']) ? '`pwd_rst`=1,' : '';
// 检验输入 ------ 手机号
if (isset($_POST['phone']))
{
    $res = mysqli_query($link, "SELECT * FROM admin_account WHERE `phone`='{$_POST['phone']}'");
    if (getRet_SQL($res) && $_POST['phone'] != $targetAcc['phone'])
        // ——手机号重复
        jumpToURL('edit.php', array('retVal' => 30));
    elseif (false)
    {   // ——格式错误
        jumpToURL('edit.php', array('retVal' => 31));
    }
    else
        $query_pnone = "`phone`='{$_POST['phone']}',";
}
else
    $query_pnone = '';
// 检验输入 ------ 邮箱
if (isset($_POST['email']))
{
    $res = mysqli_query($link, "SELECT * FROM admin_account WHERE `email`='{$_POST['email']}'");
    if (getRet_SQL($res) && $_POST['email'] != $targetAcc['email'])
        // ——邮箱重复
        jumpToURL('edit.php', array('retVal' => 40));
    elseif (false)
    {   // ——格式错误
        jumpToURL('edit.php', array('retVal' => 41));
    }
    else
        $query_email = "`email`='{$_POST['email']}',";
}
else
    $query_email = '';
// 修改数据
$query = "UPDATE `admin_account` SET {$query_rstPwd} {$query_pnone} {$query_email} {$query_perm} WHERE `id`={$_POST['id']}";
// echo $query;
$res = mysqli_query($link, $query);
mysqli_close($link);
// 头像处理
if (!$_FILES['avatar']['error'])
{
    $suffix = @array_pop(explode('.', $_FILES['avatar']['name']));
    $sufArr = array("bmp", "gif", "jpeg", "jpg", "png", "wbmp", "webp");
    if (!in_array($suffix, $sufArr))
        // 文件格式错误
        jumpToURL('edit.php', array('retVal' => 60));
    $retVal = saveResizedImg('avatar', $_POST['id'], LOC.'../Data/adminAvatar');
    if ($retVal)
    {
        $retVal = -1*$retVal + 63;
        jumpToURL('edit.php', array('retVal' => $retVal));
    }
}
elseif ($_FILES['avatar']['error'] != 4)
    // 上传错误 61/62/63
    jumpToURL('edit.php', array('retVal' => 60 + $_FILES['avatar']['error']));
else
    // 没有上传头像
    $retVal = 0;
if ($res && !$retVal)
{
    $msg = '操作成功，'.(@$_GET["self"] ? '即将转到主页' : '即将返回');
    if (isset($_GET["self"]))
        jumpToURL(LOC.'index.php', array(), 2);
    else
        jumpToURL('admin_list.php', array(), 2);
}
else
{   // ——数据库操作失败
    $msg = '<span style="color: red">操作失败，请检查数据库</span>';
    jumpToURL('edit.php', array('retVal' => 5), 3);
}
?>
<html>

<head>
    <meta charset="utf-8">
    <title><?= @$_GET["self"] ? "编辑个人资料" : "编辑管理员资料" ?></title>
    <?php load_cssFile()
    // 加载css文件
    ?>
</head>

<body>

    <?php
    $bcArray = !@$_GET["self"] ?
    array(
        '管理面板' => LOC.'index.php',
        '管理员' => '',
        '管理员列表' => 'adm_list.php',
        '编辑' => '')
    :
    array(
        '管理面板' => LOC.'index.php',
        '管理员' => '',
        '编辑个人资料' => '');
    load_navBar();
    // 导航栏
    ?>

    <div class="main-container container-fluid">
        <div class="page-container">
            <?php load_sideBar()
            // 侧边栏
            ?>
            <div class="page-content">
                <?php load_breadcrumb($bcArray) // 目录
                ?>
                <!-- Page Body: 页面的主体 -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <!-- Content: 页面内容 -->
                                <div class="widget-header bordered-bottom bordered-blue">
                                    <span class="widget-caption">
                                        <?= @$_GET["self"] ? "编辑个人资料" : "编辑管理员资料" ?>
                                    </span>
                                </div>
                                <div class="widget-body">
                                    <div style="padding-top: 30px; padding-bottom: 40px">
                                    <div style="text-align:center; line-height:1000%; font-size:24px;">
                                        <?= $msg ?>
                                    </div>
                                    </div>
                                </div>
                                <!-- /Content -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Body -->
            </div>
        </div>
    </div>

    <?php load_jsFile()
    // 实现一些效果的js脚本文件
    ?>

</body>

</html>