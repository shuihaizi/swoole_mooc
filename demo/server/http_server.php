<?php

$http = new swoole_http_server('0.0.0.0', 8811);

$http->set([
    'enable_static_handler' => true,
    'document_root' => '/mnt/hgfs/swoole_mooc/demo/data'
]);

$http->on('request', function ($request, $response){
//    print_r($request->get);

    $content = [
        'date:' => date("Y-m-d H:i:s"),
        'get:' => $request->get,
        'post:' => $request->post,
        'header:' => $request->header
    ];

    swoole_async_writefile(__DIR__."/access.log", json_encode($content), function ($filename){
        // TODO
    }, FILE_APPEND);

    $response->cookie('singwa', 'xsssss', time()+1800);
    $response->end('HTTP_SERVER-'.json_encode($request->get));
});

$http->start();