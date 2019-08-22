<?php
require_once 'core.php';

$resource_url = $_GET["redir"];
if ($resource_url == "") {
    die;
} 

try {
    $redir_url = cache_get_resource_item($resource_url);
} catch (SQLException $e) {
    echo $e;
    die;
}

header("Location: ${redir_url}");
header("Cache-Control: public, max-age=3600");
