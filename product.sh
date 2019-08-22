#!/bin/sh

dir="resource_cache_redirect"

cd ..
zip -q -r $dir/rcr.zip $dir/config.php $dir/core.php $dir/exception.php $dir/index.php
