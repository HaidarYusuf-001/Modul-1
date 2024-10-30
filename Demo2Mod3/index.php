<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencetakan Bilangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
        }
        .result {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .highlight {
            color: #FF5733;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Program Pencetak Bilangan</h1>
<form method="post">
    <label for="number">Masukkan Bilangan Bulat Positif (n):</label>
    <input type="number" id="number" name="number" min="1" required>
    <button type="submit">Cetak</button>
</form>

<div class="result">
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $n = intval($_POST["number"]);

        for ($i = 1; $i <= $n; $i++) {
            if ($i % 4 == 0 && $i % 6 == 0) {
                echo "<p class='highlight'>Pemrograman Website 2024</p>";
            } elseif ($i % 5 == 0) {
                echo "<p class='highlight'>2024</p>";
            } elseif ($i % 4 == 0) {
                echo "<p class='highlight'>Pemrograman</p>";
            } elseif ($i % 6 == 0) {
                echo "<p class='highlight'>Website</p>";
            } else {
                echo "<p>$i</p>";
            }
        }
    }
    ?>
</div>

</body>
</html>
