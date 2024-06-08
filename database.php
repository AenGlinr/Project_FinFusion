<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "finfusion";

//connect database
$db = mysqli_connect($hostname, $username, $password, $database_name);

//jika koneksi database gagal menampilkan ini
if ($db->connect_error) {
    echo "koneksi database rusak";
    die("error!");
}
