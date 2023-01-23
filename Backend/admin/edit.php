<!DOCTYPE html>
<?php
// 注意手动修改这里的地址和perLoad的层数
// 其他地方的位置、地址等均可动态加载
require_once '../load_resources.php';
preLoad(1); // 初始化&登录检查
if (!PER_ADM && !isset($_GET["self"]))
{   // 权限不够，也不是编辑自己的资料
    popWarn('权限不足！');
    jumpToURL(LOC.'index.php');
}
$editSelf = isset($_GET["self"])||$_GET["id"]==ID_ADM ? true : false;
if (!isset($_GET["id"]) && !$editSelf)
    jumpToURL('adm_list.php');
$link = link_SQL();
$qID = $editSelf ? ID_ADM : $_GET["id"];
$query = "SELECT * FROM `admin_account` WHERE id={$qID}";
$rs = getRet_SQL(mysqli_query($link, $query));
// var_dump($rs);
// die();
$msgArr = array(
    30 => '手机号重复，请重新输入',
    31 => '手机号格式错误，请重新输入',
    40 => '邮箱重复，请重新输入',
    41 => '邮箱格式错误，请重新输入',
    5  => '数据库操作失败，请再次尝试',
    60 => '头像文件格式错误，请重新选择头像文件',
    61 => '头像文件过大，请重新选择头像文件',       // 上传的文件超过了php.ini中upload_max_filesize选项限制的值
    62 => '头像文件过大，请重新选择头像文件',       // 上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值
    63 => '头像文件上传不成功，请重新上传',         // 文件只有部分被上传
    64 => '头像文件上传不成功，请重新上传',         // 移动临时文件失败
    65 => '头像文件格式错误，请重新选择头像文件',   // 同60，函数检查出错误
    66 => '头像文件格式错误，请重新选择头像文件'    // 文件格式与后缀名不符
);
if (isset($_GET["retVal"]))
    $msg = $msgArr[$_GET["retVal"]];
else
    $msg = '';
$bcArray = isset($_GET["id"]) ?
array(
    '管理面板' => LOC.'index.php',
    '管理员' => '',
    '管理员列表' => 'adm_list.php',
    '编辑' => '')
:
array(
    '管理面板' => LOC.'index.php',
    '管理员' => '',
    '编辑个人资料' => ''
);
?>
<html>

<head>
    <meta charset="utf-8">
    <title><?=isset($_GET["self"])?'编辑个人资料':'编辑管理员账号'?></title>
    <?php load_cssFile()
    // 加载css文件
    ?>
    <style>
        .form-data {
            padding-top: 7px;
            padding-bottom: 7px;
        }
        .errMsg {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            line-height: 200%;
            font-size: 17px;
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
                <?php load_breadcrumb($bcArray) // 目录
                ?>
                <!-- Page Body: 页面的主体 -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <!-- Content: 页面内容 -->
                                <div class="widget-header bordered-bottom bordered-blue">
                                    <span class="widget-caption"><?=isset($_GET["self"])?'编辑个人资料':'编辑账号'?></span>
                                </div>
                                <div class="widget-body">
                                    <div class="errMsg red"><?= $msg ?></div>
                                    <div id="horizontal-form">
                                        <form class="form-horizontal" role="form" action="edit_proc.php?self=<?=isset($_GET["self"])? 1 : 0 ?>" method="post" enctype="multipart/form-data">
                                            <input type="text" name="id" value="<?= $qID ?>" style="display: none">
                                            <div class="form-group">
                                                <label for="userid" class="col-sm-2 control-label no-padding-right">用户ID</label>
                                                <div class="col-sm-6 form-data">
                                                    <span style="user-select: none;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                    <?= $rs['id'] ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="username" class="col-sm-2 control-label no-padding-right">用户名</label>
                                                <div class="col-sm-6 form-data">
                                                    <span style="user-select: none;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                    <?= $rs['name'].($editSelf&&!@$_GET["self"]?'<span class="red">&nbsp;(当前用户)</span>':'') ?>
                                                </div>
                                                <!-- <div class="col-sm-6">
                                                    <input class="form-control" id="username" placeholder="输入用户名" name="username" required="" value="<?= $rs['name'] ?>" type="text">
                                                </div>
                                                <p class="help-block col-sm-4 red">必填</p> -->
                                            </div>
                                            <div class="form-group" <?=(isset($_GET["self"])&&!PER_ADM)||$rs['permission']?'style="display: none"':''?>>
                                                <label for="group_id" class="col-sm-2 control-label no-padding-right">用户权限</label>
                                                <div class="col-sm-6">
                                                    <select name="permission" style="width: 100%;">
                                                        <option <?= $rs['permission'] ? '':'selected="selected"' ?> value="0">普通管理员</option>
                                                        <option <?= $rs['permission'] ? 'selected="selected"':'' ?> value="1">超级管理员</option>
                                                    </select>
                                                </div>
                                                <p class="help-block col-sm-4">超级管理员可以操作管理员账号</p>
                                            </div>
                                            <?php if (!$rs['permission']): ?>
                                            <div class="form-group">
                                                <label for="rst_pwd" class="col-sm-2 control-label no-padding-right">
                                                    重置密码
                                                </label>
                                                <div class="col-xs-4" style="width: 100px;">
                                                    <div style="padding-top: 7px;">
                                                        <input class="checkbox-slider slider-icon yesno" name="rst_pwd" type="checkbox">
                                                        <span class="text"></span>
                                                    </div>
                                                </div>
                                                <p class="help-block col-sm-4">
                                                    选中则<?= $editSelf ? '<span class="red">保存后</span>' : '该账号<span class="red">下次登录时</span>' ?>会被引导至设置密码的页面</p>
                                            </div>
                                            <?php endif; ?>
                                            <?php if ($qID != ID_ADM): echo '<div style="display: none;">'; endif;?>
                                            <div class="form-group">
                                                <label for="phone" class="col-sm-2 control-label no-padding-right">手机号</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="phone" placeholder="输入手机号" name="phone" value="<?= $rs['phone'] ?>" type="text">
                                                </div>
                                                <p class="help-block col-sm-4">选填，用于找回密码</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label no-padding-right">邮箱</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="email" placeholder="输入邮箱" name="email" value="<?= $rs['email'] ?>" type="text">
                                                </div>
                                                <p class="help-block col-sm-4">选填，用于找回密码</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="avatar" class="col-sm-2 control-label no-padding-right">头像</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="avatar" name="avatar" type="file">
                                                </div>
                                            </div>
                                            <?php if ($qID != ID_ADM): echo '</div>'; endif;?>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-default" name='submit'>保存</button>
                                                </div>
                                            </div>
                                        </form>
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