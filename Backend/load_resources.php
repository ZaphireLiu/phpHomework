<!-- 管理面板动态加载文件、结构 -->
<?php
/*  230119 UPDATE: 部分前后台不同的函数也扔这了
    一样的函数放到Comm/function.php省的改两次 */

/**
 * 获取头像文件
 * @param string $relLoc load_resources文件生成的LOC常量
 * @param string $imgName 文件名（无后缀），即用户的ID
 * @return str 用户头像文件的路径
 */
function getAvatar($relLoc, $imgName)
{
    $fileList = scandir($relLoc . '../Data/adminAvatar');
    if (in_array($imgName . '.png', $fileList))
        return $relLoc . '../Data/adminAvatar/' . $imgName . '.png';
    else
        return $relLoc . '../Data/adminAvatar/default.png';
}
/**
 * 载入文件前需要先定义网页文件的相对位置，并检查登录状态
 * @param int $locLayer 网页文件在网站文件夹内的相对位置
 * - 根目录为0，每层子目录+1
 */
function preLoad($locLayer, $checkLogStat = true)
{
    @session_start();
    define('LOC', str_repeat('../', $locLayer));
    require_once LOC . '../Comm/function.php';
    // 检查是否登录，未登录则直接引导至登录界面
    if ($checkLogStat)
    {
        if (!isset($_SESSION['loginStatAdm']) || @$_SESSION['loginStatAdm'] < 1)
        header('Location:' . LOC . 'admin/login.php');
        else {   // 初始化用户信息
            $validList = array('idAdm', 'loginStatAdm', 'nameAdm', 'perAdm');
            foreach ($validList as $v) {
                if (!isset($_SESSION[$v])) {
                    header('Location:' . LOC . 'admin/login.php');
                    die(); // 初始化出错，跳转至登录页面并终止运行
                }
            }
            define('ID_ADM',    $_SESSION['idAdm']);
            define('NAME_ADM',  $_SESSION['nameAdm']);
            define('PER_ADM',   $_SESSION['perAdm'] ? true : false);
        }
    }
}

/** 
 * 载入css格式文件和头部的meta标签
 * @param string $des 本页面的描述
 */
function load_cssFile($des = '')
{
?>
    <meta name="description" content='<?= $des ?>'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Basic Styles -->
    <link href="<?= LOC ?>style/bootstrap.css" rel="stylesheet">
    <link href="<?= LOC ?>style/font-awesome.css" rel="stylesheet">
    <link href="<?= LOC ?>style/weather-icons.css" rel="stylesheet">
    <!-- Beyond styles -->
    <link id="beyond-link" href="<?= LOC ?>style/beyond.css" rel="stylesheet" type="text/css">
    <link href="<?= LOC ?>style/demo.css" rel="stylesheet">
    <link href="<?= LOC ?>style/typicons.css" rel="stylesheet">
    <link href="<?= LOC ?>style/animate.css" rel="stylesheet">
    <!-- Custom - Not from original template -->
    <style>
        .breadcrumb li a {
            color: #777777;
        }

        .breadcrumb li a:hover {
            color: #002f66;
        }
    </style>
<?php }
/** 
 * 载入js脚本文件
 */
function load_jsFile()
{
?>
    <!-- Basic Scripts -->
    <script src="<?= LOC ?>style/jquery_002.js"></script>
    <script src="<?= LOC ?>style/bootstrap.js"></script>
    <script src="<?= LOC ?>style/jquery.js"></script>
    <!-- Beyond Scripts -->
    <script src="<?= LOC ?>style/beyond.js"></script>

<?php }
/**
 * 导航栏
 */
function load_navBar()
{

?>
    <!-- 头部 -->
    <div class="navbar">
        <div class="navbar-inner">
            <div class="navbar-container">
                <!-- Navbar Barnd -->
                <div class="navbar-header pull-left">
                    <a href="<?= LOC ?>index.php" class="navbar-brand">
                        <small>
                            <img src="<?= LOC ?>images/logo.png" alt="">
                        </small>
                    </a>
                </div>
                <!-- /Navbar Barnd -->
                <!-- Sidebar Collapse -->
                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="collapse-icon fa fa-bars"></i>
                </div>
                <!-- /Sidebar Collapse -->
                <!-- Account Area and Settings -->
                <div class="navbar-header pull-right">
                    <div class="navbar-account">
                        <ul class="account-area">
                            <li>
                                <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                    <div class="avatar" title="View your public profile">
                                        <img src="<?= getAvatar(LOC, ID_ADM) ?>">
                                    </div>
                                    <section>
                                        <h2><span class="profile"><span><?= NAME_ADM ?></span></span></h2>
                                    </section>
                                </a>
                                <!-- Login Area Dropdown -->
                                <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                    <li class="username"><a><?= NAME_ADM ?></a></li>
                                    <li class="dropdown-footer">
                                        <a href="<?= LOC ?>admin/logout.php">
                                            退出登录
                                        </a>
                                    </li>
                                    <li class="dropdown-footer">
                                        <a href="<?= LOC ?>admin/pwd_edit.php">
                                            修改密码
                                        </a>
                                    </li>
                                </ul>
                                <!-- /Login Area Dropdown -->
                            </li>
                            <!-- /Account Area -->
                            <!-- Note: notice that setting div must start right after account area list.
                                no space must be between these elements -->
                            <!-- Settings -->
                        </ul>
                    </div>
                </div>
                <!-- /Account Area and Settings -->
            </div>
        </div>
    </div>

    <!-- /头部 -->

<?php }
/**
 * 侧边栏
 */
