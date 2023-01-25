<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1);
if (!isset($_GET['id']) && !isLoggedIn())
    jumpToURL('../index.php');
elseif (isset($_GET['id']))
    $id = $_GET['id'];
else
    $id = $_COOKIE['userID'];

$link = link_SQL();
$user = getRet_SQL(mysqli_query($link, "SELECT * FROM `user_account` WHERE `id`={$id}"));
$isSelf = $id == $_COOKIE['userID'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= $isSelf ? '个人空间' : $user['name'] . '的个人空间' ?></title>
    <?php load_cssFile() ?>
    <link rel="stylesheet" href="<?= LOC ?>style/self.css" type="text/css" />
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

    <div id="wrapper">
        <!-- 页面内容 -->
        <div class="single_entry page_entry">
            <div class="entry user-space">
                <div class="user-info">
                    <div class="user-info-sub" style="float: left">
                        <img class="user-avatar" src="<?= getAvatar(LOC, $id) ?>" alt="<?= $user['name'] ?>">
                        <div class="user-name"><?= $user['name'] ?></div>
                    </div>
                    <?php if ($isSelf) : ?>
                        <a class="edit-info" href="edit_info.php">注销账号</a>
                        <span class="edit-info" style="user-select: none;">&nbsp;&nbsp;&nbsp;</span>
                        <a class="edit-info" href="edit_info.php">编辑个人信息</a>
                    <?php endif; ?>
                </div>
                <div class="user-publish">
                    <h2>发布的信息</h2>
                    <?php
                    $query = "SELECT * FROM `sup_and_dem` WHERE `user_id`='{$id}'";
                    // echo $query;
                    $rs = getRet_SQL(mysqli_query($link, $query));
                    // var_dump($rs);
                    foreach ($rs as $v) :
                    ?>
                        <a class="publish-info" href="../supdem/detail.php?id=<?= $v['id'] ?>">
                            <span class="<?= !$v['type'] ? "sup" : "dem" ?>">
                                <?= !$v['type'] ? "供应" : "需求" ?>&nbsp;
                            </span>
                            <?= $v['name']?>
                        <br/> </a>
                    <?php endforeach ?>
                </div>
                <div class="clear"></div>
            </div>
            <hr>
        </div>
        <!-- 页面内容 -->
    </div>

    <?php load_footer()
    // 页尾栏 
    ?>

</body>

</html>