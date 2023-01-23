<!DOCTYPE html>
<?php
// 注意手动修改这里的地址和perLoad的层数
// 其他地方的位置、地址等均可动态加载
require_once '../load_resources.php';
preLoad(1); //初始化&登录检查
if (isset($_GET['retVal']))
{
    $msg = array(
        0 => '原密码错误',
        1 => '两次密码输入不一致！',
    )[$_GET['retVal']];
}
else
    $msg = '';
$link = link_SQL();
$rsAdm = getRet_SQL(mysqli_query($link, "SELECT `pwd_rst` FROM `admin_account` WHERE `id`=".ID_ADM));
mysqli_close($link);
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
        .errMsg {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            line-height: 200%;
            font-size: 17px;
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

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <div class="widget-header bordered-bottom bordered-blue">
                                    <span class="widget-caption">修改密码</span>
                                </div>
                                <div class="widget-body">
                                    <!-- CodeHere -->
                                    <div class="errMsg red"><?= $msg ?></div>
                                    <div id="horizontal-form">
                                        <form class="form-horizontal" role="form" action="pwd_edit_proc.php" method="post">
                                            <div class="form-group" <?= $rsAdm['pwd_rst']?"style='display: none'":'' ?>>
                                                <label for="pwd_ori" class="col-sm-2 control-label no-padding-right">原密码</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="pwd_ori" placeholder="" name="pwd_ori" <?= $rsAdm['pwd_rst']?"":'required=""' ?> type="password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd" class="col-sm-2 control-label no-padding-right">输入密码</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="pwd" placeholder="" name="pwd" required="" type="password">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd_valid" class="col-sm-2 control-label no-padding-right">再次输入密码</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="pwd_valid" placeholder="" name="pwd_valid" required="" type="password">
                                                </div>
                                            </div>
                                            <input name="id" value="<?= ID_ADM ?>" type="hidden">
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <input type="submit" class="btn btn-default" name="submit" value="提交">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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