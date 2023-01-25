<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
const SIDEBAR_SIZE = 5;     // 侧边栏显示新闻数量
const PAGE_SIZE    = 5;     // 每页显示的数量
const PAGE_RANGE   = 5;     // 下面页码的数量（奇数）
const DETAIL_SIZE  = 80;    // 详情的字数
require_once '../Comm/function.php';
require_once 'load_resources.php';
preLoad(0);
$page = isset($_GET['page']) ? @$_GET['page'] : 1;
$link = link_SQL();
if (isset($_GET['kw']))
{
    // 查询两个板块的结果
    $query   = "SELECT * FROM `news_data` WHERE `title` LIKE '%{$_GET['kw']}%' ORDER BY `publish_time` DESC";
    $rs_news = getRet_SQL(mysqli_query($link, $query));
    $query   = "SELECT * FROM `sup_and_dem` WHERE `name` LIKE '%{$_GET['kw']}%' ORDER BY `publish_time` DESC";
    $rs_info = getRet_SQL(mysqli_query($link, $query));
    // 合并结果
    $resNum = count($rs_info) + count($rs_news);
    $title  = '搜索结果 - '.$_GET['kw'];
    $url    = 'search.php?kw='.$_GET['kw'].'&page='.$page;
    $rs     = array();
    foreach ($rs_news as $v)
        $rs[] = $v;
    foreach ($rs_info as $v)
        $rs[] = $v;
}
else 
{
    $rs     = array();
    $resNum = 0;
    $title  = '搜索页';
    $url    = 'search.php?page='.$page;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= $title ?></title>
    <?php load_cssFile('list') ?>
    <style>
        .search {
            margin-left: 170px !important;
            border-right: none !important;
        }
    </style>
</head>

<body class="single2">

    <?php load_header()
    // 页首栏 
    ?>

    <div id="wrapper">
        <!-- 页面内容 -->
        <div id="xh_container">
            <div class="search" id="xh_content">

                <?php load_path(array(
                    "首页" => "index.php",
                    $title => ""
                )) ?>
                <div class="clear"></div>
                <div class="xh_area_h_3" style="margin-top: 40px;">
                    <?php if (!$resNum): ?>
                    <div style="text-align: center; padding-bottom:30px; font-size:30px">
                        无结果！
                    </div>
                    <?php
                    endif;
                    $pageNum = ceil($resNum/PAGE_SIZE);
                    for ($i=($page-1)*PAGE_SIZE; $i<$page*PAGE_SIZE; $i++):
                        if ($i >= $resNum)
                            break;
                        $itemID = $rs[$i]['id'];
                    ?>
                    <!-- 新闻 -->
                    <?php if (isset($rs[$i]['title'])): ?>
                    <div class="xh_post_h_3 ofh">
                        <div class="xh">
                            <a target="_blank" href="article.php?id=<?= $i ?>" title="<?= $rs[$i]['title'] ?>">
                                <img src="<?= getNewsImg(LOC, $itemID) ?>" alt="<?= $rs[$i]['title'] ?>" height="240" width="400"></a>
                        </div>
                        <div class="r ofh">
                            <h2 class="xh_post_h_3_title ofh" style="height:60px;">
                                <a target="_blank" href="article.php?id=<?= $itemID ?>" title="<?= $rs[$i]['title'] ?>"><?= cutStr($rs[$i]['title'], 20) ?></a>
                            </h2>
                            <span class="time"><?= $rs[$i]['publish_time'] ?></span>
                            <div class="xh_post_h_3_entry ofh" style="color:#555;height:80px; overflow:hidden;">
                                <?= mb_readFile(LOC.'../Data/news/'.$itemID.'.txt', DETAIL_SIZE) ?>
                            </div>
                            <div class="b">
                                <span title="<?= $rs[$i]['view_time'] ?>人浏览" class="xh_views"><?= $rs[$i]['view_time'] ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- 需求信息 -->
                    <?php else: ?>
                    <div class="xh_post_h_3 ofh">
                        <div class="xh">
                            <a target="_blank" href="detail.php?id=<?= $i ?>" title="<?= $rs[$i]['name'] ?>">
                                <img src="<?= getInfoImg($link, LOC, $itemID) ?>" alt="<?= $rs[$i]['name'] ?>" height="240" width="400"></a>
                        </div>
                        <div class="r ofh">
                            <h2 class="xh_post_h_3_title ofh" style="height:60px;">
                                <a target="_blank" href="detail.php?id=<?= $itemID ?>" title="<?= $rs[$i]['name'] ?>">
                                    <?= !$rs[$i]['type'] ? "<span class='sup'>供应</span>" : "<span class='dem'>需求</span>" ?>
                                    <?= cutStr($rs[$i]['name'], 20) ?>
                                </a>
                            </h2>
                            <span class="time"><?= $rs[$i]['publish_time'] ?></span>
                            <div class="xh_post_h_3_entry ofh" style="color:#555;height:80px; overflow:hidden;">
                                <?= mb_readFile(LOC.'../Data/supdem/'.$itemID.'.txt', DETAIL_SIZE) ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; endfor; ?>
                    <!-- 显示页码 -->
                    <?php if($resNum): ?>
                    <div id="pagination">
                        <div class="wp-pagenavi">
                            <a class="page larger" href='<?= $url."&page=1"?>'>首页</a>
                            <?php if ($page != 1): ?>
                                <a class="page larger" href='<?= $url."&page=".($page-1) ?>'>上一页</a>
                            <?php endif; ?>
                            <?php
                            $start = $page < floor(PAGE_RANGE/2) ? 1 : $page-floor(PAGE_RANGE/2);
                            for ($i=$start; $i<$start+PAGE_RANGE; $i++):
                                if ($i > $pageNum)
                                    break;
                                elseif ($i < 1)
                                    continue;
                            ?>
                            <?php if ($i == $page): ?>
                                <span class="current"><?= $page ?></span>
                            <?php else: ?>
                                <a class="page larger" href='<?= $url."&page=".$i ?>'><?= $i ?></a>
                            <?php endif; endfor; ?>
                            <?php if ($page != $pageNum): ?>
                                <a class="page larger" href='<?= $url."&page=".($page+1) ?>'>下一页</a>
                            <?php endif; ?>
                            <a class="page larger" href='<?= $url."&page=".$pageNum ?>'>末页</a>
                            <span class="pages">共 <?= $pageNum ?> 页，<?= $resNum ?>条</span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- /显示页码 -->
                </div>
            </div>
            <div class="clear">
            </div>
        </div>
        <!-- 页面内容 -->
    </div>

    <?php if ($resNum) load_footer();
    // 页尾栏 
    ?>

</body>

</html