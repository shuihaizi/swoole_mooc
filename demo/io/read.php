<?php

$result = swoole_async_readfile(__DIR__.'/1.txt', function ($filename, $fileContent){
    echo "filename:".$filename.PHP_EOL;
    echo "fileContent:".$fileContent.PHP_EOL;
});

var_dump($result);
echo "start".PHP_EOL;