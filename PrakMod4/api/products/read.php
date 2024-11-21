<?php
header("Content-Type: application/json");
include_once "../config/database.php";

$database = new Database();
$db = $database->getConnection();

// Ambil ID dari URL
$requestUri = $_SERVER['REQUEST_URI'];
$requestParts = explode('/', $requestUri);
$id = end($requestParts);

if (is_numeric($id)) {
    // Jika ID valid, ambil data produk berdasarkan ID
    $query = "SELECT * FROM products WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($product);
    } else {
        echo json_encode(["message" => "Product not found."]);
    }
} else {
    // Jika tidak ada ID, ambil semua produk
    $query = "SELECT * FROM products";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
}
?>
