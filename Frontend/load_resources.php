<!-- 前台网站动态加载文件、结构 -->
<?php
/*  230119 UPDATE: 部分前后台不同的函数也扔这了
    一样的函数放到Comm/function.php省的改两次 */

/**
 * 获取头像文件
 * @param string $relLoc load_resources文件生成的LOC常量
 * @param string $imgName 文件名（无后缀），即用户的ID
 * @return string 用户头像文件的路径
 */
function getAvatar($relLoc, $imgName)
{
    $fileList = scandir($relLoc . '../Data/userAvatar');
    if (in_array($imgName . '.png', $fileList))
        return $relLoc . '../Data/userAvatar/' . $imgName . '.png';
    else
        return $relLoc . '../Data/userAvatar/default.png';
}
/**
 * 获取新闻宣传图文件
 * @param string $relLoc load_resources文件生成的LOC常量
 * @param string $imgName 文件名（无后缀），即新闻的ID
 * @return str 文件的路径
 */
function getNewsImg($relLoc, $imgName)
{
    $fileList = scandir($relLoc . '../Data/newsImg');
    if (in_array($imgName . '.png', $fileList))
        return $relLoc . '../Data/newsImg/' . $imgName . '.png';
    else
        return $relLoc . '../Data/newsImg/default.png';
}
/**
 * 获取供需宣传图文件
 * @param mysqli $link 数据库连接
 * @param string $relLoc load_resources文件生成的LOC常量
 * @param string $imgName 文件名（无后缀），即ID
 * @return string 文件的路径
 */
function getInfoImg($link, $relLoc, $imgName)
{
    $fileList = scandir($relLoc . '../Data/supdemImg');
    if (in_array($imgName . '.png', $fileList))
        return $relLoc . '../Data/supdemImg/' . $imgName . '.png';
    else
    {
        $query = "SELECT `type` FROM `sup_and_dem` WHERE `id`={$imgName}";
        $rs = getRet_SQL(mysqli_query($link, $query));
        if (!$rs['type'])
            return $relLoc . '../Data/supdemImg/default_supply.png';
        else
            return $relLoc . '../Data/supdemImg/default_demand.png';
    }
}
/**
 * 检查是否已经登录
 * @return boolean 返回bool
 */
function isLoggedIn()
{
    if (!isset($_COOKIE['isLoggedIn']) || @!$_COOKIE['isLoggedIn'])
        return false;
    elseif (!isset($_COOKIE['userID']) || !isset($_COOKIE['username']))
        return false;
    else
        return true;
}
/**
 * 载入文件前需要先定义网页文件的相对位置，并检查登录状态
 * @param int $locLayer 网页文件在网站文件夹内的相对位置
 * @param bool $setLoginStat 置为true则强制下线
 * - 根目录为0，每层子目录+1
 */
function preLoad($locLayer, $setLoginStat = false)
{
    define('LOC', str_repeat('../', $locLayer));
    require_once LOC . '../Comm/function.php';
    define('LOC_HERE', getRelLoc($locLayer));
    $selfName = basename($_SERVER['PHP_SELF']);
    $selfNameCheck = array(
        'login.php',        'login_proc.php',
        'signup.php',       'signup_proc.php',
        'reset_pwd.php',    'reset_pwd_proc.php',
        'forget_pwd.php',   'forget_proc.php'
    );
    foreach ($selfNameCheck as $v) {
        if ($selfName == $v)
            define('DONT_JUMP', true);
    }
    $extCookieList = array(
        'isLoggedIn',
        'username',
        'userID',
    );
    // 退出后再次进入貌似多少有点问题，手动检查一遍
    foreach ($extCookieList as $v)
        if (!isset($_COOKIE[$v]))
            $setLoginStat = true;
    if (!isLoggedIn() || $setLoginStat) {   // 未登录，清理Cookie
        echo '<!-- 未登录 -->';
        define('LOGIN_STATUS', false);
        for ($i = 1; $i < count($extCookieList); $i++) {
            $v = $extCookieList[$i];
            if (isset($_COOKIE[$v]))
                setcookie($v, $_COOKIE[$v], time() - 1, '/');
        }
    } else {   // 已经登录，延长Cookie时间30min
        echo "<!-- 已经登录 id: {$_COOKIE['userID']}; name: {$_COOKIE['username']} -->";
        define('LOGIN_STATUS', true);
        foreach ($extCookieList as $v)
            setcookie($v, $_COOKIE[$v], time() + 30 * 60, '/');
    }
    // 后台使用Session处理，前端网站考虑到自动下线等操作换成Cookie


}

