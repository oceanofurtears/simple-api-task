<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if (
    !empty($_GET['name']) &&
    !empty($_GET['city_id'])
) {

    $user->name = $_GET['name'];
    $user->city_id = $_GET['city_id'];

    if ($user->create()) {

        http_response_code(201);
        echo json_encode(array("message" => "Запись была создана."), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(503);

        echo json_encode(["message" => "Создать запись не вышло."], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
} else {

    http_response_code(400);

    echo json_encode(["message" => "Невозможно создать запись. Данные неполные."], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
}
