<!DOCTYPE html>
<!-- 
    To do:
    - 选做：错误返回时自动填充
-->
<?php
// 注意手动修改这里的地址和perLoad的层数
// 其他地方的位置、地址等均可动态加载
require_once '../load_resources.php';
preLoad(1); //初始化&登录检查
if (!PER_ADM)
{   // 权限不够
    popWarn('权限不足！');
    jumpToURL(LOC.'index.php');
}
$msgArr = array(
    1  => '用户名重复，请重新输入',
    20 => '没有输入密码',
    21 => '密码两次填写不一致',
    30 => '手机号重复，请重新输入',
    31 => '手机号格式错误，请重新输入',
    40 => '邮箱重复，请重新输入',
    41 => '邮箱格式错误，请重新输入',
    5  => '数据库操作失败，请再次尝试',
);
if (isset($_GET["retVal"]))
    $msg = $msgArr[$_GET["retVal"]];
else
    $msg = '';
?>
<html>

<head>
    <meta charset="utf-8">
    <title>新增管理员账号</title>
    <?php load_cssFile()
    // 加载css文件 
    ?>
    <style>
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
                <?php load_breadcrumb(array(
                    '管理面板' => LOC.'index.php',
                    '管理员' => '',
                    '管理员列表' => 'adm_list.php',
                    '新增管理员' => ''
                )) // 目录 
                ?>
                <!-- Page Body: 页面的主体 -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <!-- Content: 页面内容 -->
                                <div class="widget-header bordered-bottom bordered-blue">
                                    <span class="widget-caption">新增管理员账号</span>
                                </div>
                                <div class="widget-body">
                                    <div class="errMsg red"><?= $msg ?></div>
                                    <div id="horizontal-form">
                                        <form class="form-horizontal" role="form" action="add_proc.php" method="post">
                                            <div class="form-group">
                                                <label for="username" class="col-sm-2 control-label no-padding-right">用户名</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="username" placeholder="输入用户名" name="username" required="" type="text">
                                                </div>
                                                <p class="help-block col-sm-4 red">必填</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="group_id" class="col-sm-2 control-label no-padding-right">用户权限</label>
                                                <div class="col-sm-6">
                                                    <select name="permission" style="width: 100%;">
                                                        <option selected="selected" value="0">普通管理员</option>
                                                        <option value="1">超级管理员</option>
                                                    </select>
                                                </div>
                                                <p class="help-block col-sm-4">超级管理员可以操作管理员账号</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="set_pwd" class="col-sm-2 control-label no-padding-right">
                                                    设置密码
                                                </label>
                                                <div class="col-xs-4" style="width: 100px;">
                                                    <div style="padding-top: 7px;">
                                                        <input class="checkbox-slider slider-icon yesno" name="set_pwd"
                                                            checked="checked" type="checkbox">
                                                        <span class="text"></span>
                                                    </div>
                                                </div>
                                                <p class="help-block col-sm-4">不设置则初次登录时会被引导至设置密码的页面</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd" class="col-sm-2 control-label no-padding-right">密码</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="pwd" placeholder="输入密码" name="pwd" type="password">
                                                </div>
                                                <p class="help-block col-sm-4">当选择设置密码时<span class="red">必填</span></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="pwdValid" class="col-sm-2 control-label no-padding-right">再次输入密码</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="pwdValid" placeholder="再次输入密码" name="pwdValid" type="password">
                                                </div>
                                                <p class="help-block col-sm-4">当选择设置密码时<span class="red">必填</span></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone" class="col-sm-2 control-label no-padding-right">手机号</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="phone" placeholder="输入手机号" name="phone" type="text">
                                                </div>
                                                <p class="help-block col-sm-4">选填，用于找回密码</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label no-padding-right">邮箱</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="email" placeholder="输入邮箱" name="email" type="text">
                                                </div>
                                                <p class="help-block col-sm-4">选填，用于找回密码</p>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-default" name='submit'>保存</button>
                                                </div>                                                
                                            </div>
                                        </form>
                                        <div style="padding-bottom: 12px"></div>
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