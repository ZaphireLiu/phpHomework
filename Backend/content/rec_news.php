<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1);
if (!isset($_GET['id']))
    jumpToURL('news_list.php');
$link = link_SQL();
$query = "SELECT `recommend` FROM `news_data` WHERE `id`={$_GET['id']}";
$rs = getRet_SQL(mysqli_query($link, $query));
if ($rs['recommend'])
{   // 取消推荐
    $qValRec = 0;
    $qValTime = 'NULL';
}
else
{   // 推荐新闻
    $qValRec = 1;
    $qValTime = 'NOW()';
}
$query = "UPDATE `news_data` SET `recommend`={$qValRec}, `recommend_time`={$qValTime} WHERE `id`={$_GET['id']}";
mysqli_query($link, $query);
mysqli_close($link);
jumpToURL('news_list.php');
?>