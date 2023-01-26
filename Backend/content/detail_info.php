<!DOCTYPE html>
<?php
// 注意手动修改这里的地址和perLoad的层数
// 其他地方的位置、地址等均可动态加载
require_once '../load_resources.php';
require_once '../../Comm/function.php';
preLoad(1); //初始化&登录检查

if (!isset($_GET['id']))
    // $_GET['id'] = 2;
    jumpToURL('supdemInfo_list.php');

$link = link_SQL();
$data = getRet_SQL(mysqli_query($link, 
    "SELECT * FROM `sup_and_dem` WHERE `id`={$_GET['id']}"));
$usrName = getRet_SQL(mysqli_query($link, 
    "SELECT `name` FROM `user_account` WHERE `id`={$data['user_id']}"))['name'];
?>
<html>

<head>
    <meta charset="utf-8">
    <title>供需信息详情</title>
    <?php load_cssFile()
    // 加载css文件 
    ?>
    <style>
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
                    '管理面板' => LOC . 'index.php',
                    '内容管理' => '',
                    '新闻列表' => 'news_list.php',
                    '编辑新闻' => ''
                )) // 目录 
                ?>
                <!-- Page Body: 页面的主体 -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <!-- Content: 页面内容 -->
                                <div class="widget-header bordered-bottom bordered-blue">
                                    <span class="widget-caption">供需信息详情</span>
                                </div>
                                <div class="widget-body">
                                    <div class="errMsg">用户发布的供需信息，管理员无法修改内容</div>
                                    <div id="horizontal-form">
                                        <form class="form-horizontal" role="form" action="edit_news_proc.php" method="post" id="news_form" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="id" class="col-sm-2 control-label no-padding-right">ID</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="id" readonly="readonly" type="text" value="<?= $_GET['id'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="title" class="col-sm-2 control-label no-padding-right">标题</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="title" readonly="readonly" type="text" value=<?= $data['name'] ?>>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usrName" class="col-sm-2 control-label no-padding-right">用户名</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="usrName" readonly="readonly" type="text" value=<?= $usrName ?>>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="con" class="col-sm-2 control-label no-padding-right">联系方式</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="con" readonly="readonly" type="text" value=<?= $data['contact'] ?>>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="username" class="col-sm-2 control-label no-padding-right">内容</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" id="content" form="news_form" rows="10" readonly="readonly" style="resize: none"><?= file_get_contents(LOC . '../Data/supdem/' . $_GET['id'] . '.txt') ?></textarea>
                                                </div>
                                            </div>
                                            <?php 
                                            $img = getInfoImg($link, LOC, $_GET['id']);
                                            if ('default_supply.png' != substr($img, -18) && 'default_demand.png' != substr($img, -18)):
                                            ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right">宣传图</label>
                                                <div class="col-sm-6">
                                                    <img src="<?= $img ?>">
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </form>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <a href="../../Frontend/supdem/detail.php?id=<?= $_GET['id'] ?>">
                                                    <button class="btn btn-default">转到对应页面</button>
                                                </a>
                                            </div>
                                        </div>
                                        <div style="padding-bottom: 45px"></div>
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

    <?php 
    mysqli_close($link);
    load_jsFile(); // 实现一些效果的js脚本文件 
    ?>

</body>

</h