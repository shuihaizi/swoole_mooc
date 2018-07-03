<?php

class AysMysql{

    public $db;
    public $config;

    public function __construct()
    {
        $this->db = new Swoole\Mysql();
        $this->config = [
            'host' => '192.168.11.210',
            'port' => 3306,
            'user' => 'root',
            'password' => 'root',
            'database' => 'laravel54',
            'charset' => 'utf8', //指定字符集
            'timeout' => 2,  // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）
        ];
    }

    public function query($id, $username)
    {
        $this->db->connect($this->config, function ($db, $result) use ($id, $username) {
            echo 'mysql-connect'.PHP_EOL;
            if ($result === false){
                var_dump($db->connect_error);
                die;
            }

//            $sql = "SELECT `id`,`name`,`email`,`created_at` FROM users WHERE id = 1";
            $sql = "UPDATE users SET `name` = '{$username}' WHERE id = {$id}";
            echo $sql.PHP_EOL;
            $db->query($sql, function ($db, $result){
                if ($result === false){
                    var_dump($db->error);
                } elseif ($result === true){
                    // 增加、删除、更新时会返回布尔值
                    var_dump($db->affected_rows, $db->insert_id);
                } else {
                    print_r($result);
                }
                $db->close();
            });
        });
        return true;
    }

}

$server = new AysMysql();
$flag = $server->query(1, 'henry');
var_dump($flag);
echo 'start'.PHP_EOL;