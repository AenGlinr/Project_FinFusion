<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Fish Entry</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        }

        .container {
        width: 80%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        }

        .header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin: 0;
        }

        .call-to-action button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 16px;
        }

        .call-to-action button:hover {
        background-color: #0056b3;
        }

        .create-form {
        display: flex;
        flex-direction: column;
        }

        .form-group {
        margin-bottom: 15px;
        }

        .form-group label {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        display: block;
        margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        }

        .form-group button {
        padding: 10px 20px;
        background-color: #28a745;
        color: #fff;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 16px;
        }

        .form-group button:hover {
        background-color: #218838;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Create Fish Entry</h2>
            <div class="call-to-action">
                <button>Create</button>
            </div>
        </div>
        <form class="create-form">
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="name">Fish Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>


    <?php
    // Proses form di sini
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Tangkap data dari form
        $fishName = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Proses penyimpanan data ke database atau tindakan lainnya
        // Contoh: Simpan data ke database
        // $conn = new mysqli("localhost", "username", "password", "database");
        // $sql = "INSERT INTO fish_entries (name, description, price) VALUES ('$fishName', '$description', '$price')";
        // $result = $conn->query($sql);
        // if ($result) {
        //     echo "<p>Data berhasil disimpan.</p>";
        // } else {
        //     echo "<p>Gagal menyimpan data.</p>";
        // }
    }
    ?>
    
</body>
</html>