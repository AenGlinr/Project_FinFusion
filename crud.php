<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('location: loginAdmin.php');
    exit();
}

// Display all PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database configuration
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fishName = $db->real_escape_string(htmlspecialchars($_POST['name'] ?? ''));
    $description = $db->real_escape_string(htmlspecialchars($_POST['description'] ?? ''));
    $price = $db->real_escape_string(htmlspecialchars($_POST['price'] ?? ''));

    // Upload image
    $imagePath = 'uploads/';
    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    $imageUniqueName = uniqid('img_') . '.' . $imageFileType;
    $fullImagePath = $imagePath . $imageUniqueName;

    // Check if the uploads directory exists
    if (!file_exists($imagePath)) {
        mkdir($imagePath, 0755, true); // Create the directory if it doesn't exist
    }

    // Move uploaded file to destination directory
    if (move_uploaded_file($imageTmpName, $fullImagePath)) {
        // Insert data into database
        $sql = "INSERT INTO ikan (nama_ikan, deskripsi, harga, img) VALUES ('$fishName', '$description', '$price', '$fullImagePath')";

        if ($db->query($sql) === TRUE) {
            echo "Data berhasil disimpan";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    } else {
        echo "Upload gambar gagal. Error: " . $_FILES['image']['error'];
    }
}

// Load fish entries from database
$fishEntries = [];
$sql = "SELECT * FROM ikan";
$result = $db->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $fishEntries[] = $row;
    }
}

// Handle delete operation
if (isset($_POST['delete'])) {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $db->real_escape_string($_POST['id']);
        
        // Perform delete query
        $sql = "DELETE FROM ikan WHERE id = $id";
        if ($db->query($sql) === TRUE) {
            echo "Record deleted successfully";
            // Redirect to the same page to refresh the list
            header('Location: crud.php');
            exit();
        } else {
            echo "Error deleting record: " . $db->error;
        }
    } else {
        echo "ID is not set or empty. Cannot delete.";
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    // Destroy session except $_SESSION['fish_entries']
    foreach ($_SESSION as $key => $value) {
        if ($key !== 'fish_entries') {
            unset($_SESSION[$key]);
        }
    }
    // Redirect user to loginAdmin.php after logout
    header('location: loginAdmin.php');
    exit();
}

// Close database connection
$db->close();
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
        position: relative; /* Pastikan setiap kartu memiliki position: relative */
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
        .card button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s;
        }

        .card button:hover {
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
                            <img src="<?php echo htmlspecialchars($entry['img'] ?? ''); ?>" alt="Fish Image">
                            <div class="copy">
                                <h3 class="subtitle"><?php echo htmlspecialchars($entry['nama_ikan'] ?? ''); ?></h3>
                                <p class="description"><?php echo htmlspecialchars($entry['deskripsi'] ?? ''); ?></p>
                                <p class="description">Price: <?php echo htmlspecialchars($entry['harga'] ?? ''); ?></p>
                            </div>
                            <div class="button-container">
                                <button class="button">Detail</button>
                            </div>
                        </div>
                        <form action="crud.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($entry['id'] ?? ''); ?>">
                            <button type="submit" name="delete" class="button">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="profile-container">
        <img src="profile.png" alt="Profile Image" class="profile-image">
        <h2 class="username"><?= htmlspecialchars($_SESSION["username"] ?? '') ?></h2>
        <form action="crud.php" method="POST">
            <input type="submit" name="logout" value="Logout" class="logout-button">
        </form>
    </div>
</body>
</html>