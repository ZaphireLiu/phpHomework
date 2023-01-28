<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
require_once '../load_resources.php';
require_once '../../Comm/function.php';
preLoad(1);
$link = link_SQL();
popWarn('Here');
if (!isset($_GET['id']) || !isLoggedIn())
    jumpToURL('list.php');
$query = "SELECT * FROM `sup_and_dem` WHERE `id`={$_GET['id']}";
$rs = getRet_SQL(mysqli_query($link, $query));
if (!$rs || $rs['user_id'] != $_COOKIE['userID'])
    jumpToURL('list.php');
$query = "DELETE FROM `sup_and_dem` WHERE `id`={$_GET['id']}";
$result = mysqli_query($link, $query);
if (!$result)
    popWarn('操作失败！请重试或联系管理员');
else
{
    unlink(LOC."../Data/supdem/{$_GET['id']}.txt");
    popWarn('操作成功！');
}
jumpToURL(LOC.'user/space.php');
mysqli_close($link);
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>删除</title>
    <?php load_cssFile() ?>
    <link rel="stylesheet" href="<?= LOC ?>style/basic-grey.css" type="text/css" />
    <style type="text/css">
        #wrapper {
            background-color: #ffffff;
        }

        .single_entry {
            margin-top: 30px;
        }
    </style>
</head>

<body class="single2">

    <?php load_header()
    // 页首栏 
    ?>

    <!-- Basic Scripts -->
    <script src="style/bootstrap.js"></script>
    <!-- Beyond Scripts -->
    <script src="style/beyond.js"></script>

</body>

</html>