<!DOCTYPE html>
<?php
require_once 'load_resources.php';
preLoad(0); //初始化&登录检查
if (isset($_GET['keyword'])) {
    $searchContent = $_GET['keyword'];
    $title = '搜索结果 - ' . $searchContent;
    $mode = 1;
} else {
    $title = '搜索页';
    $mode = 0;
}
$resTest = array(
    'self'          => LOC . 'list.php?listID=1',
    '禽业'          => '',
    '猪业'          => LOC . 'list.php?listID=11',
    '饲料'          => '',
    'self'          => LOC . 'list.php?listID=2',
    '查看供应信息'  => LOC . 'list.php?listID=20',
    '查看需求信息'  => '',
    '发布信息'      => LOC . 'publish.php' ,
    'self'          => LOC . 'about.php',
    '联系我们'      => LOC . 'contact.php'
);
?>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <?php load_cssFile()
    // 加载css文件 
    ?>
    <style>
        .searchRes {
            font-size: medium;
            width: 75%;
            margin-left: auto;
            margin-right: auto;
        }
        .searchRes .head {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .searchRes .btn-left {
            float: right;
            width: 34px;
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
                    '管理面板' => '',
                    $title => ''
                )) ?>
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="flip-scroll">
                                        <!-- Page Body: 页面的主要内容 -->
                                        <div style="padding-top: 20px;"></div>
                                        <form class="form-horizontal" role="form" action="#" method="get">
                                            <div class="form-group">
                                                <label for="search" class="col-sm-2 control-label no-padding-right">搜索内容</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="search" placeholder="按下回车以搜索" name="keyword" type="text">
                                                </div>
                                                <input type="submit" class="btn btn-default btn-left" style="font-family: FontAwesome" value="&#xf002;">
                                            </div>
                                        </form>
                                        <hr style="width: 80%;"/>
                                        <div class='searchRes'>
                                        <?php 
                                        foreach ($resTest as $k => $v):
                                            echo $v ? "<a href='{$v}'><p class='head'>" : "<p class='head'>";
                                        ?>
                                        <?= $k ?>
                                        <?php 
                                            echo $v ? '</p></a>' : '</p>';
                                        endforeach;
                                        ?>
                                        </div>
                                        <div style="padding-bottom: 25px;"></div>
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