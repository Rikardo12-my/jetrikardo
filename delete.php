<?php
session_start(); 

include('koneksi.php');




$x = $_GET['nim'];
$sql = "DELETE FROM data_mahasiswa WHERE nim = '$x'";
$exe = $conn->query($sql);

if ($exe) {
   
    header("Location:index.php?page=data_mahasiswa");
} else {
    echo "Gagal menghapus data.";
}

?>
