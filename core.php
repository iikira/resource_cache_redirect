<?php
require_once 'config.php';
require_once 'exception.php';

// 连接数据库
$m = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
if ($m->connect_errno != 0) {
    die($m->conncect_error);
}

function clean_expired()
{
    global $m;
    $stmt = $m->prepare("DELETE FROM `" . DB_PREFIX . "resource_list` WHERE ((`expired_at` < now()));");
    $stmt->execute();
    $stmt->close();
}

function get_redir_url($resource_url)
{
    stream_context_set_default(array('http' => array('method' => 'HEAD')));
    $headers = get_headers($resource_url, 1);
    if (array_key_exists("Location", $headers)) {
        return $headers['Location'];
    }
    return $resource_url;
}

function cache_get_resource_item($resource_url)
{
    global $m;
    clean_expired();
    try {
        // 获取缓存内容
        $stmt = $m->prepare("SELECT `redir_url` FROM `" . DB_PREFIX . "resource_list` WHERE `resource_url` = md5(?) LIMIT 1");
        $stmt->bind_param('s', $resource_url);
        $stmt->bind_result($redir_url);
        $stmt->execute();
        if ($stmt->errno != 0) {
            throw new SQLException($stmt->error);
        }

        if ($stmt->fetch()) {
            return $redir_url;
        }
        // 没有结果, 继续
    } finally {
        $stmt->close();
    }

    try {
        $redir_url = get_redir_url($resource_url); // 获取跳转地址

        $stmt = $m->prepare("INSERT INTO `" . DB_PREFIX . "resource_list` (`resource_url`, `redir_url`, `expired_at`) VALUES (md5(?), ?,FROM_UNIXTIME(UNIX_TIMESTAMP(now())+" . CACHE_TIME . "));");
        $stmt->bind_param('ss', $resource_url, $redir_url);
        $stmt->execute();

        if ($stmt->errno != 0) {
            throw new SQLException($stmt->error);
        }
    } finally {
        $stmt->close();
    }
    return $redir_url;
}

function modify_url($url, $scheme)
{
    return preg_replace("/^.*?:\/\/(.*?)/", "${scheme}://$1", $url);
}

function close_database()
{
    $m->close();
}
