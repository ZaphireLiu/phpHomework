<!DOCTYPE html>
<!-- 
    To do:
    - 错误返回自动填充
    - ! 返回机制
-->
<?php
/**
 * 其实add和edit的逻辑几乎一样来着。。。
 * 但是切换逻辑太麻烦了干脆赋值一份
 */
// 注意手动修改这里的地址和perLoad的层数
// 其他地方的位置、地址等均可动态加载
require_once '../load_resources.php';
require_once '../../Comm/function.php';
preLoad(1); //初始化&登录检查
$link = link_SQL();
// 检验输入 ------ 提交按钮
if (!isset($_POST['submit']))
    // ——非正常到达页面
    jumpToURL('edit_news.php', array('retVal' => 0));
// 检验输入 ------ 来源按钮
if (isset($_POST['is_reprint']))
    if (!isset($_POST['source']) || !@$_POST['source'])
    // ——没填来源
    jumpToURL('edit_news.php', array('retVal' => 10));
    
$id = $_POST['id'];
// 检验source
if (!isset($_POST['source']) || !@$_POST['source'])
    $source = '';
else
    $source = $_POST['source'];
$query = "UPDATE `news_data` SET `title`='{$_POST['title']}', `info`='{$_POST['info']}', `type`='{$_POST['type']}', `source`='{$source}' WHERE `id`={$id}";
$rs = mysqli_query($link, $query);
// 检验输入 ------ 推荐新闻
if (isset($_POST['recommend']))
{
    $query = "UPDATE `news_data` SET `recommend`=1, `recommend_time`=NOW() WHERE `id`={$id}";
    $rsRec = mysqli_query($link, $query);
}
else
    $rsRec = 1;
mysqli_close($link);
// 保存正文
$file = fopen(LOC.'../Data/news/'.(string)$id.'.txt', 'w');
fclose($file);
$content = $_POST['content'];
// 将多行文字拆开
$contArr = array();
preg_match_all('?(.*)?', $content, $contArr);
file_put_contents(LOC.'../Data/news/'.(string)$id.'.txt', $content);

// 图片处理
if (!$_FILES['img']['error'])
{
    $suffix = @array_pop(explode('.', $_FILES['img']['name']));
    $sufArr = array("bmp", "gif", "jpeg", "jpg", "png", "wbmp", "webp");
    if (!in_array($suffix, $sufArr))
        // 文件格式错误
        echo 'error: wrong type';
        // jumpToURL('edit_news.php', array('retVal' => 60, 'suf' => $suffix));
    $retVal = saveResizedImg('img', $id, LOC.'../Data/newsImg', 500, 300);
    if ($retVal)
    {
        $retVal = -1*$retVal + 63;
        jumpToURL('edit_news.php', array('retVal' => $retVal));
    }
}
elseif ($_FILES['img']['error'] != 4)
    // 上传错误 61/62/63
    jumpToURL('edit_news.php', array('retVal' => 60 + $_FILES['img']['error']));
else
    // 没有上传头像
    $retVal = 0;

if ($rs && $rsRec)
{
    $msg = '新闻编辑成功！';
    jumpToURL('news_list.php', array(), 2.5);
}
else
{
    popWarn('SQL错误！');
    jumpToURL('edit_news.php');
}
?>
<html>

<head>
    <meta charset="utf-8">
    <title>编辑新闻</title>
    <?php load_cssFile()
    // 加载css文件 
    ?>
</head>

<body>

    <?php 
    // 处理完毕，显示页面内容
    load_navBar();
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
                                    <span class="widget-caption">编辑新闻</span>
                                </div>
                                <div class="widget-body">
                                    <div style="padding-top: 30px; padding-bottom: 40px">
                                    <div style="text-align:center; line-height:1000%; font-size:24px;">
                                        <?= $msg ?>
                                        <!-- <?= var_dump($contArr[0]) ?> -->
                                        <!-- <?= LOC.'../Data/news/'.(string)$id.'.txt' ?> -->
                                    </div>
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

    <?php load_jsFile()
    // 实现一些效果的js脚本文件 
    ?>

</body>

</html>