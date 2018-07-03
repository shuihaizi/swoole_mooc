<?php
// 创建内存表
$table = new swoole_table(1024);
// 内存表增加一列
$table->column('id', $table::TYPE_INT, 4);
$table->column('name', $table::TYPE_STRING, 10);
$table->column('age', $table::TYPE_INT, 3);
$table->create();

//$table->set('001', ['id' => 1, 'name' => 'test1', 'age' => 20]);
$table['001'] = ['id' => 1, 'name' => 'test1', 'age' => 20];

$table->incr('001', 'age', 3);
//$table->decr('001', 'age', 3);

$table->del('001');

echo $table->count().PHP_EOL;

//$data = $table->get('001');
$data = $table['001'];
var_dump($data);
