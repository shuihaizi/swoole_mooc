<?php

$content = date("Y-m-d  H:i:s").PHP_EOL;
swoole_async_writefile(__DIR__."/1.log", $content, function ($filename){
    // TODO
    echo "success".PHP_EOL;
}, FILE_APPEND);

echo "start".PHP_EOL;