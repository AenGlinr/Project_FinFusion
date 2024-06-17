<?php
// Memulai sesi atau melanjutkan sesi yang sudah ada
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Mengarahkan pengguna ke halaman login jika belum login
    header('location: loginAdmin.php');
    exit();
}

// Load fish entries from session
$fishEntries = isset($_SESSION['fish_entries']) ? $_SESSION['fish_entries'] : [];

if (isset($_POST['logout'])) {
    // Menghapus semua variabel sesi kecuali $_SESSION['fish_entries']
    foreach ($_SESSION as $key => $value) {
        if ($key !== 'fish_entries') {
            unset($_SESSION[$key]);
        }
    }
    // Mengarahkan pengguna ke halaman loginAdmin.php setelah logout
    header('location: loginAdmin.php');
    exit();
}


// Menampilkan semua kesalahan PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Proses form di sini
$fishEntries = [];

// Check if formcreate.php has submitted data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Tangkap data dari formcreate.php
    $fishName = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);

    // Ambil data yang sudah ada dari session jika ada
    $fishEntries = isset($_SESSION['fish_entries']) ? $_SESSION['fish_entries'] : [];

    // Tambahkan data baru ke dalam array
    $fishEntries[] = [
        'name' => $fishName,
        'description' => $description,
        'price' => $price,
        'image_path' => 'path/to/your/image'  // Path to be replaced with actual path if available
    ];

    // Simpan kembali ke session
    $_SESSION['fish_entries'] = $fishEntries;
}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Halaman dengan Sidebar Tetap</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background: url('bg 1.png') no-repeat center center;
            background-size: cover;
            position: relative;
        }
        .sidebar {
            box-sizing: border-box;
            position: fixed;
            width: 256px;
            height: 100vh;
            left: 0;
            top: 0;
            background: url('bg 1.png') no-repeat center center;
            background-size: cover;
            border-right: 1px solid #E0E0E0;
            padding: 20px;
        }
        .sidebar h3 {
            font-weight: 600;
            font-size: 20px;
            line-height: 30px;
            letter-spacing: -0.01em;
            color: #000000;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 16px;
        }
        .sidebar ul li a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #000000;
            padding: 10px 16px;
            background: #FFFFFF;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .sidebar ul li a:hover {
            background: #F7F7F7;
        }
        .sidebar ul li a i {
            margin-right: 8px;
        }
        .sidebar .list-title-style {
            display: flex;
            align-items: center;
            font-weight: 600;
            font-size: 16px;
            color: #000000;
            margin-bottom: 8px;
        }
        .sidebar .list-title-style i {
            margin-right: 8px;
        }
        .sidebar ul ul {
            padding-left: 16px;
        }
        .content {
            flex: 1;
            padding: 20px;
            margin-left: 256px;
            background: url('bg 1.png') no-repeat center center;
        }
        .content h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            width: 262px;
            height: 350px; 
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }
        .card p {
            font-size: 1rem;
            line-height: 1.5;
            color: #555;
        }
        .card .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .card .button:hover {
            background-color: #0056b3;
        }
        .container {
            position: relative;
            width: 100%;
            margin-top: 20px;
        }
        .profile-container {
            background-color: whitesmoke;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 200px;
            text-align: center;
            position: fixed;
            bottom: 10px;
            left: 10px;
        }
        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .username {
            font-size: 24px;
            color: black;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        .logout-button {
            width: 100%;
            padding: 10px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .logout-button:hover {
            background-color: red;
        }
        .button-create {
        margin-left: auto; /* Push the button to the right */
        }

        .button-create button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none; /* Remove underline from button inside link */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Finfusion App</h3>
        <ul>
            <li><a href="#"><i class="fas fa-search"></i> Browse</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Home</h1>
            <div class="button-create">
                <a href="formcreate.php">
                    <button>Create</button>
                </a>
            </div>
        <div class="container">
            <div class="card-container">
                <?php foreach ($fishEntries as $entry): ?>
                    <div class="card">
                        <div class="card-content">
                            <div class="graphic" style="background-image: url('<?php echo $entry['image_path']; ?>')"></div>
                            <div class="copy">
                                <h3 class="subtitle"><?php echo $entry['name']; ?></h3>
                                <p class="description"><?php echo $entry['description']; ?></p>
                                <p class="description">Price: <?php echo $entry['price']; ?></p>
                            </div>
                            <div class="button-container">
                                <button class="button">Detail</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="profile-container">
        <img src="profile.png" alt="Profile Image" class="profile-image">
        <h2 class="username"><?= htmlspecialchars($_SESSION["username"]) ?></h2>
        <form action="crud.php" method="POST">
            <input type="submit" name="logout" value="Logout" class="logout-button">
        </form>
    </div>
</body>
</html>
