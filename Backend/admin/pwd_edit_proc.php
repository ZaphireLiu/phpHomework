<!DOCTYPE html>
<?php
// 注意手动修改这里的地址和perLoad的层数
// 其他地方的位置、地址等均可动态加载
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1, false); //初始化&登录检查
if (!isset($_GET['to']))
{
    $from = 'pwd_edit.php';
    $to = 'login.php';
}
else
{
    $from = $_GET['from'];
    $to = $_GET['to'];
}
if (!isset($_POST['id']))
    echo 'id not set';
    // jumpToURL($from);
$link = link_SQL();
$query = "SELECT * FROM `admin_account` WHERE `id`={$_POST['id']}";
$rs = getRet_SQL(mysqli_query($link, $query));
if (!$rs)
{
    popWarn('SQL错误！没有查找到账号');
    jumpToURL('login.php');
}
if (defined('NAME_ADM'))
    $name = NAME_ADM;
elseif (isset($_SESSION['idAdm']))
    $name = $rs['name'];

if ((md5($name.'salt'.$_POST["pwd_ori"]) != $rs['pwd_md5']) && !$rs['pwd_rst'])
    // 原密码错误，也不是初始化密码
    echo 'wrone origin pwd';
    // jumpToURL($from, array('retVal' => 0));
elseif ($_POST["pwd"] != $_POST["pwd_valid"])
    // 输入不一致
    echo 'diffent input';
    // jumpToURL($from, array('retVal' => 1));

$md5Val = md5($name.'salt'.$_POST["pwd"]);
$query = "UPDATE `admin_account` SET `pwd_md5`='{$md5Val}', `pwd_rst`=0 WHERE `id`='{$_POST['id']}'";
$rs = mysqli_query($link, $query);
mysqli_close($link);
// jumpToURL($to);
die();
?>
<html>

<head>
    <meta charset="utf-8">
    <title>修改密码</title>
    <?php load_cssFile()
    // 加载css文件 
    ?>
    <style>
        .form-id {
            padding-top: 7px;
            padding-bottom: 7px;
        }
    </style>
</head>

<body>

    <?php load_navBar();
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
                    '管理员' => '',
                    '修改密码' => ''
                )) // 目录 
                ?>
                <!-- Page Body -->
                <div class="page-body">
                    <div class="row"></div>
                </div>
                <!-- /Page Body -->
            </div>
            <!-- /Page Content -->
        </div>
    </div>

    <!--Basic Scripts-->
    <script src="../style/jquery_002.js"></script>
    <script src="../style/bootstrap.js"></script>
    <script src="../style/jquery.js"></script>
    <!--Beyond Scripts-->
    <script src="../style/beyond.js"></script>



</body>

</html>