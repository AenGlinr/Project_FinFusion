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

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: crud.php'); // Redirect if no ID provided
    exit();
}

// Fetch existing fish details
$sql = "SELECT * FROM ikan WHERE id = $id";
$result = $db->query($sql);

if (!$result || $result->num_rows === 0) {
    echo "Fish not found.";
    exit();
}

$row = $result->fetch_assoc();

// Handle form submission
$updateSuccess = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fishName = $db->real_escape_string(htmlspecialchars($_POST['name'] ?? ''));
    $description = $db->real_escape_string(htmlspecialchars($_POST['description'] ?? ''));
    $price = $db->real_escape_string(htmlspecialchars($_POST['price'] ?? ''));
    $stock = $db->real_escape_string(htmlspecialchars($_POST['stock'] ?? ''));

    // Upload new image if provided
    $imagePath = 'uploads/';
    if ($_FILES['image']['size'] > 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $imageUniqueName = uniqid('img_') . '.' . $imageFileType;
        $fullImagePath = $imagePath . $imageUniqueName;

        // Move uploaded file to destination directory
        if (move_uploaded_file($imageTmpName, $fullImagePath)) {
            // Update image path in database
            $sqlImageUpdate = "UPDATE ikan SET img = '$fullImagePath' WHERE id = $id";
            if ($db->query($sqlImageUpdate) !== TRUE) {
                echo "Error updating image path: " . $db->error;
            }
        } else {
            echo "Upload gambar gagal. Error: " . $_FILES['image']['error'];
        }
    }

    // Update other data into database
    $sql = "UPDATE ikan SET nama_ikan = '$fishName', deskripsi = '$description', harga = '$price', stok = '$stock' WHERE id = $id";

    if ($db->query($sql) === TRUE) {
        $updateSuccess = true;
    } else {
        echo "Error updating record: " . $db->error;
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Fish Entry</title>
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

        .update-form {
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
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .alert {
            display: none;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }

    </style>
</head>
<body>
    <div class="container">
        <header>
            <h2>Update Fish Entry</h2>
        </header>
        <?php if ($updateSuccess): ?>
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                Data updated successfully
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = 'crud.php';
                }, 2000);
            </script>
        <?php endif; ?>
        <form class="update-form" action="formupdate.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Image:</label><br>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="name">Fish Name:</label><br>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['nama_ikan']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label><br>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($row['harga']); ?>" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($row['stok']); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Update</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($updateSuccess): ?>
                document.querySelector('.alert').style.display = 'block';
            <?php endif; ?>
        });
    </script>
</body>
</html>
