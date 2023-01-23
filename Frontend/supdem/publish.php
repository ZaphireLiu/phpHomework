<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1);
if (isset($_POST['btn'])) {
    unset($_POST['btn']);
    $link = link_SQL();
    // 是否为空的检验在form里
    $id = genID($link, 'sup_and_dem');
    $query = <<<EOF
    INSERT INTO `sup_and_dem` 
    (`id`, `name`, `contact`, `type`) 
    VALUES 
    ('{$id}', '{$_POST['name']}', '{$_POST['contact']}', {$_POST['type']});
    EOF;
    // echo $query;
    $rs = mysqli_query($link, $query);
    // 保存正文
    $file = fopen(LOC . '../Data/supdem/' . (string)$id . '.txt', 'w');
    fclose($file);
    file_put_contents(LOC . '../Data/supdem/' . (string)$id . '.txt', @$_POST['content']);
    // 图片处理
    // var_dump($_FILES);
    if (count(@$_FILES) > 0)
    {
        if (@$_FILES['img']['error'] == 0) {
            $suffix = @array_pop(explode('.', $_FILES['img']['name']));
            $sufArr = array("bmp", "gif", "jpeg", "jpg", "png", "wbmp", "webp");
            if (!in_array($suffix, $sufArr))
                // 文件格式错误
                // echo 'error: wrong type';
                jumpToURL('#', array('retVal' => 60, 'suf' => $suffix));
            $retVal = saveResizedImg('img', $id, LOC . '../Data/supdemImg', 500, 300);
            if ($retVal) {
                $retVal = -1 * $retVal + 63;
                jumpToURL('#', array('retVal' => $retVal));
            }
        } elseif (@$_FILES['img']['error'] != 4)
            // 上传错误 61/62/63
            jumpToURL('#', array('retVal' => 60 + $_FILES['img']['error']));
    }
}
if (isset($_GET['retVal']))
{
    $msg = '<span class="red">'.array(
        60 => '文件格式错误，请重新选择文件',
        61 => '文件过大，请重新选择文件',       // 上传的文件超过了php.ini中upload_max_filesize选项限制的值
        62 => '文件过大，请重新选择文件',       // 上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值
        63 => '文件上传不成功，请重新上传',     // 文件只有部分被上传
        64 => '文件上传不成功，请重新上传',     // 移动临时文件失败
        65 => '文件格式错误，请重新选择文件',   // 同60，函数检查出错误
        66 => '文件格式错误，请重新选择文件'    // 文件格式与后缀名不符之类的问题，总之就是GD2库不认图片是图片
    )[$_GET['retVal']].'</span>';
}
elseif (!isLoggedIn())
{
    $msg = '<span class="red">请先登录！</span>';
    jumpToURL('../user/login.php?from=supdem/publish.php', array(), 2);
}
else
{
    $msg = '发布成功！';
    jumpToURL("detail.php?id={$id}", array(), 1.5);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>投稿</title>
    <?php load_cssFile() ?>
    <link rel="stylesheet" href="style/basic-grey.css" type="text/css" />
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
            <!-- <div class="entry"> -->
            <form action="#" method="post" class="basic-grey" enctype="multipart/form-data">
                <h1>发布供应/需求信息
                    <?= @$msg ?></span>
                </h1>

                <?php if(isLoggedIn()): ?>

                <label id="typeSel">
                    <span>类型：</span>
                    <select id="typeSel" name="type">
                        <option <?= !@$_POST['type'] ? 'selected' : '' ?> value="0">供应</option>
                        <option <?=  @$_POST['type'] ? 'selected' : '' ?> value="1">需求</option>
                    </select>
                </label>
                
                <label id="name">
                    <span>商品名称：</span>
                    <input id="name" type="text" name="name" placeholder="输入商品名称" 
                    required="required" value="<?= @$_POST['name'] ?>" />
                </label>
                
                <label id="content_input">
                    <span>描述：</span>
                    <textarea id="content_input" name="content" placeholder="输入商品描述" 
                    required="required"><?= @$_POST['content'] ?></textarea>
                </label>
                
                <label id="img">
                    <span>图片：</span>
                    <input id="img" type="file" name="img" />
                </label>
                
                <label id="contact">
                    <span>联系方式：</span>
                    <input id="contact" type="text" name="contact" placeholder="请输入联系方式" 
                    required="required" value="<?= @$_POST['contact'] ?>" />
                </label>
                
                <label>
                    <span style="user-select: none;">&nbsp;</span>
                </label>
                <input id="submitBtn" type="submit" class="button" name="btn" value="发  布" />
                
                <?php endif; ?>

            </form>
            <div class="clear"></div>
        </div>
        <!-- 页面内容 -->
    </div>

    <?php
    unset($_POST);
    load_footer();
    // 页尾栏 
    ?>

    <!-- Basic Scripts -->
    <script src="style/bootstrap.js"></script>
    <!-- Beyond Scripts -->
    <script src="style/beyond.js"></script>

</body>

</html>