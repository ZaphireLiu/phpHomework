<!DOCTYPE html>
<?php
require_once 'load_resources.php';
preLoad(0); // 初始化&登录检查
?>
<html>

<head>
    <meta charset="utf-8">
    <title>管理系统主页</title>
    <?php load_cssFile() 
    // 加载css文件 ?>

</head>

<body>

    <?php load_navBar(); 
    // 导航栏 ?>

    <div class="main-container container-fluid">
        <div class="page-container">
            <?php load_sideBar()
            // 侧边栏 ?>
            <div class="page-content">
                <?php load_breadcrumb(array(
                    '管理面板' => ''
                )) ?>
                <!-- Page Body: 页面的主要内容 -->
                <div class="page-body">
                    <div style="text-align:center; line-height:1000%; font-size:24px;">
                        畜牧信息 - 后台管理系统
                    </div>
                </div>
                <!-- /Page Body -->
            </div>
        </div>
    </div>

    <?php load_jsFile()  
    // 实现一些效果的js脚本文件 ?>

</body>

</html>