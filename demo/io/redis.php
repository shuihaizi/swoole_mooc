<?php

$redis = new swoole_redis;
$redis->connect('127.0.0.1', 6379, function (swoole_redis $redis, $result){
    echo 'connect'.PHP_EOL;
    if ($result === false){
        echo "connect to redis server failed.\n";
        exit;
    }
    var_dump($result);

//    $redis->set('swoole', 'redis-'.time(), function (swoole_redis $redis, $result){
//        var_dump($result);
//    });

    $redis->get('swoole', function (swoole_redis $redis, $result){
        var_dump($result);
    });

    $redis->keys('*', function (swoole_redis $redis, $result){
        var_dump($result);
    });

    $redis->close();

});