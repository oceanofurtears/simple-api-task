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

$stmt = $user->get_user_by_city_id($_GET['city_id']);

$row_amount = $num = $stmt->rowCount();

if ($row_amount > 0) {

    $user_arr = array();
    $user_arr["items"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);

        $user_item = array(
            "id" => $id,
            "name" => $Name,
            "city_id" => $City_id,
        );

        array_push($user_arr["items"], $user_item);
    }
    http_response_code(200);

    echo json_encode($user_arr, JSON_THROW_ON_ERROR);
} else {

    http_response_code(503);

    echo json_encode(["message" => "Таких пользователей нет"], JSON_THROW_ON_ERROR);
}
