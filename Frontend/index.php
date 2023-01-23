<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once '../Comm/function.php';
require_once 'load_resources.php';
preLoad(0);
$link = link_SQL();
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>主页</title>
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
                                <li style="display: list-item;"><a href="/life/361.html" target="_blank">
                                        <img src="./images/1-140206162449A0.jpg" alt="骑行40000公里 英国胶片摄影师的骑游之旅"></a></li>
                                <li style="display: list-item;"><a href="/life/394.html" target="_blank">
                                        <img src="./images/354.jpg" alt="骑看世界：春节骑行海南岛 畅游冬日骑行天堂"></a></li>
                                <li style="display: list-item;"><a href="/life/364.html" target="_blank">
                                        <img src="./images/1-1402061A315209.jpg" alt="隆猫西班牙自行车之旅-Mallorca岛梦幻旅程（上）"></a>
                                </li>
                                <li style="display: list-item;"><a href="/gear/rs/320.html" target="_blank">
                                        <img src="./images/1-1402061A155W4.jpg" alt="#CES展上的新玩意# Casio 发布 STB-1000 智能手表 可同步骑行速"></a></li>



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
                        <div id="focus-left" class="arrow-left" onmouseover="IFocuse(this,true)" onmouseout="IFocuse(this,false)"></div>
                        <div id="focus-center" class="focus-title">
                            <div style="float:left;width:580px;padding-left:10px;font-size:18px;" id="focus-tl-s"></div>
                            <div style="float:right;width:200px;"></div>
                        </div>
                        <div id="focus-right" class="arrow-right"></div>
                    </div>
                </div>
                <div id="picshow_right" style="background-color: #123;">

                    <!-- <a href="/life/416.html" target="_blank">
                        <img src="./images/1-140206160415Y6.jpg" alt="COACH再度携手王力宏 踩单车演" width="255px" height="420px"></a>

                    <div id="picshow_right_cover" onclick="goanewurl()" 
                    style="cursor:pointer;position:absolute;top:495px;font-size:14px;width:213px;height:45px;line-height:45px;padding-left:42px;color:#ffffff;zoom:1;background-image:url(./images/focus-left-bg.png); background-repeat:no-repeat; background-color:#01A1ED;">
                    </div> -->
                </div>
            </div>
        </div>
        <div id="xh_container">
            <a name="new"></a>
            <div id="xh_content" style="padding-right:10px;">
                <div class="xh_area_h_3">
                    <div class="xh_area_title">
                        <span class="r">
                        <?php foreach (siteMap() as $kA => $arr): if ($kA != '关于我们'):?>
                            <!-- <a href='<?= $arr['self'] ?>'><?= $kA ?></a> -->
                            <?php foreach ($arr as $k => $v): if ($k != 'self'): ?>
                            <a href='<?= $v ?>'><?= $k ?></a>
                        <?php endif; endforeach; endif; endforeach; ?>
                        </span>
                    </div>
                    <br>

                    <?php
                    $query = "SELECT * FROM `news_data` ORDER BY `publish_time` DESC";
                    $rs = query_SQL($link, $query);
                    
                    ?>
                    <div class="xh_post_h_3 ofh">
                        <div class="xh_265x265">
                            <a target="_blank" href="/life/392.html" title="骑看世界：三个女孩的欧洲骑行之路">
                                <img src="./images/352.jpg" alt="骑看世界：三个女孩的欧洲骑行之路" height="240" width="400"></a>
                        </div>
                        <div class="r ofh">
                            <h2 class="xh_post_h_3_title ofh">
                                <a target="_blank" href="/life/392.html" title="骑看世界：三个女孩的欧洲骑行之路">骑看世界：三个女孩的欧洲骑行之路</a>
                            </h2>
                            <span class="time">2014年02月06日 17:26</span>
                            <div class="xh_post_h_3_entry ofh">
                                经历了欧洲漫长的冬季，卡佳，凯茜和米歇尔三个女孩决定开始他们本年度第一次roadtrip，于是他们脱离了自己正常的生活模式，开始进入自行车模式开始他们的骑行之旅。她们的第一站是列支敦士登的Ell...
                            </div>
                            <div class="b">
                                <span title="2人赞" class="xh_love"><span class="textcontainer"><span>2</span></span>
                                    <span class="bartext"></span></span> <span title="119人浏览" class="xh_views">119</span>
                            </div>
                        </div>
                        <span class="cat"><a href="/life/" title="查看 单车生活 中的全部文章" rel="category tag">单车生活</a></span>
                    </div>
                    


                </div>
                <div id="pagination">
                    <div class='wp-pagenavi'> <a href="/lookbike/" style='float:right;'><img src='/blog4./style/images/next01.png' id='next-page'></a></div>
                </div>
            </div>
            <div id="xh_sidebar">

                <div class="widget">

                    <div style="background: url('./style/img/hots_bg.png') no-repeat scroll 0 0 transparent;width:250px;height:52px;margin-bottom:15px;">
                    </div>
                    <ul id="ulHot">

                        <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
                            <div style="float:left;width:85px;height:55px; overflow:hidden;"><a href="/lookbike/roadbicycle/110.html" target="_blank"><img src="./images/68.png" width="83" title="环西冠军克里斯霍纳的个性化定制座驾 Trek Madone公路车" /></a></div>
                            <div style="float:right;width:145px;height:52px; overflow:hidden;"><a href="/lookbike/roadbicycle/110.html" target="_blank" title="环西冠军克里斯霍纳的个性化定制座驾 Trek Madone公路车">环西冠军克里斯霍纳的个性化定制座驾 Trek Ma</a></div>
                        </li>
                        <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
                            <div style="float:left;width:85px;height:55px; overflow:hidden;"><a href="/lookbike/small/184.html" target="_blank"><img src="./images/146.jpg" width="83" title="英式折叠车Brompton Junction 上海旗舰店" /></a></div>
                            <div style="float:right;width:145px;height:52px; overflow:hidden;"><a href="/lookbike/small/184.html" target="_blank" title="英式折叠车Brompton Junction 上海旗舰店">英式折叠车Brompton Junction 上海旗舰店</a></div>
                        </li>
                        <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
                            <div style="float:left;width:85px;height:55px; overflow:hidden;"><a href="/life/368.html" target="_blank"><img src="./images/327.jpg" width="83" title="骑摆记：比利时车手Joris的尼泊尔野马河谷山地车之旅" /></a></div>
                            <div style="float:right;width:145px;height:52px; overflow:hidden;"><a href="/life/368.html" target="_blank" title="骑摆记：比利时车手Joris的尼泊尔野马河谷山地车之旅">骑摆记：比利时车手Joris的尼泊尔野马河谷山</a>
                            </div>
                        </li>
                        <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
                            <div style="float:left;width:85px;height:55px; overflow:hidden;"><a href="/life/378.html" target="_blank"><img src="./images/335.jpg" width="83" title="深圳设计师浩子和77的11天成都-稻城自虐骑行" /></a></div>
                            <div style="float:right;width:145px;height:52px; overflow:hidden;"><a href="/life/378.html" target="_blank" title="深圳设计师浩子和77的11天成都-稻城自虐骑行">深圳设计师浩子和77的11天成都-稻城自虐骑行</a></div>
                        </li>
                        <li style="border-bottom:dashed 1px #ccc;height:70px; margin-bottom:15px;">
                            <div style="float:left;width:85px;height:55px; overflow:hidden;"><a href="/news/398.html" target="_blank"><img src="./images/359.jpg" width="83" title="爱车出行新概念 YAKIMA与WHISPBAR将在中国自行车展同台亮相" /></a></div>
                            <div style="float:right;width:145px;height:52px; overflow:hidden;"><a href="/news/398.html" target="_blank" title="爱车出行新概念 YAKIMA与WHISPBAR将在中国自行车展同台亮相">爱车出行新概念
                                    YAKIMA与WHISPBAR将在中国自</a></div>
                        </li>

                    </ul>
                </div>

                <div class="widget portrait">
                    <div>
                        <div class="textwidget">
                            <a href="/tougao.html"><img src="./style/img/tg.jpg" alt="投稿"></a><br><br>
                        </div>
                    </div>
                </div>
                <div class="widget links">
                    <h3>
                        友情链接</h3>
                    <ul>
                        <li><a href='#' target='_blank'>链接1</a> </li>
                        <li><a href='#' target='_blank'>链接2</a> </li>
                        <li><a href='#' target='_blank'>链接3</a> </li>
                        <li><a href='#' target='_blank'>链接4</a> </li>
                        <li><a href='#' target='_blank'>链接5</a> </li>
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