<?php
include("koneksi.php");

// Ambil data dosen berdasarkan nidn
if(isset($_GET['nidn'])) {
    $nidn = $_GET['nidn'];
    $stmt = $conn->prepare("SELECT * FROM dosen WHERE nidn = ?");
    $stmt->bind_param("s", $nidn);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if(!$row) {
        die("Data dosen tidak ditemukan");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Data Dosen</title>
    <style>
        /* CSS untuk field readonly */
        .readonly-field {
            background-color: #e9ecef;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-secondary text-dark">
    <div class="container mt-4">
        <h1 class="text-center"><i>Edit Data Dosen</i></h1>
        <hr>
        
        <form action="savedos.php" method="post" enctype="multipart/form-data">
            <!-- Simpan NIDN asli sebagai referensi -->
            <input type="hidden" name="original_nidn" value="<?= htmlspecialchars($row['nidn']) ?>">
            
            <div class="mb-3">
                <label class="form-label">NIDN</label>
                <input type="text" name="nidn" class="form-control readonly-field" 
                       value="<?= htmlspecialchars($row['nidn']) ?>" readonly>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" 
                       value="<?= htmlspecialchars($row['nama']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" 
                       value="<?= htmlspecialchars($row['jabatan']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="Laki-Laki" <?= $row['gender'] == 'Laki-Laki' ? 'selected' : '' ?>>Laki-Laki</option>
                    <option value="Perempuan" <?= $row['gender'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" 
                       value="<?= htmlspecialchars($row['email']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="telpon" class="form-control" 
                       value="<?= htmlspecialchars($row['telpon']) ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control">
                <?php if(!empty($row['foto'])): ?>
                    <div class="mt-2">
                        <small>Foto saat ini: <?= htmlspecialchars($row['foto']) ?></small>
                        <input type="hidden" name="current_foto" value="<?= htmlspecialchars($row['foto']) ?>">
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