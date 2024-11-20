<?php
header("Content-Type: application/json");
include_once "../config/database.php";

$database = new Database();
$db = $database->getConnection();

// Cek jika ada query parameter 'id'
if (isset($_GET['id'])) {
    // Jika ada 'id', ambil produk berdasarkan ID
    $product_id = $_GET['id'];

    $query = "SELECT * FROM products WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $product_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Jika produk ditemukan, tampilkan data produk
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($product);
    } else {
        // Jika produk tidak ditemukan
        echo json_encode(["message" => "Product not found."]);
    }
} else {
    // Jika tidak ada 'id', tampilkan semua produk
    $query = "SELECT * FROM products";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
}
?>
