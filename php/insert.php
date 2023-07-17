<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
require_once 'config/Database.php';
require_once 'Test.php';

$db = new Database();
$db = $db->connect();
$test = new Test($db);

$data = json_decode(file_get_contents('php://input'));

if(empty(trim($data->name)) || empty(trim($data->country)) || empty(trim($data->age)))
{
  echo json_encode(['error' => 'All fields are required']);
  die();
}

$test->name = $data->name;
$test->country = $data->country;
$test->age = $data->age;

if($test->insert())
{
  echo json_encode(['success' => 'Data inserted successfully']);
} else {
  echo json_encode(['error' => 'error']);
}