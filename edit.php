<?php
include("koneksi.php");

$nim = $_GET['nim'] ?? die("NIM tidak valid");

// Ambil data yang akan diedit
$stmt = $conn->prepare("SELECT * FROM data_mahasiswa WHERE nim = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if(!$data) {
    die("Data tidak ditemukan");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Data Mahasiswa</title>
</head>
<body class="bg-secondary text-dark">
    <div class="container mt-4">
        <h1 class="text-center"><i>Edit Data Mahasiswa</i></h1>
        <hr>
        
        <form action="save.php" method="post" enctype="multipart/form-data">
            <!-- Hidden field untuk menyimpan NIM asli -->
            <input type="hidden" name="original_nim" value="<?= htmlspecialchars($data['nim']) ?>">
            
            <div class="mb-3">
                <label class="form-label">NIM</label>
                <input type="text" name="nim" class="form-control" 
                       value="<?= htmlspecialchars($data['nim']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" 
                       value="<?= htmlspecialchars($data['nama']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="Laki-Laki" <?= $data['gender'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                    <option value="Perempuan" <?= $data['gender'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="<?= htmlspecialchars($data['email']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nomor Ponsel</label>
                <input type="text" name="ponsel" class="form-control" 
                       value="<?= htmlspecialchars($data['ponsel']) ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control">
                <?php if(!empty($data['foto'])): ?>
                    <div class="mt-2">
                        <small>Foto saat ini: <?= htmlspecialchars($data['foto']) ?></small>
                        <input type="hidden" name="current_foto" value="<?= htmlspecialchars($data['foto']) ?>">
                    </div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>