<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

include('koneksi.php');

$folder = "foto/";

// Ambil data dari form
$original_nidn = $_POST['original_nidn'] ?? null; // Untuk edit
$nidn = $_POST['nidn'];
$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$telpon = $_POST['telpon'];

// Validasi input wajib
if(empty($nidn) || empty($nama)) {
    die("NIDN dan Nama wajib diisi.");
}

// Cek apakah ini edit atau tambah data
if($original_nidn) {
    // === EDIT DATA DOSEN ===
    
    // Jika NIDN diubah, cek apakah sudah dipakai
    if($original_nidn != $nidn) {
        $check = $conn->prepare("SELECT nidn FROM dosen WHERE nidn = ?");
        $check->bind_param("s", $nidn);
        $check->execute();
        if($check->get_result()->num_rows > 0) {
            die("Error: NIDN baru sudah digunakan.");
        }
    }

    // Cek apakah ada foto baru
    $foto = null;
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $file_name = uniqid().'_'.basename($_FILES['foto']['name']);
        $target = $folder.$file_name;

        if(move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
            $foto = $file_name;

            // Hapus foto lama
            $getOld = $conn->prepare("SELECT foto FROM dosen WHERE nidn = ?");
            $getOld->bind_param("s", $original_nidn);
            $getOld->execute();
            $oldFoto = $getOld->get_result()->fetch_assoc()['foto'];
            if($oldFoto && file_exists($folder.$oldFoto)) {
                unlink($folder.$oldFoto);
            }
        }
    }

    // Buat query update
    $sql = "UPDATE dosen SET 
            nidn = ?, 
            nama = ?, 
            jabatan = ?, 
            gender = ?, 
            email = ?, 
            telpon = ?".($foto ? ", foto = ?" : "")." 
            WHERE nidn = ?";

    $stmt = $conn->prepare($sql);
    if($foto) {
        $stmt->bind_param("ssssssss", $nidn, $nama, $jabatan, $gender, $email, $telpon, $foto, $original_nidn);
    } else {
        $stmt->bind_param("sssssss", $nidn, $nama, $jabatan, $gender, $email, $telpon, $original_nidn);
    }

} else {
    // === TAMBAH DATA BARU ===

    // Cek NIDN duplikat
    $check = $conn->prepare("SELECT nidn FROM dosen WHERE nidn = ?");
    $check->bind_param("s", $nidn);
    $check->execute();
    if($check->get_result()->num_rows > 0) {
        die("Error: NIDN sudah terdaftar.");
    }

    // Proses upload foto
    $foto = null;
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $file_name = uniqid().'_'.basename($_FILES['foto']['name']);
        $target = $folder.$file_name;

        if(move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
            $foto = $file_name;
        }
    }

    // Query insert
    $sql = "INSERT INTO dosen (nidn, nama, jabatan, gender, email, telpon".($foto ? ", foto" : "").")
            VALUES (?, ?, ?, ?, ?, ?".($foto ? ", ?" : "").")";

    $stmt = $conn->prepare($sql);
    if($foto) {
        $stmt->bind_param("sssssss", $nidn, $nama, $jabatan, $gender, $email, $telpon, $foto);
    } else {
        $stmt->bind_param("ssssss", $nidn, $nama, $jabatan, $gender, $email, $telpon);
    }
}

// Eksekusi
if($stmt->execute()) {
    header("Location: index.php?page=dosen");
    exit();
} else {
    die("Operasi database gagal: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
