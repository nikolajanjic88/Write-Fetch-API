<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
require_once 'config/Database.php';
require_once 'Test.php';

$db = new Database();
$db = $db->connect();
$test = new Test($db);

$data = json_decode(file_get_contents('php://input'));

$test->id = $data->id;

if($test->delete())
{
  echo json_encode(['message' => 'success']);
} else {
  echo json_encode(['message' => 'error']);
}