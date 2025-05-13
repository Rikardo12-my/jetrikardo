<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

include("koneksi.php");

$folder = "foto/";

$original_nidn = $_POST['original_nidn'] ?? null; // Untuk edit
$nidn = $_POST['nidn'];
$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$telpon = $_POST['telpon'];

if(empty($nidn) || empty($nama)) {
    die("NIDN dan Nama wajib diisi");
}

$foto = null;
if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file_name = uniqid().'_'.basename($_FILES['foto']['name']);
    $target = $folder.$file_name;
    
    if(move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        $foto = $file_name;
        
        if($original_nidn) {
            $old = $conn->prepare("SELECT foto FROM dosen WHERE nidn = ?");
            $old->bind_param("s", $original_nidn);
            $old->execute();
            $old_foto = $old->get_result()->fetch_assoc()['foto'];
            if($old_foto && file_exists($folder.$old_foto)) {
                unlink($folder.$old_foto);
            }
        }
    }
}

if($original_nidn) {
    if($original_nidn != $nidn) {
        $check = $conn->prepare("SELECT nidn FROM dosen WHERE nidn = ? AND nidn != ?");
        $check->bind_param("ss", $nidn, $original_nidn);
        $check->execute();
        if($check->get_result()->num_rows > 0) {
            die("Error: NIDN baru sudah terdaftar");
        }
    }

    // Query UPDATE
    $sql = "UPDATE dosen SET 
            nidn = ?, 
            nama = ?, 
            jabatan = ?, 
            gender = ?, 
            email = ?, 
            telpon = ?".
            ($foto ? ", foto = ?" : "")."
            WHERE nidn = ?";
    
    $stmt = $conn->prepare($sql);
    if($foto) {
        $stmt->bind_param("ssssssss", $nidn, $nama, $jabatan, $gender, $email, $telpon, $foto, $original_nidn);
    } else {
        $stmt->bind_param("sssssss", $nidn, $nama, $jabatan, $gender, $email, $telpon, $original_nidn);
    }

} else {
    // Tambah data baru
    $check = $conn->prepare("SELECT nidn FROM dosen WHERE nidn = ?");
    $check->bind_param("s", $nidn);
    $check->execute();
    if($check->get_result()->num_rows > 0) {
        die("Error: NIDN sudah terdaftar");
    }

    $sql = "INSERT INTO dosen (nidn, nama, jabatan, gender, email, telpon".
           ($foto ? ", foto" : "").") 
           VALUES (?, ?, ?, ?, ?, ?".
           ($foto ? ", ?" : "").")";

    $stmt = $conn->prepare($sql);
    if($foto) {
        $stmt->bind_param("sssssss", $nidn, $nama, $jabatan, $gender, $email, $telpon, $foto);
    } else {
        $stmt->bind_param("ssssss", $nidn, $nama, $jabatan, $gender, $email, $telpon);
    }
}

// Eksekusi query
if($stmt->execute()) {
    header("Location: index.php?page=dosen&success=1");
} else {
    die("Operasi database gagal: ".$stmt->error);
}

$stmt->close();
$conn->close();
?>
