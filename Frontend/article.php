<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
const REC_SIZE = 3;
const SIDEBAR_SIZE = 5;
require_once '../Comm/function.php';
require_once 'load_resources.php';
preLoad(0);
if (!isset($_GET['id']))
    // die();
    jumpToURL('list.php');
$link = link_SQL();
$query = "SELECT * FROM `news_data` WHERE `id`={$_GET['id']}";
$rs = getRet_SQL(mysqli_query($link, $query));
if (!$rs)
    jumpToURL('error.php', array('newsNotExist' => 1));
$query = "UPDATE `news_data` SET `view_time`=`view_time`+1 WHERE `id`={$_GET['id']}";
mysqli_query($link, $query);
$art_title = $rs['title'];
$art_time = $rs['publish_time'];
$art_info = $rs['info'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= $art_title ?></title>
    <?php load_cssFile('article') ?>
    <style type="text/css">
        .single_entry {
            margin-top: 30px;
        }
    </style>
</head>

<body class="single2">

    <?php load_header()
    // 页首栏 
    ?>

    <div id="wrapper">
        <!-- 页面内容 -->
        <div id="container">
            <div id="content">
                <div class="post" id="post-19563" style="border-right: solid 1px #000000; min-height: 1500px;
                    margin-top: 10px;">
                    <?php load_path(array('主页' => LOC . 'index.php', '新闻' => LOC . 'list.php', $art_title => '#')) ?>
                    <div class="single_entry single2_entry">
                        <div class="entry fewcomment">
                            <div class="title_container">
                                <h2 class="title single_title">
                                    <span><?= $art_title ?></span>
                                    <!-- <span class="title_date">2014-02-06 12:28</span> -->
                                </h2>
                                <p class="single_info">
                                    发布时间：<?= $art_time ?>
                                    <span style="user-select: none">&nbsp;&nbsp;&nbsp;</span>
                                    <?= $art_info ?>
                                </p>
                            </div>
                            <div class="div-content">
                                <?php
                                    $contentFile = fopen(LOC.'../Data/news/'.$_GET['id'].'.txt', 'r');
                                    while(!feof($contentFile))
                                    {   // feof函数测试指针是否到了文件结束的位置。
                                        echo '<p>'.fgets($contentFile).'</p>'; // 输出当前的行
                                    }
                                ?>
                                <!-- <?=var_dump($rs);?> -->
                                <p class="pagepage"></p>

                                <!-- Content-文章底端 -->
                                <div id="BottomNavOver" style="height: 80px;">
                                    <div style="float: left; font-size: 12px;">
                                        <?php if ($rs['source']): ?>
                                            <a style="color: #666" href="<?= $rs['source'] ?>">文章来源</a>
                                        <?php endif ?>
                                    </div>
                                    <div style="float: right; font-size: 12px;">
                                        浏览次数：<?= $rs['view_time'] ?>
                                    </div>
                                    <div style="clear: both;">
                                    </div>
                                </div>
                            </div>
                            <div class="clear">
                            </div>
                            <div id="ctl00_ctl00_ContentPlaceHolder1_contentPlace_divRead">
                                <div style="text-align: left; width: 100%; border-bottom: solid 1px #e0e0e0; padding-bottom: 4px;
                                    color: Black; vertical-align: middle; font-weight: bold;">
                                    &nbsp;&nbsp;推荐文章
                                </div>
                                <ul class="read" style="list-style-type: none; margin-top: 10px; width: 780px;">
                                    <?php
                                    $rs_rec = getRet_SQL(mysqli_query($link, 'SELECT * FROM `news_data` WHERE `recommend`=1 ORDER BY `recommend_time` DESC'));
                                    if (count($rs_rec) > REC_SIZE)
                                        $recArticle = array_slice($rs_rec, 0, REC_SIZE);
                                    else
                                        $recArticle = $rs_rec;
                                    foreach ($recArticle as $v):
                                    ?>
                                    <li style="margin-left: -10px; margin-right: 16px; margin-top: 20px; height: 180px;">
                                        <a href="article.php?id=<?= $v['id'] ?>" target="_blank"><img src="<?= getNewsImg(LOC, $v['id']) ?>" style="width: 250px; height: 150px; margin-bottom: 0px;" />
                                            <span style="margin: 0px; padding: 0px; margin-top: -5px;"><?= $v['title'] ?></span>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="clear"></div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sidebar">
                <!-- 右侧 -->
                <div class="widget">
                    <div class="rightWidgetTitle">最近发布</div>
                    <ul id="ulHot">
                        <?php
                        $rs_new = getRet_SQL(mysqli_query($link, 'SELECT * FROM `news_data` ORDER BY `publish_time` DESC'));
                        if (count($rs_new) > SIDEBAR_SIZE)
                            $newArticle = array_slice($rs_new, 0, SIDEBAR_SIZE);
                        else
                            $newArticle = $rs_new;
                        foreach ($newArticle as $v):
                        ?>
                        <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
                            <div style="float:left;width:85px;height:55px; overflow:hidden;">
                                <a href="article.php?id=<?= $v['id'] ?>" target="_blank">
                                    <img src="<?= getNewsImg(LOC, $v['id']) ?>" width="83" title="<?= $v['title'] ?>" />
                                </a>
                            </div>
                            <div style="float:right;width:145px;height:52px; overflow:hidden;">
                                <a href="article.php?id=<?= $v['id'] ?>" target="_blank" title="<?= $v['title'] ?>">
                                    <?= cutStr($v['title'], 20) ?>
                                </a>
                            </div>
                        </li> 
                        <?php endforeach; ?> 
                    </ul>
                </div>

                <div class="widget portrait">
                    <!-- <div>
                        <div class="textwidget">
                            <a href="submit.php"><img src="<?= LOC ?>images/tg.jpg" alt="altText"></a><br><br>
                        </div>
                    </div> -->
                </div>


            </div>
            <div class="clear">
            </div>
        </div>
        <!-- 页面内容 -->
    </div>

    <?php load_footer()
    // 页尾栏 
    ?>

</body>

</html>