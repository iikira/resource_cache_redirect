<?php
require_once 'core.php';

$resource_url = $_GET["redir"];
$scheme = $_GET["scheme"];
if ($resource_url == "") {
    die;
}

try {
    $redir_url = cache_get_resource_item($resource_url);
} catch (SQLException $e) {
    echo $e;
    die;
}

switch ($scheme) {
    case "http":
    case "https":
        $redir_url = modify_url($redir_url, $scheme);
        break;
}

header("Location: ${redir_url}");
header("Cache-Control: public, max-age=3600");
