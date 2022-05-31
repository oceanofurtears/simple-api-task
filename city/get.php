<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../config/database.php';
include_once '../models/city.php';


$database = new Database();
$db = $database->getConnection();

$city = new City($db);

$stmt = $city->get($_GET['page']);

$rows = $stmt->rowCount();

if ($rows>0)
{
    
    $city_arr = array();
    $city_arr["items"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $user_item = array(
            "id" => $id,
            "name" => $Name,
            
        );

        array_push($city_arr["items"], $user_item);
    }
    
    http_response_code(200);

    echo json_encode($city_arr, JSON_THROW_ON_ERROR);

} else {
    http_response_code(404);

    echo json_encode(["message" => "Записи не найдены."], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
}




