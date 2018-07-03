<?php

// 连接swoole tcp服务
$client = new swoole_client(SWOOLE_SOCK_TCP);

if (!$client->connect("127.0.0.1", 9501)){
    die('连接失败');
}

// php cli常量
fwrite(STDOUT, '请输入消息：');
$msg = trim(fgets(STDIN));

// 发送消息给tcp server服务
$client->send($msg);

// 接收来自server的数据
$result = $client->recv();
echo $result;