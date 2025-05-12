<?php
include('koneksi.php');
    $x = $_GET['nidn'];
    $sql = "delete from dosen where nidn='$x'";
    $exe = $conn->query($sql);
    if($exe){
        header("Location:index.php?page=dosen");
    }else{
        echo "Gak gacorr";
    }
?>