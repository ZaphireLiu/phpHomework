<!DOCTYPE html>
<?php
// 注意手动修改这里的地址和perLoad的层数
// 其他地方的位置、地址等均可动态加载
require_once '../load_resources.php';
require_once '../../Comm/function.php';
preLoad(1); //初始化&登录检查
$link = link_SQL();
// 检验输入 ------ 提交按钮
if (!isset($_POST['submit']))
    // ——非正常到达页面
    jumpToURL('add.php', array('retVal' => 0));
// 检验输入 ------ 用户名
$res = mysqli_query($link, "SELECT * FROM `user_account` WHERE `name`='{$_POST['username']}'");
if (getRet_SQL($res))
    // ——用户名重复
    jumpToURL('add.php', array('retVal' => 1));
else
    $query_name = "'".$_POST['username']."'";
// 检验输入 ------ 密码
if (isset($_POST['set_pwd']))
{
    $query_pwdRst = 0;
    if ((!isset($_POST['pwd']) || !isset($_POST['pwdValid'])) || (!@$_POST['pwd'] || !@$_POST['pwdValid']))
        // ——没有填写密码
        jumpToURL('add.php', array('retVal' => 20));
    elseif ($_POST['pwd'] != $_POST['pwdValid'])
        // ——两次填写不一致
        jumpToURL('add.php', array('retVal' => 21));
    else
        $query_pwd = "'".md5($_POST['username'].'salt'.$_POST["pwd"])."'";
}
else
{
    $query_pwdRst = 1;
    $query_pwd    = "NULL";
}
// 检验输入 ------ 手机号
if (isset($_POST['phone']) && @$_POST['phone'])
{
    $query = "SELECT * FROM `user_account` WHERE `phone`='{$_POST['phone']}'";
    $res = mysqli_query($link, $query);
    if (getRet_SQL($res))
        // ——手机号重复
        jumpToURL('add.php', array('retVal' => 30));
    elseif (false)
    {   // ——格式错误
        jumpToURL('add.php', array('retVal' => 31));
    }
    else
        $query_phone = "'".$_POST["phone"]."'";
}
else
    $query_phone = "NULL";
// 检验输入 ------ 邮箱
if (isset($_POST['email']) && @$_POST['email'])
{
    $query = "SELECT * FROM `user_account` WHERE `email`='{$_POST['email']}'";
    $res = mysqli_query($link, $query);
    if (getRet_SQL($res))
        // ——邮箱重复
        jumpToURL('add.php', array('retVal' => 40));
    elseif (false)
    {   // ——格式错误
        jumpToURL('add.php', array('retVal' => 41));
    }
    else
        $query_email = "'".$_POST["email"]."'";
}
else
    $query_email = "NULL";
// 生成id
$id = genID($link, 'user_account');
// 插入数据
$query = <<<str
    INSERT INTO `user_account` 
    (`id`, `name`, `phone`, `email`, `pwd_md5`, `pwd_rst`) 
    VALUES ({$id}, {$query_name}, {$query_phone}, {$query_email}, {$query_pwd}, {$query_pwdRst});
str;
$res = mysqli_query($link, $query);
if ($res)
{
    $msg = '操作成功，即将返回用户列表';
    jumpToURL('list.php', array(), 2);
}
else
{   // ——数据库操作失败
    $msg = '<span style="color: red">操作失败，请检查数据库</span>';
    jumpToURL('add.php', array('retVal' => 5), 3);
}
mysqli_close($link);
?>
<html>

<head>
    <meta charset="utf-8">
    <title>新增管理员账号</title>
    <?php load_cssFile()
    // 加载css文件 
    ?>
</head>

<body>

    <?php 
    // 处理完毕，显示页面内容
    load_navBar();
    // 导航栏 
    ?>

    <div class="main-container container-fluid">
        <div class="page-container">
            <?php load_sideBar()
            // 侧边栏 
            ?>
            <div class="page-content">
                <?php load_breadcrumb(array(
                    '管理面板' => LOC.'index.php',
                    '用户管理' => '',
                    '用户列表' => 'list.php',
                    '新增用户' => ''
                )) // 目录 
                ?>
                <!-- Page Body: 页面的主体 -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <!-- Content: 页面内容 -->
                                <div class="widget-header bordered-bottom bordered-blue">
                                    <span class="widget-caption">新增用户账号</span>
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