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
$msgArr = array(
    10 => '请填写新闻来源',
    60 => '文件格式错误，请重新选择文件',
    61 => '文件过大，请重新选择文件',       // 上传的文件超过了php.ini中upload_max_filesize选项限制的值
    62 => '文件过大，请重新选择文件',       // 上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值
    63 => '文件上传不成功，请重新上传',     // 文件只有部分被上传
    64 => '文件上传不成功，请重新上传',     // 移动临时文件失败
    65 => '文件格式错误，请重新选择文件',   // 同60，函数检查出错误
    66 => '文件格式错误，请重新选择文件'    // 文件格式与后缀名不符之类的问题，总之就是GD2库不认图片是图片
);
if (isset($_GET["retVal"]))
    $msg = $msgArr[$_GET["retVal"]];
else
    $msg = '';
?>
<html>

<head>
    <meta charset="utf-8">
    <title>发布新闻</title>
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
                    '内容管理' => '',
                    '新闻列表' => 'news_list.php',
                    '发布新闻' => ''
                )) // 目录 
                ?>
                <!-- Page Body: 页面的主体 -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <!-- Content: 页面内容 -->
                                <div class="widget-header bordered-bottom bordered-blue">
                                    <span class="widget-caption">发布新闻</span>
                                </div>
                                <div class="widget-body">
                                    <div class="errMsg red"><?= $msg ?></div>
                                    <div id="horizontal-form">
                                        <form class="form-horizontal" role="form" action="add_news_proc.php" method="post" id="news_form" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="title" class="col-sm-2 control-label no-padding-right">新闻标题</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="title" placeholder="新闻标题" name="title" required="" type="text">
                                                </div>
                                                <p class="help-block col-sm-4 red">必填</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="username" class="col-sm-2 control-label no-padding-right">正文</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" id="content" form="news_form" rows="10" placeholder="新闻正文" name="content" required=""></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="info" class="col-sm-2 control-label no-padding-right">发布相关信息</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="info" placeholder="" name="info" type="text">
                                                </div>
                                                <p class="help-block col-sm-4">填写新闻来源等信息</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="type" class="col-sm-2 control-label no-padding-right">新闻类型</label>
                                                <div class="col-sm-6">
                                                    <select name="type" style="width: 100%;">
                                                        <option selected="selected" value="0">请选择新闻类型</option>
                                                        <option value="1">禽业</option>
                                                        <option value="2">猪业</option>
                                                        <option value="3">饲料</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="img" class="col-sm-2 control-label no-padding-right">宣传图</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="img" name="img" type="file">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="is_reprint" class="col-sm-2 control-label no-padding-right">
                                                    是否为转载新闻
                                                </label>
                                                <div class="col-xs-4" style="width: 100px;">
                                                    <div style="padding-top: 7px;">
                                                        <input class="checkbox-slider slider-icon yesno" name="is_reprint"
                                                            checked="checked" type="checkbox">
                                                        <span class="text"></span>
                                                    </div>
                                                </div>
                                                <p class="help-block col-sm-4">设置则新闻页面会标识源地址</p>
                                            </div>
                                            <div class="form-group">
                                                <label for="source" class="col-sm-2 control-label no-padding-right">转载源</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" id="source" placeholder="输入源网址" name="source" type="test">
                                                </div>
                                                <p class="help-block col-sm-4">选择转载时<span class="red">必填</span></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="recommend" class="col-sm-2 control-label no-padding-right">
                                                    是否推荐新闻
                                                </label>
                                                <div class="col-xs-4" style="width: 100px;">
                                                    <div style="padding-top: 7px;">
                                                        <input class="checkbox-slider slider-icon yesno" name="recommend" type="checkbox">
                                                        <span class="text"></span>
                                                    </div>
                                                </div>
                                                <p class="help-block col-sm-4">前台网站会显示最新推荐的几条新闻</p>
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

</html>                                                                                                         