<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

include('koneksi.php');

$folder = "foto/";

// Ambil data dari form
$original_nim = $_POST['original_nim'] ?? null; // Untuk edit
$nim = $_POST['nim'];
$nama = $_POST['nama'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$ponsel = $_POST['ponsel'];

// Validasi input
if(empty($nim) || empty($nama)) {
    die("NIM dan Nama wajib diisi");
}

// Handle upload foto
$foto = null;
if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file_name = uniqid().'_'.basename($_FILES['foto']['name']);
    $target = $folder.$file_name;
    
    if(move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        $foto = $file_name;
        
        // Hapus foto lama jika edit
        if($original_nim) {
            $old = $conn->prepare("SELECT foto FROM data_mahasiswa WHERE nim = ?");
            $old->bind_param("s", $original_nim);
            $old->execute();
            $old_foto = $old->get_result()->fetch_assoc()['foto'];
            if($old_foto && file_exists($folder.$old_foto)) {
                unlink($folder.$old_foto);
            }
        }
    }
}

// Jika ini operasi edit (ada original_nim)
if($original_nim) {
    // Jika NIM diubah ke nilai yang berbeda
    if($original_nim != $nim) {
        // Cek apakah NIM baru sudah digunakan oleh data lain
        $check = $conn->prepare("SELECT nim FROM data_mahasiswa WHERE nim = ? AND nim != ?");
        $check->bind_param("ss", $nim, $original_nim);
        $check->execute();
        if($check->get_result()->num_rows > 0) {
            die("Error: NIM baru sudah terdaftar");
        }
    }
    
    // Query UPDATE (baik NIM diubah atau tidak)
    $sql = "UPDATE data_mahasiswa SET 
            nim = ?, 
            nama = ?, 
            gender = ?, 
            email = ?, 
            ponsel = ?".
            ($foto ? ", foto = ?" : "")." 
            WHERE nim = ?";
    
    $stmt = $conn->prepare($sql);
    if($foto) {
        $stmt->bind_param("sssssss", $nim, $nama, $gender, $email, $ponsel, $foto, $original_nim);
    } else {
        $stmt->bind_param("ssssss", $nim, $nama, $gender, $email, $ponsel, $original_nim);
    }
} else {
    // OPERASI TAMBAH DATA BARU
    // Cek duplikasi NIM
    $check = $conn->prepare("SELECT nim FROM data_mahasiswa WHERE nim = ?");
    $check->bind_param("s", $nim);
    $check->execute();
    if($check->get_result()->num_rows > 0) {
        die("Error: NIM sudah terdaftar");
    }
    
    // Query INSERT
    $sql = "INSERT INTO data_mahasiswa (nim, nama, gender, email, ponsel".
           ($foto ? ", foto" : "").") 
           VALUES (?, ?, ?, ?, ?".
           ($foto ? ", ?" : "").")";
    
    $stmt = $conn->prepare($sql);
    if($foto) {
        $stmt->bind_param("ssssss", $nim, $nama, $gender, $email, $ponsel, $foto);
    } else {
        $stmt->bind_param("sssss", $nim, $nama, $gender, $email, $ponsel);
    }
}

// Eksekusi query
if($stmt->execute()) {
    header("Location: index.php?page=data_mahasiswa&success=1");
} else {
    die("Operasi database gagal: ".$stmt->error);
}

$stmt->close();
$conn->close();
?>