function load_sideBar($displaySearch = false)
{
?>
    <script type="text/javascript">
        function confirmDel() {
            if (confirm("是否确定删除自己的账号？数据无法恢复！删除后将退出登录") == true) {
                window.location.href = '<?= LOC ?>admin/del.php?self=1';
            }
        }
    </script>
    <!-- Page Sidebar -->
    <div class="page-sidebar" id="sidebar">
        <!-- Page Sidebar Header -->
        <div class="sidebar-header-wrapper">
            <?php if ($displaySearch) : ?>
                <form action="search.php" method="get">
                    <input class="searchinput" name="keyword" type="text">
                    <input type="submit" style="display: none;">
                </form>
                <i class="searchicon fa fa-search"></i>
                <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
            <?php endif; ?>
        </div>
        <!-- /Page Sidebar Header -->
        <!-- Sidebar Menu -->
        <ul class="nav sidebar-menu">
            <!-- Dashboard -->
            <!--
                侧边栏中可拓展的行也需要用<a>标签，否则无法正常显示
                此时统一指向#完事
            -->
            <li>
                <a href="<?= LOC ?>index.php" target="_blank" class="menu-dropdown">
                    <i class="menu-icon fa fa-home"></i>
                    <span class="menu-text">主页</span>
                    <i class="menu-expand"></i>
                </a>
            </li>
            <li>
                <a href="#" class="menu-dropdown">
                    <i class="menu-icon fa fa-user"></i>
                    <span class="menu-text">管理员</span>
                    <i class="menu-expand"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="<?= LOC ?>admin/edit.php?self=1">
                            <span class="menu-text">
                                编辑个人资料 </span>
                            <!-- <i class="menu-expand"></i> -->
                        </a>
                    </li>
                    <li>
                        <a href="<?= LOC ?>admin/pwd_edit.php">
                            <span class="menu-text">
                                修改密码 </span>
                            <!-- <i class="menu-expand"></i> -->
                        </a>
                    </li>
                    <?php if (PER_ADM) : ?>
                        <li>
                            <a href="<?= LOC ?>admin/adm_list.php">
                                <span class="menu-text"> 管理员列表 </span>
                                <!-- <i class="menu-expand"></i> -->
                            </a>
                        </li>
                        <li>
                            <a href="<?= LOC ?>admin/add.php">
                                <span class="menu-text"> 新增管理员账号 </span>
                                <!-- <i class="menu-expand"></i> -->
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>

            <li>
                <a href="#" class="menu-dropdown">
                    <i class="menu-icon fa fa-file-text"></i>
                    <span class="menu-text">内容管理</span>
                    <i class="menu-expand"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="<?= LOC ?>content/news_list.php">
                            <span class="menu-text">
                                新闻列表 </span>
                            <!-- <i class="menu-expand"></i> -->
                        </a>
                    </li>
                    <li>
                        <a href="<?= LOC ?>content/add_news.php">
                            <span class="menu-text">
                                添加新闻 </span>
                            <!-- <i class="menu-expand"></i> -->
                        </a>
                    </li>
                    <li>
                        <a href="<?= LOC ?>content/supdemInfo_list.php">
                            <span class="menu-text">
                                供需信息列表 </span>
                            <!-- <i class="menu-expand"></i> -->
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" class="menu-dropdown">
                    <i class="menu-icon fa fa-users"></i>
                    <span class="menu-text">用户管理</span>
                    <i class="menu-expand"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="<?= LOC ?>user/list.php">
                            <span class="menu-text">
                                用户列表 </span>
                            <!-- <i class="menu-expand"></i> -->
                        </a>
                    </li>
                    <li>
                        <a href="<?= LOC ?>user/add.php">
                            <span class="menu-text">
                                新增用户账号 </span>
                            <!-- <i class="menu-expand"></i> -->
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" class="menu-dropdown">
                    <i class="menu-icon fa fa-gear"></i>
                    <span class="menu-text">系统</span>
                    <i class="menu-expand"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="<?= LOC ?>admin/logout.php">
                            <span class="menu-text">
                                退出登录 </span>
                            <!-- <i class="menu-expand"></i> -->
                        </a>
                    </li>
                    <li>
                        <a href="javascript:confirmDel()">
                            <span class="menu-text">
                                注销账号 </span>
                            <!-- <i class="menu-expand"></i> -->
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- /Sidebar Menu -->
    </div>
    <!-- /Page Sidebar -->
<?php }
/**
 * 内容顶端的面包屑导航(Breadcrumbs)  
 * @param array $index 关联数组，键为显示的文字，值为对应的地址
 * - 若值为空则不指向任何地址  
 */

function load_breadcrumb($index = array())
{
    $keysArr = array_keys($index);
?>
    <!-- Page Breadcrumb -->
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <?php for ($i = 0; $i < count($index); $i++) : ?>
                <li <?= $i == count($index) - 1 ? 'class="active"' : '' ?>>
                    <?php if ($index[$keysArr[$i]] != '') : ?>
                        <a href="<?= $index[$keysArr[$i]] ?>">
                        <?php endif ?>
                        <?= $keysArr[$i] ?>
                        <?php if ($index[$keysArr[$i]] != '') : ?> </a> <?php endif ?>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
<?php } ?>