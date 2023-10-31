<?php
/**
 * @Author dh2y
 * @Email 913992589@qq.com
 * @DateTime 2018/5/20 15:53
 * @dh2y 安装引导
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', '1');
//定义目录分隔符
define("DS", '/');

//定义web根目录
define('WWW_ROOT', dirname(__FILE__) . DS);
//定义CMS名称
$sitename = "Sms短信群发系统";
$lockFile = "." . DS . "install" . DS . "install.lock";
if (is_file($lockFile)) {
    die("<script>window.location.href = '/'</script>");
}

if ($_GET['c'] = 'start' && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    //执行安装
    $host = isset($_POST['hostname']) ? $_POST['hostname'] : 'localhost';
    $port = isset($_POST['port']) ? $_POST['port'] : '3306';
    //判断是否在主机头后面加上了端口号
    $hostData = explode(":", $host);
    if (isset($hostData) && $hostData && is_array($hostData) && count($hostData) > 1) {
        $host = $hostData[0];
        $port = $hostData[1];
    }
    //mysql的账户相关
    $mysqlUserName = isset($_POST['username']) ? trim($_POST['username']) : 'root';
    $mysqlPassword = isset($_POST['password']) ? trim($_POST['password']) : 'root';
    $mysqlDataBase = isset($_POST['database']) ? trim($_POST['database']) : 'www_sms_install';
    $mysqlPreFix = isset($_POST['prefix']) ? trim($_POST['prefix']) : 'dh2y_';
    $mysqlPreFix = rtrim($mysqlPreFix, "_") . "_";
    $adminUserName = isset($_POST['adminUserName']) ? trim($_POST['adminUserName']) : 'admin';
    $adminPassword = isset($_POST['adminPassword']) ? trim($_POST['adminPassword']) : '123456';
    $rePassword = isset($_POST['rePassword']) ? trim($_POST['rePassword']) : '123456';
    $email = isset($_POST['email']) ? trim($_POST['email']) : 'admin@dh2y.com';

    //判断两次输入是否一致
    if ($adminPassword != $rePassword) {
        die("<script>alert('两次输入密码不一致！');history.go(-1)</script>");
    }
    if (!preg_match("/^[\S]+$/", $adminPassword)) {
        die("<script>alert('密码不能包含空格！');history.go(-1)</script>");
    }
    if (!preg_match("/^\w+$/", $adminUserName)) {
        die("<script>alert('用户名只能输入字母、数字、下划线！');history.go(-1)</script>");
    }
    if (strlen($adminUserName) < 3 || strlen($adminUserName) > 12) {
        die("<script>alert('用户名请输入3~12位字符！');history.go(-1)</script>");
    }
    if (strlen($adminPassword) < 5 || strlen($adminPassword) > 16) {
        die("<script>alert('密码请输入5~16位字符！');history.go(-1)</script>");
    }
    //检测能否读取安装文件
    $sql = @file_get_contents(WWW_ROOT .'..'. DS . "data" . DS . 'www_sms_install.sql');
    if (!$sql) {
        die("<script>alert('请检查/data/www_sms_install.sql是否有读取权限！');</script>");
    }
    //替换表前缀
    $sql = str_replace("`dh2y_", "`{$mysqlPreFix}", $sql);
    //链接数据库
    $pdo = new PDO("mysql:host={$host};port={$port}", $mysqlUserName, $mysqlPassword, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
    // 连接数据库
    $link = @new mysqli("{$host}:{$port}", $mysqlUserName, $mysqlPassword);
    // 获取错误信息
    $error = $link->connect_error;
    if (!is_null($error)) {
        // 转义防止和alert中的引号冲突
        $error = addslashes($error);
        die("<script>alert('数据库链接失败:$error');history.go(-1)</script>");
    }
    // 设置字符集
    $link->query("SET NAMES 'utf8'");
    $link->server_info > 5.0 or die("<script>alert('请将您的mysql升级到5.0以上');history.go(-1)</script>");
    // 创建数据库并选中
    if (!$link->select_db($mysqlDataBase)) {
        $create_sql = 'CREATE DATABASE IF NOT EXISTS ' . $mysqlDataBase . ' DEFAULT CHARACTER SET utf8;';
        $link->query($create_sql) or die('创建数据库失败');
        $link->select_db($mysqlDataBase);
    }
    $sqlArr = explode(';', $sql);
    foreach ($sqlArr as $key => $val) {
        if ($val) {
            $link->query($val);
        }
    }

    //token生成
    $strs="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
    $token=substr(str_shuffle($strs),mt_rand(0,strlen($strs)-7),6);

    $password = md5($adminPassword.$token);

    $result = $link->query("UPDATE {$mysqlPreFix}admin SET `username` = '{$adminUserName}',`password` = '{$password}',`token`='{$token}',`email` = '{$email}' WHERE `username` = 'admin'");
    if (!$result) {
        die("<script>alert('安装失败！:$error');history.go(-1)</script>");
    }
    $databaseConfig = include "../config/sample.database.php";
    //替换数据库相关配置
    $databaseConfig['hostname']   = $host; // 服务器地址
    $databaseConfig['database']   = $mysqlDataBase; // 数据库名
    $databaseConfig['username']   = $mysqlUserName; // 用户名
    $databaseConfig['password']    = $mysqlPassword; // 密码
    $databaseConfig['hostport']   = $port; // 端口
    $databaseConfig['prefix'] = $mysqlPreFix; // 数据库表前缀

    $configFile = var_export($databaseConfig, true);
    $configFile = str_replace('array (','[',$configFile);
    $configFile = str_replace(')',']',$configFile);
    $configFile = str_replace('\'true\'','true',$configFile);
    $configFile = str_replace('\'false\'','false',$configFile);

    $putConfig = @file_put_contents("../config/database.php", "<?php\nreturn \n" . $configFile. "\n;");
    if (!$putConfig) {
        die("<script>alert('安装失败、请确定database.php是否有写入权限！:$error');history.go(-1)</script>");
    }
    $result = @file_put_contents($lockFile, 1);
    if (!$putConfig) {
        die("<script>alert('安装失败、请确定install.lock是否有写入权限！:$error');history.go(-1)</script>");
    }
    die("<script>alert('系统安装成功、点击跳转！');window.location.href = '/'</script>");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>安装<?php echo $sitename; ?></title>
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style type="text/css">
        html, body {
            height: 100%;
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div style="margin: 0 auto;text-align: center;margin-top: 20px;">
                <img src="./install/img/logo.jpg" style="border-radius: 50%;width: 100px;height: 100px">
            </div>
        </div>
        <div class="col-md-4 col-md-offset-4"
             style="background-color: rgba(255,255,255,.5);border-radius: 5px">
            <div id="cms-box">
                <form class="form-horizontal" action="./install.php?c=start" method="post">
                    <p style="font-size: 28px;font-weight: bolder;text-align: center;color: #fff;"><?= $sitename ?> 安装向导</p>
                    <div class="panel panel-default">
                        <div class="panel-heading">数据库相关设置</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">主机地址</label>
                                <div class="col-sm-10">
                                    <input type="text" name="hostname" class="form-control" value="localhost" placeholder="请输入主机地址、端口号可选">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">数据库名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="database" class="form-control" placeholder="请输入数据库名">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="username" class="form-control" placeholder="请输入用户名">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control" placeholder="请输入数据库密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">表前缀</label>
                                <div class="col-sm-10">
                                    <input type="text" name="prefix" class="form-control" placeholder="请设置数据表前缀">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">管理员账户相关设置</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="adminUserName" class="form-control" placeholder="请输入管理员账号">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" class="form-control" placeholder="请输入管理员邮箱">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10">
                                    <input type="password" name="adminPassword" class="form-control" placeholder="请输入密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">重复密码</label>
                                <div class="col-sm-10">
                                    <input type="password" name="rePassword" class="form-control" placeholder="请再次输入密码">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" style="width: 80%;">立即安装</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</body>
</html>