function siteMap()
{   // 因为直接定义数组会因为关键常量没初始化导致FatalError
    // 所以改成函数形式
    // 0125：突然想起来还有类这个东西。。。有空再改吧（
    return array(
        '新闻' => array(
            'self' => LOC . 'list.php',
            '禽业' => LOC . 'list.php?listID=1',
            '猪业' => LOC . 'list.php?listID=2',
            '饲料' => LOC . 'list.php?listID=3'
        ),
        '供需信息' => array(
            'self'          => LOC . 'supdem/list.php',
            '查看供应信息'  => LOC . 'supdem/list.php?listID=0',
            '查看需求信息'  => LOC . 'supdem/list.php?listID=1',
            '发布信息'      => LOC . 'supdem/publish.php'
        ),
        // '市场行情' => array('self' => LOC . 'list.php?listID=3'),
        '关于我们' => array(
            'self' => LOC . 'about.php',
            '联系我们' => LOC . 'contact.php',
        ),
    );
}

/** 
 * 载入css格式文件和头部的meta标签
 * @param string $des 本页面的描述
 */
function load_cssFile($type='') // , $des = '', $key_w = ''
{
?>
    <!-- <meta name="description" content="" /> -->
    <!-- <meta name="keywords" content="" /> -->
    <link rel="stylesheet" type="text/css" media="all" href="<?= LOC ?>style/style.css" />
    <script src="<?= LOC ?>style/jquery-1.4.1.min.js" type="text/javascript"></script>
    <script src="<?= LOC ?>style/jquery.js" type="text/javascript"></script>
    <script src="<?= LOC ?>style/jquery.error.js" type="text/javascript"></script>
    <script src="<?= LOC ?>style/jtemplates.js" type="text/javascript"></script>
    <script src="<?= LOC ?>style/jquery.form.js" type="text/javascript"></script>
    <script src="<?= LOC ?>style/lazy.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= LOC ?>style/wp-sns-share.js"></script>
    <script type="text/javascript" src="<?= LOC ?>style/voterajax.js"></script>
    <script type="text/javascript" src="<?= LOC ?>style/userregister.js"></script>
    <link rel="stylesheet" href="<?= LOC ?>style/pagenavi-css.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?= LOC ?>style/votestyles.css" type="text/css" />
    <link rel="stylesheet" href="<?= LOC ?>style/voteitup.css" type="text/css" />
    <link rel="stylesheet" href="<?= LOC ?>style/self.css" type="text/css" />
    <?php
    switch ($type) {
        case 'article':
            echo '<link rel="stylesheet" href="'.LOC.'style/article.css" type="text/css" />';
        break;
        case 'list':
            echo '<link rel="stylesheet" href="'.LOC.'style/list.css" type="text/css" />';
        break;
        default: break;
    }
    ?>
    <style>
        .userAvatar {
            width: 30px;
            height: 30px;
            border-radius: 5px;
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
 * 顶端导航栏
 */
function load_header($showMask = false)
{
    // 当处于特定页面时，在跳转时不加参数，防止从错误的地方返回
    $getParam = defined('DONT_JUMP') ? '' : "?from=" . LOC_HERE;
    if ($showMask) :
    ?>
        <script type="text/javascript">
            function showMask() {
                $("#mask").css("height", $(document).height());
                $("#mask").css("width", $(document).width());
                $("#mask").show();
            }
        </script>
        <a href="<?= LOC ?>ad.php?from=<?= LOC_HERE ?>" target="_blank">
            <div id="mask" class="mask" onclick="CloseMask()"><img src="2022.png" style="width: 100%; height: 100%"></div>
        </a>
    <?php endif ?>
    <div id="header_wrap">
        <div id="header">
            <!-- 网站图标 -->
            <div style="float: left; width: 275px;">
                <h1>
                    <a href="<?= LOC ?>index.php" title="畜牧信息">畜牧信息</a>
                    <div class="" id="logo-sub-class">
                    </div>
                </h1>
            </div>
            <!-- /网站图标 -->

            <!-- 导航栏 -->
            <div class="navi">
                <ul class="jsddm">
                    <li><a class="navi_home" href="<?= LOC ?>index.php">首页</a></li>
                    <?php
                    foreach (siteMap() as $name => $arr) :
                        echo "<li><a href='{$arr['self']}'>{$name}</a>";
                        if (count($arr) == 1)
                            continue;
                        else {
                            echo '<ul>';
                            foreach ($arr as $name_li => $url)
                                if ($name_li != 'self')
                                    echo "<li><a href='{$url}'>{$name_li}</a></li>";
                            echo '</ul>';
                        }
                        echo '</li2>';
                    endforeach;
                    ?>
                </ul>
                <div style="clear: both;">
                </div>
            </div>
            <!-- /导航栏 -->
            <div style="float: right;">
                <div class="widget" style="height: 30px; padding-top: 20px;">
                    <!-- 搜索框 -->
                    <div style="float: left;">
                        <form name="formsearch" action="<?= LOC ?>search.php" method="GET">
                            <!-- <input type="hidden" name="kwtype" value="0"> -->
                            <input name="kw" type="text" style="background-color: #000000; padding-left: 10px; font-size: 12px; font-family: 'Microsoft Yahei'; color: #999999; height: 29px; width: 160px; border: solid 1px #666666; line-height: 28px;" id="go" value="在这里搜索..." onfocus="if(this.value=='在这里搜索...'){this.value='';}" onblur="if(this.value==''){this.value='在这里搜索...';}" />
                        </form>
                    </div>
                    <!-- /搜索框 -->
                    <?php if (LOGIN_STATUS) : ?>
                        <!-- 用户头像 -->
                        <div class="navi" style="float: right; height: 30px; margin-top: 0px; margin-left: 10px;">
                            <ul class="jsddm" style="vertical-align: middle;">
                                <li>
                                    <a href="<?= LOC ?>user/space.php" style="height: 80px;">
                                        <img class="userAvatar" src=<?= getAvatar(LOC, $_COOKIE['userID']) ?>>
                                    </a>
                                    <ul>
                                        <li style="background-color: #353535; text-align: center">
                                            <a href="<?= LOC ?>user/space.php">个人空间</a>
                                        </li>
                                        <li style="background-color: #353535; text-align: center">
                                            <a href="<?= LOC ?>user/reset_pwd.php">重置密码</a>
                                        </li>
                                        <li style="background-color: #353535; text-align: center">
                                            <a href="<?= LOC ?>user/logout.php<?= $getParam ?>">退出登录</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- /用户头像 -->
                    <?php else : ?>
                        <!-- 登录or注册 -->
                        <span id="login_guide">
                            <a href="<?= LOC ?>user/login.php<?= $getParam ?>">登录</a>
                            <span style="user-select: none;">&nbsp;|&nbsp;</span>
                            <a href="<?= LOC ?>user/signup.php<?= $getParam ?>">注册</a>
                        </span>
                        <!-- /登录or注册 -->
                    <?php endif; ?>
                    <div style="clear: both;">
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php }
function load_path($path)
{
    echo '<div class="path">';
    $pathStr = '';
    foreach ($path as $k => $v)
        $pathStr .= "<a href='{$v}'>$k</a> >";
    echo substr($pathStr, 0, strlen($pathStr) - 1);
    echo '</div>';
}
function load_siteMap()
{
?>
    <div class="sitemap">
        <h4>SITE MAP</h4>
        <div class="l">
            <ul id="menu-sitemap" class="menu">
                <?php
                foreach (siteMap() as $name => $arr) :
                    echo <<<str
                        <li class="menu-item menu-item-type-custom menu-item-object-custom">
                            <a target="_blank" href="{$arr['self']}">{$name}</a>
                            <ul class="sub-menu">
                        str;
                    if (count($arr) != 1) {
                        foreach ($arr as $name_li => $url)
                            if ($name_li != 'self')
                                echo <<<str
                                    <li class="menu-item menu-item-type-taxonomy menu-item-object-category">
                                        <a target='_blank' href='{$url}'>{$name_li}</a>
                                    </li>
                                    str;
                    }
                    echo '</ul></li>';
                endforeach;
                ?>
            </ul>
        </div>
        <div class="r">
            <h5>FOLLOW US</h5>
            <img src="./images/weixin.jpg" alt="" title="一个二维码" class="alignnone size-full wp-image-18966" height="140" width="140"></a>
        </div>
    </div>
<?php }
/**
 * 页尾栏
 */
function load_footer($btm = 0)
{

?>
    <div style="align-self: center">
        <div id="footer_wrap" <?php if ($btm) : ?> style="height: calc()" <?php endif ?>>
            <!-- style="position: fixed; bottom:0; width:100%" -->
            <div id="footer">
                <div class="footer_navi">
                    <ul id="menu-footer" class="menu">
                        <li id="menu-item-156" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-156">
                            <a href="<?= LOC ?>about_us.php">关于我们</a>
                        </li>
                        <li id="menu-item-157" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-157">
                            <a href="<?= LOC ?>contact.php">联络我们</a>
                        </li>
                    </ul>
                </div>
                <div class="footer_info">
                    <span class="legal">
                        Copyright &copy; 2022-2023; <a href="#">京ICP备000217号</a>
                    </span>
                </div>
            </div>
        </div>
        <div style="display: none;" id="scroll">
        </div>
        <script type="text/javascript" src="<?= LOC ?>style/z700bike_global.js"></script>
    </div>

<?php }