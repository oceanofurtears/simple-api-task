<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/city.php';

$database = new Database();
$db = $database->getConnection();

$city = new City($db);

$city->id = $_GET['id'];

if($city->delete())
{
    http_response_code(200);

    echo json_encode(["message" => "Запись была удалена."], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
} else {

    http_response_code(503);

    echo json_encode(["message" => "Не удалось удалить запись."], JSON_THROW_ON_ERROR);
}


