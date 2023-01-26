<?php // 存放共用函数
/**
 * 以固定参数连接数据库
 * @return mysqli|false $link
 */
function link_SQL()
{
    $link = @mysqli_connect('localhost', 'root', '', 'mgt_sys');
    if (!$link)
        echo <<<str
            <script type="text/javascript">alert("无法连接数据库！");</script>
        str;
    return $link;
}
/**
 * 从query操作返回的结果中返回所有的结果
 * @param mysqli_result $result `mysqli_query()`的返回值
 * @param int $mode 返回的格式：MYSQLI_[ASSOC/NUM/BOTH]
 * @return array|null 若存在结果，返回；若不存在，返回null
 */
function getRet_SQL($result, $mode = MYSQLI_ASSOC)
{
    if ($result)
    {
        $rs = array();
        while ($rs[] = mysqli_fetch_array($result, $mode));
        array_pop($rs);
        if (count($rs) == 1)
            return $rs[0];
        else
            return $rs;
    }
    else
        return null;
}
/**
 * 获取SQL查询值 
 * 只要有结果，一概返回数组
 * @param mysqli $link `mysqli`的连接
 * @param string $query sql的SELECT命令
 * @return array|false 若存在结果，以数组形式返回；若不存在，返回`false`
 */
function query_SQL($link, $query)
{
    $result = mysqli_query($link, $query);
    if ($result -> num_rows > 0)
    {
        $rs = array();
        while ($rs[] = mysqli_fetch_array($result, MYSQLI_ASSOC));
        array_pop($rs);
        return $rs;
    }
    else return false;
}
/**
 * 跳转至指定页面  
 * php原生的header和HTML标记都有点太僵硬了，用js实现
 * @param string $url 要跳转的页面
 * @param array $getArr 使用GET方法传递参数
 */
function jumpToURL($url, $getArr = array(), $waitTime = 0)
{
    // if (isset($_COOKIE['DEBUG_MODE']))
    //     $time_m = 180 * 1000;
    // else
    $time_m = (int)($waitTime*1000);
    if (count($getArr) > 0)
    {
        $url = $url.'?';
        foreach ($getArr as $k => $v)
        {
            $url = $url.$k.'='.$v.'&';
        }
        $url = substr($url, 0, strlen($url)-1);
    }
    echo <<<str
        <script type="text/javascript">
            setTimeout("javascript:location.href='{$url}'", {$time_m}); 
        </script>
    str;
    if ($waitTime == 0)
        die();
}
/**
 * 验证登录  
 * @param mysqli_result $rs SQL结果
 * @param string $target 匹配对象
 * @return array 对应用户信息
 */
function validAcc($rs, $target)
{
    if ($rs -> num_rows == 1)
        return mysqli_fetch_array($rs);
    else
    {
        $retArr = array();
        foreach (getRet_SQL($rs) as $v)
        {
            if ($v['id'] == $target)
                $retArr[0] = $v;
            elseif ($v['phone'] == $target)
                $retArr[1] = $v;
            elseif ($v['email'] == $target)
                $retArr[2] = $v;
        }
        ksort($retArr);
        foreach ($retArr as $v)
            return $v;
    }
}
/**
 * 发送POST请求
 * @param string $url 请求地址
 * @param array $queryArr_POST POST表单数据，name=>value
 * @param array $queryArr_GET GET表单数据，name=>value（可选）
 * @return null
 */
function jumpToURL_POST($url, $queryArr_POST, $queryArr_GET = array())
{
    if (count($queryArr_GET) > 0)
    {
        $url .= '?';
        foreach ($queryArr_GET as $k => $v)
            $url .= $k.'='.$v.'&';
        $url = substr($url, 0, strlen($url)-1);
    }
    $formItemString = '';
    foreach($queryArr_POST as $key=>$value)
        $formItemString.="<input name='{$key}' type='text' value='{$value}'/>";
    //构造表单并跳转
    $content=<<<str
        <form style='display:none' name='submit_form' id='submit_form' action='{$url}' method='post'>
            {$formItemString}
        </form>
        <script type="text/javascript">
            document.submit_form.submit();
        </script>
    str;
    die($content);
}
/**
 * 获取本文件的位置  
 * 因为调试时不是在根目录，调试时无法使用绝对位置
 * @param int $layer 在文件夹中的层数
 * @return str 本文件相对于（本网站）根目录的位置
 */
function getRelLoc($layer)
{
    $res = array();
    preg_match('?'.str_repeat('([^/]{1,})/', $layer).'([^/]{1,})\.php$?', $_SERVER['PHP_SELF'], $res);
    return $res[0];
}
/**
 * 弹出警告框
 * @param string $msg 警告信息
 */
function popWarn($msg)
{
    echo <<<str
        <script type="text/javascript">alert("{$msg}");</script>
    str;
}
/**
 * 对上传的头像进行裁剪，生成方形的png文件
 * 文件支持bmp/gif/jpeg/jpg/png/wbmp/webp
 * @param string $formName 表单中上传文件的input的name
 * @param string $imgName 存储的文件名
 * @param string $dstPath 存储的目标路径
 * @param int $width 头像大小(高和宽)，默认为200px
 */
