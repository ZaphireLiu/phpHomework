<!DOCTYPE html>
<?php
require_once '../../Comm/function.php';
require_once '../load_resources.php';
preLoad(1); // 初始化&登录检查
if (!PER_ADM)
{
    popWarn('您没有查看/操作管理员的权限！');
    jumpToURL(LOC.'index.php');
}
$link = link_SQL();
$query = "SELECT * FROM admin_account";
$admList = getRet_SQL(mysqli_query($link, $query));
?>
<html>
<head>
    <meta charset="utf-8">
    <title>管理员列表</title>
    <?php load_cssFile()
    // 加载css文件 
    ?>
    <style>
        .noClickBtn {
            background-color: #364d62 !important;
            /* pointer-events: none; */
        }
        .noClickBtn:hover {
            background-color: #486474 !important;
        }
        .noClickBtn:focus {
            background-color: #364d62 !important;
        }
    </style>
</head>

<body>
    <script type="text/javascript">
        function confirmDel(id, title, isSelf)
        {
            /**
             * 0128: 测试时出现之前没有的问题
             * 无论传入何值（1/0/true/false/等等等等），if (isSelf)永远判定为true
             * 导致无论删谁一定都是删掉自己
             * Update: 问题貌似不是传值，而是无论咋样都使用之前的页面
             * 更改confirm()的内容没有变化，新增alert()函数也没反应
             * 但是php里的内容修改会正常更新
             * Update: 在load_resource.php里面找到问题了
             * 里面有个同名的函数，不知道为啥之前一直使用的是页面里的函数
             * 今天突然换成了那边的函数
             */
            if (isSelf == true) {
                if (confirm("是否确定删除自己的账号？数据无法恢复！删除后将退出登录") == true) {
                    window.location.href = 'del.php?self=1';
                }
            }
            else {
                if (confirm("是否确定删除ID为" + id + "，用户名为" + name + "的管理员账号？数据无法恢复！") == true) {
                    window.location.href = "del.php?id="+id;
                }
            }
        }
        function noClick()
        {
            alert("超级管理员的账号只能由自己删除");
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
                    '管理员' => '',
                    '管理员列表' => ''
                )) ?>
                <!-- Page Body -->
                <div class="page-body">
                    <button type="button" tooltip="添加管理员" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = 'add.php'"> <i class="fa fa-plus"></i>
                        添加管理员账号
                    </button>
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
                                                    <th class="text-center">用户名称</th>
                                                    <th class="text-center">用户权限</th>
                                                    <th class="text-center">状态</th>
                                                    <th class="text-center">操作</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($admList as $adm) :
                                                    $self = (ID_ADM == $adm['id'] ? 'true' : 'false');
                                                ?>
                                                <tr>
                                                    <td align="center"><?= $adm['id'] ?></td>
                                                    <td align="center"><?= $adm['id'] == $_SESSION['idAdm'] ? $adm['name'] . '<span class="red">&nbsp;(当前用户)</span>' : $adm['name'] ?></td>
                                                    <td align="center"><?= $adm['permission'] ? '超级管理员' : '普通管理员' ?></td>
                                                    <td align="center"><?= $adm['pwd_rst'] ? '密码重置' : '正常' ?></td>
                                                    <td align="center">
                                                        <button type="button" tooltip="详细信息" class="btn btn-sm btn-azure btn-addon" 
                                                        onClick="javascript:window.location.href = 'detail.php?id=<?= $adm['id'] ?>'">
                                                            <i class="fa fa-info"></i>详细信息
                                                        </button>
                                                        <button type="button" tooltip="编辑" class="btn btn-sm btn-azure btn-addon" 
                                                        onClick="javascript:window.location.href = 'edit.php?id=<?= $adm['id'] ?>'">
                                                            <i class="fa fa-wrench"></i>编辑
                                                        </button>
                                                        <?php if ($adm['permission'] && (ID_ADM != $adm['id'])): ?>                                                  
                                                        <button type="button" tooltip="删除" class="btn btn-sm btn-azure btn-addon noClickBtn" 
                                                            onClick="javascript:noClick()">
                                                            <i class="fa fa-trash-o"></i>删除
                                                        </button>
                                                        <?php else: ?>
                                                        <button type="button" tooltip="删除" class="btn btn-sm btn-azure btn-addon" 
                                                            onClick="javascript:confirmDel(<?= $adm['id'] ?>, '<?= $adm['name'] ?>', <?= $self ?>)">
                                                            <i class="fa fa-trash-o"></i>删除
                                                        </button>
                                                        <?php endif; ?>
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