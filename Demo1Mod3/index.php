<?php
session_start();
require 'preferences.php';
require 'vehicle_data.php';

// Cek login
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
$displayPreference = getDisplayPreference();

// Periksa jika tema diubah
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
    setDisplayPreference($_POST['theme']); // Simpan preferensi tema
    $displayPreference = getDisplayPreference(); // Update preference
}

// Daftar kendaraan
$vehicles = loadUserVehicles($isLoggedIn ? $_SESSION['username'] : ''); // Ambil kendaraan untuk pengguna login

// Menangani penambahan kendaraan
if (isset($_POST['add_vehicle'])) {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $engine = $_POST['engine'];
    $price = $_POST['price'];
    addVehicle($_SESSION['username'], $make, $model, $engine, $price); // Tambahkan kendaraan
    header("Location: index.php"); // Reload halaman untuk melihat kendaraan baru
    exit();
}

// Menangani pengeditan kendaraan
if (isset($_POST['edit_vehicle'])) {
    $index = $_POST['vehicle_index'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $engine = $_POST['engine'];
    $price = $_POST['price'];
    editVehicle($_SESSION['username'], $index, $make, $model, $engine, $price); // Edit kendaraan
    header("Location: index.php"); // Reload halaman untuk melihat perubahan
    exit();
}

// Menangani penghapusan kendaraan
if (isset($_POST['delete_vehicle'])) {
    $index = $_POST['vehicle_index'];
    deleteVehicle($_SESSION['username'], $index); // Hapus kendaraan
    header("Location: index.php"); // Reload halaman
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicle Management</title>
    <style>
        body {
            background-color: <?php echo $displayPreference === "dark" ? "#333" : "#FFF"; ?>;
            color: <?php echo $displayPreference === "dark" ? "#FFF" : "#000"; ?>;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1, h2, h3 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        /* Theme Selector Styles */
        .theme-selector {
            margin-bottom: 30px;
            padding: 15px;
            background-color: <?php echo $displayPreference === "dark" ? "#444" : "#f5f5f5"; ?>;
            border-radius: 8px;
        }

        .theme-selector select {
            margin-right: 10px;
        }

        /* Vehicle List Styles */
        .vehicle-list {
            margin: 20px 0;
        }

        .vehicle-item {
            background-color: <?php echo $displayPreference === "dark" ? "#444" : "#f9f9f9"; ?>;
            border: 1px solid <?php echo $displayPreference === "dark" ? "#555" : "#ddd"; ?>;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .vehicle-item:hover {
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .vehicle-content {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .vehicle-info {
            flex-grow: 1;
            padding-right: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* Button Styles */
        button, .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }

        .toggle-button {
            background-color: #4CAF50;
            color: white;
            min-width: 40px;
        }

        .toggle-button:hover {
            background-color: #45a049;
        }

        .delete-button {
            background-color: #ff4444;
            color: white;
            display: none;
        }

        .delete-button:hover {
            background-color: #cc0000;
        }

        /* Edit Form Styles */
        .edit-options {
            display: none;
            padding: 15px;
            border-top: 1px solid <?php echo $displayPreference === "dark" ? "#555" : "#ddd"; ?>;
        }

        .edit-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .edit-form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .edit-form button {
            background-color: #4CAF50;
            color: white;
            justify-self: start;
        }

        .edit-form button:hover {
            background-color: #45a049;
        }

        /* Add Vehicle Form Styles */
        .add-vehicle-form {
            background-color: <?php echo $displayPreference === "dark" ? "#444" : "#f5f5f5"; ?>;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .add-vehicle-form form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .add-vehicle-form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .add-vehicle-form button {
            background-color: #4CAF50;
            color: white;
            justify-self: start;
        }

        /* Login Form Styles */
        .login-form {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            background-color: <?php echo $displayPreference === "dark" ? "#444" : "#f5f5f5"; ?>;
            border-radius: 8px;
        }

        .login-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .login-form button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
        }

        /* Logout Link Style */
        .logout-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff4444;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .logout-link:hover {
            background-color: #cc0000;
        }
    </style>
    <script>
        function toggleEditOptions(index) {
            const options = document.getElementById('edit-options-' + index);
            const deleteBtn = document.getElementById('delete-button-' + index);
            const toggleBtn = document.getElementById('toggle-button-' + index);
            
            if (options.style.display === 'none') {
                options.style.display = 'block';
                deleteBtn.style.display = 'block';
                toggleBtn.innerHTML = '&#x25BC;'; // Down arrow
            } else {
                options.style.display = 'none';
                deleteBtn.style.display = 'none';
                toggleBtn.innerHTML = '&#x25B6;'; // Right arrow
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Theme Selector -->
        <div class="theme-selector">
            <form action="" method="post">
                <label for="theme">Pilih Tema:</label>
                <select name="theme" id="theme">
                    <option value="light" <?php if ($displayPreference === 'light') echo 'selected'; ?>>Cahaya</option>
                    <option value="dark" <?php if ($displayPreference === 'dark') echo 'selected'; ?>>Gelap</option>
                </select>
                <button type="submit" class="btn">Terapkan</button>
            </form>
        </div>

        <?php if ($isLoggedIn): ?>
            <h1>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            
            <h2>Daftar Kendaraan</h2>
            <div class="vehicle-list">
    <?php if (!empty($vehicles)): ?>
        <?php foreach ($vehicles as $index => $vehicle): ?>
            <div class="vehicle-item">
                <div class="vehicle-content">
                    <div class="vehicle-info">
                        <?php 
                        // Periksa apakah kunci yang diperlukan ada
                        $make = isset($vehicle['make']) ? htmlspecialchars($vehicle['make']) : 'N/A';
                        $model = isset($vehicle['model']) ? htmlspecialchars($vehicle['model']) : 'N/A';
                        $engine = isset($vehicle['engine']) ? htmlspecialchars($vehicle['engine']) : 'N/A';
                        $price = isset($vehicle['price']) ? htmlspecialchars($vehicle['price']) : '0';
                        
                        echo "$make $model (Mesin: $engine, Harga: $$price)";
                        ?>
                    </div>
                    <div class="action-buttons">
                        <button class="delete-button" id="delete-button-<?php echo $index; ?>" onclick="document.getElementById('delete-form-<?php echo $index; ?>').submit();">
                            Hapus
                        </button>
                        <button class="toggle-button" id="toggle-button-<?php echo $index; ?>" onclick="toggleEditOptions(<?php echo $index; ?>)">&#x25B6;</button>
                    </div>
                </div>
                <div id="edit-options-<?php echo $index; ?>" class="edit-options">
                    <form id="delete-form-<?php echo $index; ?>" action="" method="post" style="display:none;">
                        <input type="hidden" name="vehicle_index" value="<?php echo $index; ?>">
                        <input type="hidden" name="delete_vehicle" value="1">
                    </form>
                    <form action="" method="post" class="edit-form">
                        <input type="hidden" name="vehicle_index" value="<?php echo $index; ?>">
                        <input type="text" name="make" placeholder="Merek" value="<?php echo htmlspecialchars($vehicle['make']); ?>" required>
                        <input type="text" name="model" placeholder="Model" value="<?php echo htmlspecialchars($vehicle['model']); ?>" required>
                        <input type="text" name="engine" placeholder="Mesin" value="<?php echo htmlspecialchars($vehicle['engine']); ?>" required>
                        <input type="number" name="price" placeholder="Harga" value="<?php echo htmlspecialchars($vehicle['price']); ?>" required>
                        <button type="submit" name="edit_vehicle">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="vehicle-item">
            <div class="vehicle-content">Tidak ada kendaraan terdaftar.</div>
        </div>
    <?php endif; ?>
</div>


            <div class="add-vehicle-form">
                <h3>Tambah Kendaraan</h3>
                <form action="" method="post">
                    <input type="text" name="make" placeholder="Merek" required>
                    <input type="text" name="model" placeholder="Model" required>
                    <input type="text" name="engine" placeholder="Mesin" required>
                    <input type="number" name="price" placeholder="Harga" required>
                    <button type="submit" name="add_vehicle" class="btn">Tambah Kendaraan</button>
                </form>
            </div>
            
            <a href="logout.php" class="logout-link">Logout</a>
            
        <?php else: ?>
            <div class="login-form">
                <h1>Silakan Login</h1>
                <form action="login.php" method="post">
                    <input type="text" name="user_name" placeholder="Username" value="" autocomplete="off">
                    <input type="password" name="pass_word" placeholder="Password" value="" autocomplete="off">
                    <button type="submit">Login</button>
                </form>
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>