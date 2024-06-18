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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fishName = $db->real_escape_string(htmlspecialchars($_POST['name'] ?? ''));
    $description = $db->real_escape_string(htmlspecialchars($_POST['description'] ?? ''));
    $price = $db->real_escape_string(htmlspecialchars($_POST['price'] ?? ''));

    // Update data into database
    $sql = "UPDATE ikan SET nama_ikan = '$fishName', deskripsi = '$description', harga = '$price' WHERE id = $id";

    if ($db->query($sql) === TRUE) {
        echo "Data updated successfully";
    } else {
        echo "Error updating record: " . $db->error;
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Fish</title>
</head>
<body>
    <h1>Update Fish</h1>
    <form action="formupdate.php?id=<?php echo $id; ?>" method="POST">
        <label for="name">Fish Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['nama_ikan']); ?>"><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"><?php echo htmlspecialchars($row['deskripsi']); ?></textarea><br>
        
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($row['harga']); ?>"><br><br>
        
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
