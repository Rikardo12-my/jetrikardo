<?php
include('koneksi.php');

$username = $_POST['username'];
$password = $_POST['password'];
$email    = $_POST['email'];

$sql = "INSERT INTO register (username, password, email) VALUES ('$username', '$password', '$email')";

if ($conn->query($sql)) {
    header("Location:index.php?page=login");
} else {
    echo "Gagal mendaftar: " . $conn->error;
}
?>
