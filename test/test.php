<?php
require_once 'exception.php';

function t()
{
    try {
        throw new SQLException("1");
    } finally {
        echo 1;
    }
}

try {
    t();
} catch (SQLException $e) {
    echo $e;
}
