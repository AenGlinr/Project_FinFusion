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
            background-image: url("bg\ 1.png");
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
    <div class="container">
        <div class="item">
            <img src="ikan1.jpg" alt="Ikan 1">
            <div class="item-info">
                <div class="item-name">Ikan Cupang</div>
                <div class="item-details">Jantan</div>
                <div class="item-price">Rp 5.000</div>
            </div>
            <div class="quantity">
                <button onclick="decreaseQuantity(this)">-</button>
                <input type="number" value="1" min="1">
                <button onclick="increaseQuantity(this)">+</button>
            </div>
        </div>

        <!-- Contoh -->
        <div class="item">
            <img src="ikan2.jpg" alt="Ikan 2">
            <div class="item-info">
                <div class="item-name">Ikan Koi</div>
                <div class="item-details">Betina</div>
                <div class="item-price">Rp 8.000</div>
            </div>
            <div class="quantity">
                <button onclick="decreaseQuantity(this)">-</button>
                <input type="number" value="1" min="1">
                <button onclick="increaseQuantity(this)">+</button>
            </div>
        </div>


        <div class="total-price">Total: Rp 13.000</div>
    </div>

    <script>
        //menambah jml item ketika + diklik
        function increaseQuantity(button) {
            //mengambil kotak input jumlah item yang ada sebelum button +
            var input = button.previousElementSibling;
            //mengambil jumlah item saat ini dari kotak input dan mengonversinya ke dalam angka
            var currentValue = parseInt(input.value);
            //menambah jml item 1
            input.value = currentValue + 1;
            //mengupdate total harga
            updateTotalPrice();
        }

        //mengurangi jml item ketika - diklik
        function decreaseQuantity(button) {
            //mengambil kotak input jumlah item yang ada setelah tombol -
            var input = button.nextElementSibling;
            //mengambil jumlah item saat ini dari kotak input dan mengonversinya ke dalam angka
            var currentValue = parseInt(input.value);
            //periksa apakah item saat ini > 1
            if (currentValue > 1) {
                //mengurangi jml item 1
                input.value = currentValue - 1;
                //mengupdate total harga
                updateTotalPrice();
            }
        }

        //mengupdate total harga
        function updateTotalPrice() {
            //ambil semua item di keranjang
            var items = document.querySelectorAll('.item');
            //inisialisasi total harga 0
            var totalPrice = 0;
            //iterasi item dlm keranjang
            items.forEach(function(item) {
                //mengambil harga dari setiap item
                var priceElement = item.querySelector('.item-price');
                //mengambil jumlah item dari setiap item
                var quantityInput = item.querySelector('input[type="number"]');
                //mengubah harga menjadi angka bulat
                var price = parseInt(priceElement.innerText.replace('Rp ', '').replace('.', ''));
                //mengubah jumlah item menjadi angka bulat
                var quantity = parseInt(quantityInput.value);
                //hitung total harga dikali jml item
                totalPrice += price * quantity;
            });
            //menampilkan total harga
            document.querySelector('.total-price').innerText = 'Total: Rp ' + totalPrice.toLocaleString();
        }
    </script>
</body>

</html>