function saveResizedImg($formName, $imgName, $dstPath, $width = 200, $height = -1)
{   // 写GD2的人怎么想的下划线和驼峰都不用
    if ($height < 0)
        $height = $width;
    $uploadFile = $_FILES[$formName];
    $uploadFileName = iconv("UTF-8", "gb2312", $uploadFile['name']);
    if($uploadFile['error'] == 0)
    {   // 将临时文件转移到指定的目录
        $suffix = '.'.@array_pop(explode('.', $uploadFileName));
        $image = $dstPath.'/'.$imgName.$suffix;
        $imageDst = $dstPath.'/'.$imgName.'.png';
        $info = move_uploaded_file($uploadFile['tmp_name'], $image);
        if($info){
            // 原图资源
            switch ($suffix) {
                case '.bmp':     $src = @imagecreatefrombmp($image);  break;
                case '.gif':     $src = @imagecreatefromgif($image);  break;
                case '.jpeg':    $src = @imagecreatefromjpeg($image); break;
                case '.jpg':     $src = @imagecreatefromjpeg($image); break;
                case '.png':     $src = @imagecreatefrompng($image);  break;
                case '.wbmp':    $src = @imagecreatefromwbmp($image); break;
                case '.webp':    $src = @imagecreatefromwebp($image); break;
                default: return -2;
            }
            if (@stripos(@error_get_last()['message'], 'is not a valid'))
                return -3;
            $dst      = imagecreatetruecolor($width, $height);          // 创建缩略图画布
            $bg_color = imagecolorallocatealpha($dst, 0, 0, 0, 127);    // 透明背景
            imagefill($dst, 0, 0, $bg_color);
            $src_info = getimagesize($image);
            $src_c = $src_info[0] / $src_info[1];   // 原图比例
            $thu_c = $width / $height;              // 缩略图比例
            if($src_c < $thu_c){
                $thu_w = $width;
                $thu_h = ceil($thu_w / $src_c);
                $src_x = 0;
                $src_y = ceil($src_info[1]/2 - ($height*($src_info[0]/$width))/2);
            }else{
                $thu_h = $height;
                $thu_w = ceil($thu_h * $src_c);
                $src_x = ceil($src_info[0]/2 - ($width*($src_info[1]/$height))/2);
                $src_y = 0;
            }
            imagecopyresampled($dst, $src, 0, 0, $src_x, $src_y, $thu_w, $thu_h,
            $src_info[0], $src_info[1]);
            imagepng($dst, $imageDst);
            imagedestroy($dst);
            imagedestroy($src);
            if ($suffix != '.png')
                // 删除原文件
                unlink($image);
            return 0;
        } else {
            return -1;
        }
    }
}
/**
 * 截取并返回字符串
 * @param string $str 要截取的字符串
 * @param int $len 目标长度
 * @param string $suffix (可选,默认仨省略号) 后缀
 * @return str 处理后的字符串 
 */
function cutStr($str, $len, $suffix = '···')
{
    if (mb_strlen($str, 'UTF-8') <= $len)
        return $str;
    else
        return mb_substr($str, 0, $len, 'UTF-8').$suffix;
}
/**
 * 从文件中读取数据
 * @param string $path 文件路径
 * @param int $size 读取量
 * @return string
 */
function mb_readFile($path, $size = -1)
{
    $file = fopen($path, 'r');
    $stream = '';
    while(!feof($file))
        // feof函数测试指针是否到了文件结束的位置。
        $stream .= fgets($file);
    // echo $stream;
    return $size > 0 ? cutStr($stream, $size) : $stream;
}
/**
 * 从数据库中检索ID并生成不重复的ID
 * @param mysqli $link 与数据库的连接
 * @param string $table_name 数据表名
 * @return int id
 */
function genID($link, $table_name)
{
    $query = "SELECT `id` FROM `{$table_name}`";
    $result = mysqli_query($link, $query);
    if ($result -> num_rows > 1)
    {   // 多于一行记录
        $rs = getRet_SQL($result);
        $idList = array();
        foreach ($rs as $v)
            $idList[] = (int)$v['id'];
        return max($idList) + 1;
    }
    elseif ($result -> num_rows == 1)
    {   // 正好一行记录
        $rs = mysqli_fetch_array($result);
        return $rs['id'] + 1;
    }
    else
    {   // 没有记录
        return 0;
    }
}
/**
 * 对搜索结果排序
 * @param array $rs 结果，每个结果中必须包含`search_time`字段
 * @return null
 */
function sortSearchRes(&$rs)
{
    $isSorted = false;
    while (!$isSorted)
    {
        $isSorted = true;
        for ($i=0; $i<count($rs)-1; $i++)
        {
            if (strtotime($rs[$i]['search_time']) < strtotime($rs[$i+1]['search_time']))
            {
                $isSorted = false;
                $cache    = $rs[$i];
                $rs[$i]   = $rs[$i+1];
                $rs[$i+1] = $cache;
            }
        }
    }
}
?>