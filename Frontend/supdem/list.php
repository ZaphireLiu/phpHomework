<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
const SIDEBAR_SIZE = 5;     // 侧边栏显示新闻数量
const PAGE_SIZE    = 5;     // 每页显示的数量
const PAGE_RANGE   = 5;     // 下面页码的数量（奇数）
const DETAIL_SIZE  = 80;    // 详情的字数
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1);
$page = isset($_GET['page']) ? @$_GET['page'] : 1;
if (!isset($_GET['listID']))
{
    $qStr = "";
    $url = "list.php?";
    $type = "";
}
else
{
    $qStr = "WHERE `type`={$_GET['listID']}";
    $url = "list.php?listID=".$_GET['listID'];
    switch (@$_GET['listID']) {
        case 0: $type = "供应信息"; break;
        case 1: $type = "需求信息"; break;
        default: $type = ""; break;
    }
}

$link = link_SQL();
$query = "SELECT * FROM `sup_and_dem` {$qStr} ORDER BY `publish_time` DESC";
$rs = getRet_SQL(mysqli_query($link, $query));
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= $type ?>列表</title>
    <?php load_cssFile('list') ?>
</head>

<body class="single2">

    <?php load_header()
    // 页首栏 
    ?>

    <div id="wrapper">
        <!-- 页面内容 -->
        <div id="xh_container">
            <div id="xh_content">

                <?php load_path(array(
                    "首页" => LOC."index.php",
                    "供需信息" => "list.php",
                    $type  => ""
                )) ?>
                <div class="clear"></div>
                <div class="xh_area_h_3" style="margin-top: 40px;">
                    <?php
                    $pageNum = ceil(count($rs)/PAGE_SIZE);
                    for ($i=($page-1)*PAGE_SIZE; $i<$page*PAGE_SIZE; $i++):
                        if ($i >= count($rs))
                            break;
                        $infoID = $rs[$i]['id'];
                    ?>
                    <div class="xh_post_h_3 ofh">
                        <div class="xh">
                            <a target="_blank" href="detail.php?id=<?= $infoID ?>" title="<?= $rs[$i]['name'] ?>">
                                <img src="<?= getInfoImg($link, LOC, $infoID) ?>" alt="<?= $rs[$i]['name'] ?>" height="240" width="400"></a>
                        </div>
                        <div class="r ofh">
                            <h2 class="xh_post_h_3_title ofh" style="height:60px;">
                                <a target="_blank" href="detail.php?id=<?= $infoID ?>" title="<?= $rs[$i]['name'] ?>">
                                    <?= !$rs[$i]['type'] ? "<span class='sup'>供应</span>" : "<span class='dem'>需求</span>" ?>
                                    <?= cutStr($rs[$i]['name'], 20) ?>
                                </a>
                            </h2>
                            <span class="time"><?= $rs[$i]['publish_time'] ?></span>
                            <div class="xh_post_h_3_entry ofh" style="color:#555;height:80px; overflow:hidden;">
                                <?= mb_readFile(LOC.'../Data/supdem/'.$infoID.'.txt', DETAIL_SIZE) ?>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
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
                            <span class="pages">共 <?= $pageNum ?> 页，<?= count($rs) ?>条</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="xh_sidebar">
                <!-- 右侧 -->
                <div class="widget">
                    <div class="rightWidgetTitle">最近发布</div>
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

                <div class="widget portrait">
                    <div>
                        <div class="textwidget">
                            <!-- <a href="/tougao.html"><img src="../style/img/tg.jpg" alt="鎶曠ǹ"></a><br><br> -->
                            </script>
                        </div>
                    </div>
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