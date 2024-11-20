<?php
header("Content-Type: application/json");
include_once "../config/database.php";

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $query = "DELETE FROM products WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $data->id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Product deleted successfully."]);
    } else {
        echo json_encode(["message" => "Unable to delete product."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
