<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once '../Comm/function.php';
require_once 'load_resources.php';
preLoad(0);
$link = link_SQL();
const DISPLAY_NUM  = 8;     // 首页显示的新闻数量
const DETAIL_SIZE  = 100;   // 简介字数
const SIDEBAR_SIZE = 6;     // 侧边栏显示数量
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>畜牧信息平台</title>
    <?php load_cssFile() ?>
    <script type="text/javascript">
        function IFocuse(th, o) {
            var t = $(th);
            var c = t.attr("class");
            if (o) {
                t.removeClass(c).addClass(c + "-over");
            } else {
                t.removeClass(c).addClass(c.replace("-over", ""));
            }
        }
    </script>
    <style type="text/css">
        #wrapper {
            background-color: #ffffff;
        }

        .single_entry {
            margin-top: 30px;
        }
    </style>
</head>

<body class="xh_body">

    <?php load_header()
    // 页首栏 
    ?>

    <div id="xh_wrapper">

        <input type="hidden" id="hdUrlFocus" />
        <div class="xh_h_show">
            <div class="xh_h_show_in">
                <div id="zSlider">
                    <div id="picshow">
                        <div id="picshow_img">
                            <ul>
                                <?php
                                $query = "SELECT * FROM `news_data` WHERE `recommend`=1 ORDER BY `publish_time` DESC";
                                $result = query_SQL($link, $query);
                                foreach (array_slice($result, 0, 4) as $recNews) :
                                ?>
                                    <li style="display: list-item;">
                                        <a href="<?= LOC . 'article.php?id=' . $recNews['id'] ?>" target="_blank">
                                            <img src="<?= getNewsImg(LOC, $recNews['id']) ?>" alt="<?= cutStr($recNews['title'], 10) ?>"> 
                                        </a> 
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div id="select_btn">
                        <ul>
                            <li class="current"></li>
                            <li class=""></li>
                            <li class=""></li>
                            <li class=""></li>
                        </ul>
                    </div>
                    <div class="focus-bg-title">
                        <!-- <div id="focus-left" class="arrow-left" onmouseover="IFocuse(this,true)" onmouseout="IFocuse(this,false)"></div> -->
                        <div id="focus-center" class="focus-title">
                            <div style="float:left;width:580px;padding-left:10px;font-size:18px;" id="focus-tl-s"></div>
                            <div style="float:right;width:200px;"></div>
                        </div>
                        <!-- <div id="focus-right" class="arrow-right" onmouseover="IFocuse(this,true)" onmouseout="IFocuse(this,false)"></div> -->
                    </div>
                </div>
                <div id="picshow_right">
                    <div class="rightWidgetTitle">推荐新闻</div>
                    <ul id="ulHot">
                        <?php
                        $rs_rec = getRet_SQL(mysqli_query($link, 'SELECT * FROM `news_data` WHERE `recommend`=1 ORDER BY `publish_time` DESC'));
                        $newsRec = array_slice($rs_rec, 4, 4);
                        foreach ($newsRec as $v) :
                        ?>
                            <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
                                <div style="float:left;width:85px;height:55px; overflow:hidden;">
                                    <a href="detail.php?id=<?= $v['id'] ?>" target="_blank">
                                        <img src="<?= getNewsImg(LOC, $v['id']) ?>" width="83 !important" height="83 !important" title="<?= $v['title'] ?>" style="padding-left:4px" />
                                    </a>
                                </div>
                                <div style="float:right;width:175px;height:52px; overflow:hidden;">
                                    <a href="detail.php?id=<?= $v['id'] ?>" target="_blank" title="<?= $v['title'] ?>">
                                        <?= cutStr($v['title'], 20) ?>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div id="xh_container">
            <a name="new"></a>
            <div id="xh_content" style="padding-right:10px;">
                <div class="xh_area_h_3">
                    <div class="xh_area_title">
                        <span class="r">
                            <?php foreach (siteMap() as $kA => $arr) : if ($kA != '关于我们') : ?>
                                    <!-- <a href='<?= $arr['self'] ?>'><?= $kA ?></a> -->
                                    <?php foreach ($arr as $k => $v) : if ($k != 'self') : ?>
                                            <a href='<?= $v ?>'><?= $k ?></a>
                            <?php endif;
                                    endforeach;
                                endif;
                            endforeach; ?>
                        </span>
                    </div>
                    <br>

                    <!-- 最新新闻 -->
                    <?php
                    $query = "SELECT * FROM `news_data` ORDER BY `publish_time` DESC";
                    $rs = query_SQL($link, $query);
                    foreach (array_slice($rs, 0, DISPLAY_NUM) as $news) :
                        if (!$news['type']) continue;
                        switch ($news['type']) {
                            case '1':
                                $category = '禽业新闻';
                                break;
                            case '2':
                                $category = '猪业新闻';
                                break;
                            case '3':
                                $category = '饲料新闻';
                                break;
                            default:
                                $category = '新闻';
                                break;
                        }
                    ?>
                        <!-- <?= $news['id'] ?> -->
                        <div class="xh_post_h_3 ofh">
                            <div class="xh_265x265">
                                <a target="_blank" href="article.php?id=<?= $news['id'] ?>" title="<?= $news['title'] ?>">
                                    <img src="<?= getNewsImg(LOC, $news['id']) ?>" alt="<?= $news['title'] ?>" height="240" width="400"></a>
                            </div>
                            <div class="r ofh">
                                <h2 class="xh_post_h_3_title ofh">
                                    <a target="_blank" href="article.php?id=<?= $news['id'] ?>" title="<?= $news['title'] ?>"><?= cutStr($news['title'], 24) ?></a>
                                </h2>
                                <span class="time"><?= $news['publish_time'] ?></span>
                                <div class="xh_post_h_3_entry ofh">
                                    <?= mb_readFile(LOC . '../Data/news/' . $news['id'] . '.txt', DETAIL_SIZE) ?>
                                </div>
                                <div class="b">
                                    <span class="bartext"></span></span> <span title="<?= $news['view_time'] ?>人浏览" class="xh_views"><?= $news['view_time'] ?></span>
                                </div>
                            </div>
                            <span class="cat">
                                <a href="list.php?listID=<?= $news['type'] ?>" title="查看<?= $category ?>中的全部文章" rel="category tag">
                                    <?= $category ?> </a>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="pagination">
                    <div class='wp-pagenavi'>
                        <a href="list.php" style='float:right;'>查看更多新闻</a>
                    </div>
                </div>
            </div>

            <!-- 侧边栏 - 最新供需信息  -->
            <div id="xh_sidebar">
                <div class="widget">
                    <div class="rightWidgetTitle">供需信息</div>
                    <ul id="ulHot">
                        <?php
                        $rs_new = getRet_SQL(mysqli_query($link, 'SELECT * FROM `sup_and_dem` ORDER BY `publish_time` DESC'));
                        if (count($rs_new) > SIDEBAR_SIZE)
                            $newArticle = array_slice($rs_new, 0, SIDEBAR_SIZE);
                        else
                            $newArticle = $rs_new;
                        foreach ($newArticle as $v) :
                        ?>
                            <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
                                <div style="float:left;width:85px;height:55px; overflow:hidden;">
                                    <a href="detail.php?id=<?= $v['id'] ?>" target="_blank">
                                        <img src="<?= getInfoImg($link, LOC, $v['id']) ?>" width="83" title="<?= $v['name'] ?>" />
                                    </a>
                                </div>
                                <div style="float:right;width:145px;height:52px; overflow:hidden;">
                                    <a href="detail.php?id=<?= $v['id'] ?>" target="_blank" title="<?= $v['name'] ?>">
                                        <?= !$v['type'] ? "<span class='sup'>供应</span>" : "<span class='dem'>需求</span>" ?>
                                        <?= cutStr($v['name'], 20) ?>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="widget links">
                    <!-- <h3>
                        友情链接</h3> -->
                    <div class="rightWidgetTitle">相关网站</div>
                    <ul>
                        <li><a href='http://www.guojixumu.com/' target='_blank'>国际畜牧网</a> </li>
                        <li><a href='https://www.caaa.cn/' target='_blank'>中国畜牧业协会</a> </li>
                        <li><a href='https://www.jbzyw.com/' target='_blank'>鸡病专业网</a> </li>
                        <li><a href='http://www.cvma.org.cn/' target='_blank'>中国兽医协会</a> </li>
                    </ul>
                    <div class="clear">
                    </div>
                </div>
            </div>
            <div class="clear">
            </div>
        </div>
        <div class="boxBor" onclick="IBoxBor()" style="cursor:pointer;"></div>
        <input type="hidden" id="hdBoxbor" />
        <script type="text/javascript">
            $("#next-page").hover(function() {
                $(this).attr("src", "./style/images/next02.png");
            }, function() {
                $(this).attr("src", "./style/images/next01.png");
            });
            $("#last-page").hover(function() {
                $(this).attr("src", "./style/images/last02.png");
            }, function() {
                $(this).attr("src", "./style/images/last01.png");
            });

            $(function() {
                var imgHoverSetTimeOut = null;
                $('.xh_265x265 img').hover(function() {
                    var oPosition = $(this).offset();
                    var oThis = $(this);
                    $(".boxBor").css({
                        left: oPosition.left,
                        top: oPosition.top,
                        width: oThis.width(),
                        height: oThis.height()
                    });
                    $(".boxBor").show();
                    var urlText = $(this).parent().attr("href");
                    $("#hdBoxbor").val(urlText);
                }, function() {
                    imgHoverSetTimeOut = setTimeout(function() {
                        $(".boxBor").hide();
                    }, 500);
                });
                $(".boxBor").hover(
                    function() {
                        clearTimeout(imgHoverSetTimeOut);
                    },
                    function() {
                        $(".boxBor").hide();
                    }
                );
            });

            function IBoxBor() {
                window.open($("#hdBoxbor").val());
            }

            function goanewurl() {
                window.open($("#hdUrlFocus").val());
            }
        </script>

    </div>


    <?php
    load_siteMap();
    load_footer();
    // 网站地图、页尾栏 
    ?>

</body>

</html>