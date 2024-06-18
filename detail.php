<?php
include "database.php"; // Pastikan koneksi database di sini

// Pastikan id ikan tersedia di URL
if (isset($_GET['ikan'])) {
    $ikanId = $db->real_escape_string($_GET['ikan']);

    // Query untuk mendapatkan detail ikan
    $sql = "SELECT * FROM ikan WHERE id = '$ikanId'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // Ambil data ikan
        $row = $result->fetch_assoc();
    } else {
        echo "Ikan tidak ditemukan.";
        exit();
    }
} else {
    echo "ID ikan tidak disertakan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ikan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url("bg 1.png");
        }

        .container {
            width: 400px;
            /* Fixed width for the card */
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            /* Center the content */
        }

        .container img {
            width: 400px;
            /* Set a fixed width */
            height: 350px;
            /* Set a fixed height */
            object-fit: cover;
            /* Ensure the image covers the entire area */
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .container h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .container p {
            font-size: 1rem;
            line-height: 1.6;
            color: #333;
            text-align: center;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .add-to-cart-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .add-to-cart-form input[type="number"] {
            width: 50px;
            padding: 5px;
            text-align: center;
        }

        .add-to-cart-form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-to-cart-form button:hover {
            background-color: #0056b3;
        }

        .quantity {
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>
<div class="container">
    <img src="<?php echo htmlspecialchars($row['img']); ?>" alt="<?php echo htmlspecialchars($row['nama_ikan']); ?>" class="fish-image">
    <h1><?php echo htmlspecialchars($row['nama_ikan']); ?></h1>
    <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
    <p class="price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
    <form class="add-to-cart-form" action="keranjang.php" method="POST">
        <input type="hidden" name="id_ikan" value="<?php echo $ikanId; ?>">
        <label for="jumlah">Jumlah:</label>
        <div class="quantity">
            <button type="button" onclick="decreaseQuantity(this)">-</button>
            <input type="number" id="jumlah" name="jumlah" value="1" min="1">
            <button type="button" onclick="increaseQuantity(this)">+</button>
        </div>
        <button type="submit">Tambah ke Keranjang</button>
    </form>
    <a href="dashboard.php" class="back-button">Kembali</a>
</div>

    <script>
        function decreaseQuantity(button) {
            var input = button.nextElementSibling;
            var value = parseInt(input.value, 10);
            if (value > 1) {
                input.value = value - 1;
            }
        }

        function increaseQuantity(button) {
            var input = button.previousElementSibling;
            var value = parseInt(input.value, 10);
            input.value = value + 1;
        }
    </script>

</body>

</html>