<?php

class ws {
    const HOST = "0.0.0.0";
    const PORT = 9501;

    public $ws;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);
        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2,
        ]);
        $this->ws->on("open", [$this, 'onOpen']);
        $this->ws->on("message", [$this, 'onMessage']);
        $this->ws->on("task", [$this, 'onTask']);
        $this->ws->on("finish", [$this, 'onFinish']);
        $this->ws->on("close", [$this, 'onClose']);
        $this->ws->start();
    }

    /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request)
    {
        var_dump($request->fd);

        if ($request->fd == 1){
            // 每2秒执行
            swoole_timer_tick(2000, function ($timerId){
                echo "2s-timerId:{$timerId}\n";
            });
        }
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo "message:{$frame->data}\n";

        // TODO 10S
        $data = [
            'task' => 1,
            'fd' => $frame->fd
        ];

//        $ws->task($data);
        swoole_timer_after(5000, function () use ($ws, $frame){
            echo "5s-after\n";
            $ws->push($frame->fd, "server-time-after:");
        });

        $ws->push($frame->fd, "server-push:" . date('Y-m-d H:i:s'));
    }

    /**
     * @param $serv
     * @param $task_id
     * @param $src_worker_id
     * @param $data
     * @return string
     */
    public function onTask($serv, $task_id, $src_worker_id, $data)
    {
        print_r($data);
        // 耗时场景 10s
        sleep(10);
        return "on task finish";
    }

    /**
     * task任务完成事件
     * @param $serv
     * @param $task_id
     * @param $data
     */
    public function onFinish($serv, $task_id, $data)
    {
        echo "taskId:{$task_id}\n";
        echo "finish-data-success:{$data}\n";
    }

    public function onClose($ws, $fd)
    {
        echo "clientId:{$fd}\n";
    }
}

$server = new ws();