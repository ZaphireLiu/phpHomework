<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once 'load_resources.php';
preLoad(0);
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>XX种质资源数据管理系统</title>
    <?php load_cssFile() ?>
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
            <div class="entry">
                <?php 
                for ($i=0; $i<200; $i++)
                {
                    echo $i.'<br/>';
                }
                ?>
                <div class="clear"></div>
            </div>
        </div>
        <!-- 页面内容 -->
    </div>

    <?php load_footer()
    // 页尾栏 
    ?>

</body>

</html>