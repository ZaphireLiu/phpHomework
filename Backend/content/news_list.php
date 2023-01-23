<!DOCTYPE html>
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1); // 初始化&登录检查

$link = link_SQL();
$query = "SELECT * FROM `news_data`";
$newsList = getRet_SQL(mysqli_query($link, $query));
?>
<html>
<head>
    <meta charset="utf-8">
    <title>新闻列表</title>
    <?php load_cssFile()
    // 加载css文件
    ?>
    <style>
        .noClickBtn {
            background-color: #47617c !important;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <script type="text/javascript">
        function confirmDelNews(id, title)
        {
            if (confirm("是否确定删除ID为" + id + "，标题为" + title + "的新闻？数据无法恢复！"))
            {
                window.location.href = "del_info.php?id="+id;
            }
        }
    </script>
    <?php load_navBar();
    // 导航栏
    ?>

    <div class="main-container container-fluid">
        <div class="page-container">
            <?php load_sideBar()
            // 侧边栏
            ?>
            <!-- Page Content -->
            <div class="page-content">
                <?php load_breadcrumb(array(
                    '管理面板' => LOC . 'index.php',
                    '内容管理' => '',
                    '新闻列表' => ''
                )) ?>
                <!-- Page Body -->
                <div class="page-body">
                    <button type="button" tooltip="添加新闻" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = 'add_news.php'">
                        <i class="fa fa-plus"></i> 添加新闻
                    </button>
                    <!--
                    <button type="button" tooltip="已发布新闻" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = 'add.php'">
                        <i class="fa fa-list"></i> 已发布新闻
                    </button>

                    <button type="button" tooltip="用户投稿" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = 'add.php'">
                        <i class="fa fa-pencil"></i> 用户投稿
                    </button>

                    <button type="button" tooltip="按时间排序" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = 'add.php'">
                        <i class="fa fa-list"></i> 按时间排序
                    </button>
                    <button type="button" tooltip="按类别排序" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = 'add.php'">
                        <i class="fa fa-pencil"></i> 用户投稿
                    </button>
                    -->
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="flip-scroll">
                                        <!-- <div style="line-height: 200%">权限区别：超级管理员可以查看/删除/编辑管理员账号，且只能自己修改和删除账号<br /></div> -->
                                        <table class="table table-bordered table-hover">
                                            <thead class="">
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">新闻标题</th>
                                                    <th class="text-center">发布时间</th>
                                                    <th class="text-center">类型</th>
                                                    <th class="text-center">操作</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($newsList as $news) :
                                                    switch ($news['type']) {
                                                        case 1: $newsType = '禽业'; break;
                                                        case 2: $newsType = '猪业'; break;
                                                        case 3: $newsType = '饲料'; break;
                                                        default: $newsType = '无'; break;
                                                    }
                                                    $newsUrl = LOC."../Frontend/article.php?id={$news['id']}";
                                                ?>
                                                <tr>
                                                    <td align="center"><?= $news['id'] ?></td>
                                                    <td align="center">
                                                        <?= mb_substr($news['title'], 0, 30, 'UTF-8').(mb_strlen($news['title'])>30?'······':'').($news['recommend']?'<span class="red">(推荐)</span>':'') ?></td>
                                                    <td align="center"><?= $news['publish_time'] ?></td>
                                                    <td align="center"><?= $newsType ?></td>
                                                    <td align="center">
                                                        <button type="button" tooltip="转到新闻页面" class="btn btn-sm btn-azure btn-addon"
                                                        onClick="javascript:window.location.href = '<?= $newsUrl ?>'">
                                                            <i class="fa fa-info"></i>转到新闻页面
                                                        </button>
                                                        <button type="button" tooltip="编辑" class="btn btn-sm btn-azure btn-addon"
                                                        onClick="javascript:window.location.href = 'edit_news.php?id=<?= $news['id'] ?>'">
                                                            <i class="fa fa-wrench"></i>编辑
                                                        </button>
                                                        <button type="button" tooltip="推荐" class="btn btn-sm btn-azure btn-addon"
                                                        onClick="javascript:window.location.href = 'rec_news.php?id=<?= $news['id'] ?>'">
                                                            <i class="fa <?= $news['recommend']?'fa-minus':'fa-plus' ?>"></i>
                                                            <?= $news['recommend']?'取消推荐':'推荐新闻' ?>
                                                        </button>
                                                        <button type="button" tooltip="删除" class="btn btn-sm btn-azure btn-addon"
                                                        onClick="javascript:confirmDelNews(<?= $news['id'] ?>, '<?= $news['title'] ?>')">
                                                            <i class="fa fa-trash-o"></i>删除
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Page Content -->
    </div>
    </div>

    <?php
    mysqli_close($link);
    // 实现一些效果的js脚本文件
    load_jsFile();
    ?>

</body>

</html>