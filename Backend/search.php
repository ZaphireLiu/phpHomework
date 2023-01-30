<!DOCTYPE html>
<?php
require_once 'load_resources.php';
preLoad(0); //初始化&登录检查
$link = link_SQL();
if (isset($_GET['kw'])) {
    $searchContent = $_GET['kw'];
    $title   = '搜索结果 - ' . $searchContent;
    $mode    = 1;
    // 获取搜索结果
    $query   = "SELECT * FROM `news_data` WHERE `title` LIKE '%{$_GET['kw']}%' ORDER BY `publish_time` DESC";
    $rs_news = query_SQL($link, $query);
    $query   = "SELECT * FROM `sup_and_dem` WHERE `name` LIKE '%{$_GET['kw']}%' ORDER BY `publish_time` DESC";
    $rs_info = query_SQL($link, $query);
    $query   = "SELECT * FROM `user_account` WHERE `name` LIKE '%{$_GET['kw']}%' ORDER BY `create_time` DESC";
    $rs_user = query_SQL($link, $query);
    if (PER_ADM)
    {   // 具有超管权限，搜索管理员列表
        $query = "SELECT * FROM `admin_account` WHERE `name` LIKE '%{$_GET['kw']}%' ORDER BY `create_time` DESC";
        $rs_admin = query_SQL($link, $query);
    }
    else $rs_admin = false;
    // 合并、排序结果
    $rs        = array();
    $searchNum = 0;
    if ($rs_news)
    {
        $searchNum += count($rs_news);
        foreach ($rs_news as $v)
        {
            $v['search_type'] = '新闻';
            $v['search_time'] = $v['publish_time'];
            $v['url']         = './content/edit_news.php?id='.$v['id'];
            $rs[]             = $v;
        }
    }
    if ($rs_info)
    {
        $searchNum += count($rs_news);
        foreach ($rs_info as $v)
        {
            $v['search_type'] = '供需';
            $v['search_time'] = $v['publish_time'];
            $v['url']         = './content/detail_info.php?id='.$v['id'];
            $rs[]             = $v;
        }
    }
    if ($rs_user)
    {
        $searchNum += count($rs_news);
        foreach ($rs_user as $v)
        {
            $v['search_type'] = '用户';
            $v['search_time'] = $v['create_time'];
            $v['url']         = './user/detail.php?id='.$v['id'];
            $rs[]             = $v;
        }
    }
    if ($rs_admin)
    {
        $searchNum += count($rs_admin);
        foreach ($rs_admin as $v)
        {
            $v['search_type'] = '管理';
            $v['search_time'] = $v['create_time'];
            $v['url']         = './admin/detail.php?id='.$v['id'];
            $rs[]             = $v;
        }
    }
    sortSearchRes($rs);    
} else {
    $title = '搜索页';
    $mode = 0;
}
mysqli_close($link);
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
        .searchRes .btn-left {
            float: right;
            width: 34px;
        }
        .searchRes .item {
            padding-top: 5px;
            padding-bottom: 10px;
        }
        .searchRes .head {
            font-weight: bold;
            width: 70px;
            text-align: center;
            padding-right: 2px;
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
                                                    <input class="form-control" id="search" placeholder="按下回车以搜索" name="kw" type="text">
                                                </div>
                                                <input type="submit" class="btn btn-default btn-left" style="font-family: FontAwesome" value="&#xf002;">
                                            </div>
                                        </form>
                                        <hr style="width: 80%;"/>
                                        <?php if ($mode): ?>
                                        <!-- 搜索结果 -->
                                        <div class='searchRes'>
                                            <p>共找到<?= $searchNum ?>条结果</p>
                                            <?php foreach ($rs as $v): ?>
                                            <div class="item">
                                                <a style="color: #003371" href="<?= $v['url'] ?>" target="_blank">
                                                    <span class="head"> <?= $v['search_type'] ?> </span>
                                                    <?= cutStr($v['name']??$v['title'], 25) ?>
                                                </a>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <!-- /搜索结果 -->
                                        <?php endif; ?>
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