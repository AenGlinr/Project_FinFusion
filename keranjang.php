<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("bg 1.png");
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .item img {
            width: 100px;
            height: auto;
        }

        .item-info {
            flex: 1;
            margin-left: 20px;
        }

        .item-name {
            font-weight: bold;
        }

        .item-price {
            color: green;
        }

        .quantity {
            display: flex;
            align-items: center;
        }

        .quantity input {
            width: 40px;
            text-align: center;
            margin: 0 10px;
        }

        .total-price {
            margin-top: 20px;
            font-size: 20px;
            text-align: right;
        }
    </style>
</head>

<body>
    <form action="dashboard.php" method="GET">
        <button type="submit" class="back-button">&larr;</button>
    </form>
    <div class="container">
        <?php
        session_start();
        include "database.php"; // Pastikan file database.php sesuai dengan konfigurasi database Anda

        // Inisialisasi keranjang jika belum ada
        if (!isset($_SESSION['keranjang'])) {
            $_SESSION['keranjang'] = [];
        }

        // Inisialisasi total harga jika belum ada
        if (!isset($_SESSION['total_harga'])) {
            $_SESSION['total_harga'] = 0; // Inisialisasi jika belum ada
        }

        // Fungsi untuk menambah item ke keranjang
        function tambahKeKeranjang($idIkan, $jumlah, $itemName, $itemPrice, $itemImg)
        {
            // Cek apakah item sudah ada di dalam keranjang session
            foreach ($_SESSION['keranjang'] as &$item) {
                if ($item['id_ikan'] === $idIkan) {
                    // Update jumlah jika item sudah ada di keranjang
                    $item['jumlah'] += $jumlah;
                    return; // Keluar dari fungsi setelah update
                }
            }

            // Jika item belum ada di keranjang, tambahkan sebagai item baru
            $_SESSION['keranjang'][] = [
                'id_ikan' => $idIkan,
                'jumlah' => $jumlah,
                'nama_ikan' => $itemName,
                'harga' => $itemPrice,
                'img' => $itemImg
            ];
        }

        // Cek apakah ada data yang dikirimkan dari detail.php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_ikan'], $_POST['jumlah'])) {
            $idIkan = $_POST['id_ikan'];
            $jumlah = $_POST['jumlah'];

            // Query untuk mendapatkan detail ikan berdasarkan $idIkan
            $sql = "SELECT * FROM ikan WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('s', $idIkan);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $itemName = htmlspecialchars($row['nama_ikan']);
                $itemPrice = $row['harga'];
                $itemImg = htmlspecialchars($row['img']);

                // Panggil fungsi tambahKeKeranjang untuk menambahkan ke session keranjang
                tambahKeKeranjang($idIkan, $jumlah, $itemName, $itemPrice, $itemImg);

                // Simpan total harga ke session
                $_SESSION['total_harga'] += $itemPrice * $jumlah;

                $stmt->close();
            }
        }

        // Menampilkan semua item dalam keranjang
        foreach ($_SESSION['keranjang'] as $item) {
            echo '<div class="item">';
            echo '<img src="img/' . (isset($item['img']) ? $item['img'] : '') . '" alt="' . $item['nama_ikan'] . '">';
            echo '<div class="item-info">';
            echo '<div class="item-name">' . $item['nama_ikan'] . '</div>';
            echo '<div class="item-price">Rp ' . number_format($item['harga'], 0, ',', '.') . '</div>';
            echo '</div>';
            echo '<div class="quantity">';
            echo '<button onclick="decreaseQuantity(this)">-</button>';
            echo '<input type="number" value="' . $item['jumlah'] . '" min="1">';
            echo '<button onclick="increaseQuantity(this)">+</button>';
            echo '</div>';
            echo '</div>';
        }

        // Menampilkan total harga
        echo '<div class="total-price">Total: Rp ' . number_format($_SESSION['total_harga'], 0, ',', '.') . '</div>';
        ?>
    </div>

    <script>
        // Fungsi JavaScript untuk menambah dan mengurangi jumlah item
        function increaseQuantity(button) {
            var input = button.previousElementSibling;
            var currentValue = parseInt(input.value);
            input.value = currentValue + 1;
            updateTotalPrice();
        }

        function decreaseQuantity(button) {
            var input = button.nextElementSibling;
            var currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateTotalPrice();
            }
        }

        function updateTotalPrice() {
            var items = document.querySelectorAll('.item');
            var totalPrice = 0;
            items.forEach(function(item) {
                var priceElement = item.querySelector('.item-price');
                var quantityInput = item.querySelector('input[type="number"]');
                var price = parseInt(priceElement.innerText.replace('Rp ', '').replace('.', ''));
                var quantity = parseInt(quantityInput.value);
                totalPrice += price * quantity;
            });
            document.querySelector('.total-price').innerText = 'Total: Rp ' + totalPrice.toLocaleString();
        }
        updateTotalPrice();
    </script>
</body>

</html>