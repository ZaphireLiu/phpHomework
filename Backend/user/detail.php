<!DOCTYPE html>
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1); //初始化&登录检查
if (!isset($_GET["id"]))
    jumpToURL('list.php');
$nameMap = array(
    'id' => '账号ID',
    'name' => '账号名称',
    'phone' => '手机号',
    'email' => '邮箱',
    'create_time' => '创建时间',
    'last_login_time' => '上次登录时间',
    'pwd_rst' => '密码被重置',
    'cancelled' => '账号已注销'
);
$link = link_SQL();
$query = "SELECT * FROM `user_account` WHERE id={$_GET["id"]}";
$rs = getRet_SQL(mysqli_query($link, $query));
?>
<html>

<head>
    <meta charset="utf-8">
    <title>管理员账号 - 详情</title>
    <?php load_cssFile()
    // 加载css文件 
    ?>
    <style>
        .detail {
            font-size: medium;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .detail .headInfo {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .detail .btn-left {
            float: right;
            width: 34px;
        }
        .table-title {
            width: 10%;
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
                    '管理面板' => LOC . 'index.php',
                    '用户管理' => '',
                    '用户列表' => 'list.php',
                    '账号详情' => ''
                )) ?>
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="flip-scroll">
                                        <!-- Page Body: 页面的主要内容 -->
                                        <!-- <div style="padding-top: 20px;"></div> -->
                                        <div class="detail">
                                        <table class="table table-bordered table-hover" style="padding-bottom: 20px;">
                                            <?php 
                                            if (!$rs['cancelled']):
                                                foreach ($nameMap as $k => $v):
                                                    if ($k == 'pwd_rst')
                                                        $val = $rs[$k] ? '是' : '否';
                                                    elseif ($k != 'cancelled')
                                                        $val = $rs[$k];
                                            ?>
                                            <tr>
                                                <td class="text-center tabel-title"><?= $v ?></td><td><?= $val ?></td>
                                            </tr>
                                            <?php endforeach; else:?>
                                            <tr>
                                                <td class="text-center tabel-title">账号ID</td><td style="width: 60%;"><?= $rs['id'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center tabel-title red" colspan="2">账号已注销</td>
                                            </tr>    
                                            <?php endif; ?>
                                        <!-- <div style="padding-bottom: 25px;">here</div> -->
                                        <!-- /Page Body -->
                                    </div>
                                </div>
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