<?php
header("Content-Type: application/json");
include_once "../config/database.php";

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->price)) {
    $query = "INSERT INTO products (name, price, description, image) VALUES (:name, :price, :description, :image)";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":name", $data->name);
    $stmt->bindParam(":price", $data->price);
    $stmt->bindParam(":description", $data->description);
    $stmt->bindParam(":image", $data->image);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Product created successfully."]);
    } else {
        echo json_encode(["message" => "Unable to create product."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
