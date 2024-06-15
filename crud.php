<?php
// Memulai sesi atau melanjutkan sesi yang sudah ada
session_start();

// Mengecek apakah ada permintaan logout yang dikirim melalui metode POST
if (isset($_POST['logout'])) {
    // Menghapus semua variabel sesi
    session_unset();
    // Menghancurkan sesi
    session_destroy();
    // Mengarahkan pengguna ke halaman index.php setelah logout
    header('location: index.php');
    // Menghentikan eksekusi skrip untuk memastikan header() berfungsi dengan benar
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
</head>

<body>
    <!--logout-->
    <form action="crud.php" method="POST">
        <button type="submit" name="logout">logout</button>
    </form>
</body>

</html>