<!DOCTYPE html>
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1); // 初始化&登录检查

$link = link_SQL();
$query = "SELECT * FROM `sup_and_dem`";
$infoList = getRet_SQL(mysqli_query($link, $query));
?>
<html>
<head>
    <meta charset="utf-8">
    <title>供需信息列表</title>
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
        function confirmDelInfo(id, name)
        {
            if (confirm("是否确定删除ID为" + id + "，标题为" + name + "的供需信息？数据无法恢复！"))
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
                    '供需信息列表' => ''
                )) ?>
                <!-- Page Body -->
                <div class="page-body">
                    <button type="button" tooltip="添加" class="btn btn-sm btn-azure btn-addon" 
                    onClick="javascript:window.location.href = 'add_.php'"
                    style="visibility: hidden; height: 0px">
                        <i class="fa fa-plus"></i> 添加
                    </button>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="flip-scroll">
                                        <table class="table table-bordered table-hover">
                                            <thead class="">
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">标题</th>
                                                    <th class="text-center">发布时间</th>
                                                    <th class="text-center">类型</th>
                                                    <th class="text-center">操作</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($infoList as $info) :
                                                    switch ($info['type']) {
                                                        case 0: $infoType = '供应信息'; break;
                                                        case 1: $infoType = '需求信息'; break;
                                                        default: $infoType = '无'; break;
                                                    }
                                                    $infoUrl = LOC."../Frontend/supdem/detail.php?id={$info['id']}";
                                                ?>
                                                <tr>
                                                    <td align="center"><?= $info['id'] ?></td>
                                                    <td align="center">
                                                        <?= mb_substr($info['name'], 0, 30, 'UTF-8').(mb_strlen($info['name'])>30?'······':'') ?></td>
                                                    <td align="center"><?= $info['publish_time'] ?></td>
                                                    <td align="center"><?= $infoType ?></td>
                                                    <td align="center">
                                                        <a href="<?= $infoUrl ?>" target="_blank">
                                                            <button type="button" tooltip="转到页面" class="btn btn-sm btn-azure btn-addon">
                                                                <i class="fa fa-link"></i>转到页面
                                                            </button>
                                                        </a>
                                                        <button type="button" tooltip="查看内容" class="btn btn-sm btn-azure btn-addon" 
                                                        onClick="javascript:window.location.href = 'detail_info.php?id=<?= $info['id'] ?>'">
                                                            <i class="fa fa-info"></i>查看内容
                                                        </button>                                               
                                                        <button type="button" tooltip="删除" class="btn btn-sm btn-azure btn-addon" 
                                                        onClick="javascript:confirmDelInfo(<?= $info['id'] ?>, '<?= $info['name'] ?>')">
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