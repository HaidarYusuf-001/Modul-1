<?php
header("Content-Type: application/json");
include_once "../config/database.php";

$database = new Database();
$db = $database->getConnection();

// Ambil ID dari URL
$requestUri = $_SERVER['REQUEST_URI'];
$requestParts = explode('/', $requestUri);
$id = end($requestParts);

// Validasi apakah ID ditemukan
if (!is_numeric($id)) {
    echo json_encode(["message" => "Invalid ID."]);
    exit();
}

// Lakukan penghapusan produk berdasarkan ID
$query = "DELETE FROM products WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);

if ($stmt->execute() && $stmt->rowCount() > 0) {
    echo json_encode(["message" => "Product deleted successfully."]);
} else {
    echo json_encode(["message" => "Unable to delete product or product not found."]);
}
?>
