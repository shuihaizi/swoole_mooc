<?php
$urls = [
    'http://baidu.com',
    'http://sina.com.cn',
    'http://qq.com',
    'http://taobao.com',
    'http://iqiyi.com',
    'http://youku.com',
];

echo 'start-time: '.date('Y-m-d H:i:s').PHP_EOL;

for ($i=0;$i<count($urls);$i++){
    $process = new swoole_process(function (swoole_process $process) use ($urls, $i) {
        $content = curlData($urls[$i]);
//        echo $content;
        $process->write($content);
    }, true);
    $pid = $process->start();
    $workers[$pid] = $process;
}

foreach ($workers as $worker){
    echo $worker->read();
}

swoole_process::wait();

echo 'end-time: '.date('Y-m-d H:i:s').PHP_EOL;

function curlData($url){
    sleep(1);
    return $url.PHP_EOL;
}