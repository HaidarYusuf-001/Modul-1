<?php
header("Content-Type: application/json");
include_once "../config/database.php";

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->name) && !empty($data->price)) {
    $query = "UPDATE products SET name = :name, price = :price, description = :description, image = :image WHERE id = :id";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":name", $data->name);
    $stmt->bindParam(":price", $data->price);
    $stmt->bindParam(":description", $data->description);
    $stmt->bindParam(":image", $data->image);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Product updated successfully."]);
    } else {
        echo json_encode(["message" => "Unable to update product."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
