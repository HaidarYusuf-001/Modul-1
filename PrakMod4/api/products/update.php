<?php
header("Content-Type: application/json");
include_once "../config/database.php";

$database = new Database();
$db = $database->getConnection();

// Ambil ID dari URL (misalnya /update.php/6)
$requestUri = $_SERVER['REQUEST_URI'];
$requestParts = explode('/', $requestUri);
$id = end($requestParts); // Ambil bagian terakhir sebagai ID

// Decode JSON input
$data = json_decode(file_get_contents("php://input"));

// Validasi apakah ID ditemukan
if (!is_numeric($id)) {
    echo json_encode(["message" => "Invalid ID."]);
    exit();
}

// Mulai proses update
$query = "UPDATE products SET ";
$params = [];

if (!empty($data->name)) {
    $query .= "name = :name, ";
    $params[':name'] = $data->name;
}

if (!empty($data->price)) {
    $query .= "price = :price, ";
    $params[':price'] = $data->price;
}

if (!empty($data->description)) {
    $query .= "description = :description, ";
    $params[':description'] = $data->description;
}

if (!empty($data->image)) {
    $query .= "image = :image, ";
    $params[':image'] = $data->image;
}

// Hapus koma terakhir dan tambahkan kondisi WHERE
$query = rtrim($query, ', ') . " WHERE id = :id";
$params[':id'] = $id;

$stmt = $db->prepare($query);

// Bind semua parameter
foreach ($params as $param => $value) {
    $stmt->bindValue($param, $value, PDO::PARAM_STR);
}

// Eksekusi query
if ($stmt->execute()) {
    echo json_encode(["message" => "Product updated successfully."]);
} else {
    echo json_encode(["message" => "Unable to update product."]);
}
?>
