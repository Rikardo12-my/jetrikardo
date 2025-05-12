<?php
session_start(); // Pastikan session dimulai di sini

include('koneksi.php');

// Mengecek apakah pengguna sudah login


$x = $_GET['nim'];
$sql = "DELETE FROM data_mahasiswa WHERE nim = '$x'";
$exe = $conn->query($sql);

if ($exe) {
    // Redirect ke halaman daftar dosen setelah penghapusan berhasil
    header("Location:index.php?page=data_mahasiswa");
} else {
    echo "Gagal menghapus data.";
}

?>
