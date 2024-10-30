<?php
// Simulasi penyimpanan data kendaraan dalam file
$vehiclesDataFile = 'vehicles.json'; // Nama file untuk menyimpan data kendaraan

// Memuat kendaraan dari file JSON
function loadVehicles() {
    global $vehiclesDataFile;

    if (file_exists($vehiclesDataFile)) {
        $jsonData = file_get_contents($vehiclesDataFile);
        return json_decode($jsonData, true);
    }
    return []; // Kembalikan array kosong jika file tidak ada
}

// Menyimpan kendaraan ke file JSON
function saveVehicles($vehicles) {
    global $vehiclesDataFile;
    file_put_contents($vehiclesDataFile, json_encode($vehicles, JSON_PRETTY_PRINT));
}

// Fungsi untuk mengambil kendaraan berdasarkan username
function loadUserVehicles($username) {
    $vehicles = loadVehicles();
    return isset($vehicles[$username]) ? $vehicles[$username] : []; // Kembalikan kendaraan untuk pengguna
}

// Fungsi untuk menambah kendaraan
function addVehicle($username, $make, $model, $engine, $price) {
    $vehicles = loadVehicles();
    if (!isset($vehicles[$username])) {
        $vehicles[$username] = []; // Inisialisasi jika belum ada kendaraan
    }
    
    $vehicles[$username][] = [
        'make' => $make,
        'model' => $model,
        'engine' => $engine,
        'price' => (float)$price,
    ];
    
    saveVehicles($vehicles); // Simpan kembali ke file
}

// Fungsi untuk mengedit kendaraan
function editVehicle($username, $index, $make, $model, $engine, $price) {
    $vehicles = loadVehicles();
    if (isset($vehicles[$username][$index])) {
        $vehicles[$username][$index] = [
            'make' => $make,
            'model' => $model,
            'engine' => $engine,
            'price' => (float)$price,
        ];
        saveVehicles($vehicles); // Simpan kembali ke file
    }
}

// Fungsi untuk menghapus kendaraan
function deleteVehicle($username, $index) {
    $vehicles = loadVehicles();
    if (isset($vehicles[$username][$index])) {
        unset($vehicles[$username][$index]); // Hapus kendaraan
        $vehicles[$username] = array_values($vehicles[$username]); // Reindex array
        saveVehicles($vehicles); // Simpan kembali ke file
    }
}
?>
