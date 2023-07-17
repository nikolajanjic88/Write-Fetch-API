<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once 'config/Database.php';
require_once 'Test.php';

$db = new Database();
$db = $db->connect();
$test = new Test($db);

$result = $test->read();
$num = $result->rowCount();

if($num > 0) 
{
  $arr['data'] = [];
  while($row = $result->fetch(PDO::FETCH_ASSOC))
  {
    extract($row);

    $user = [
      'id' => $id,
      'name' => $name,
      'country' => $country,
      'age' => $age,
      'created_at' => $created_at
    ];

    array_push($arr['data'], $user);
  }
  echo json_encode($arr, 256);
} else {
  echo json_encode(['message' => 'No data']);
}