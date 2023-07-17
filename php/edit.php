<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/jason');
require_once 'config/Database.php';
require_once 'Test.php';

$db = new Database();
$db = $db->connect();
$test = new Test($db);

$test->id = $_GET['id'] ?? die();

$test->edit();

if($test->name !== null)
{
  $arr = [
    'id' => $test->id,
    'name' => $test->name,
    'country' => $test->country,
    'age' => $test->age,
    ];
    echo json_encode($arr, 256);
} else {
  echo json_encode(["message" => "Product does not exist."]);
}
