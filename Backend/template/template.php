<!DOCTYPE html>
<?php
// 注意手动修改这里的地址和perLoad的层数
// 其他地方的位置、地址等均可动态加载
require_once '../load_resources.php'; 
preLoad(1); //初始化&登录检查
?>
<html>

<head>
    <meta charset="utf-8">
    <title>主页</title>
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
                    '管理面板' => '',
                    '测试' => 'www.baidu.com'
                )) // 目录 ?>
                <!-- Page Body: 页面的主要内容 -->
                <div class="page-body">
                    <div style="text-align:center; line-height:1000%; font-size:24px;">
                        XX种质资源数据管理系统<br>
                        <p style="color:#f00;">XX种质资源数据管理系统</p>
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