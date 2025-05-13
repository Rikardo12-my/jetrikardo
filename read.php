<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: cadetblue;
        }
    </style>
</head>
<body>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<h2 class="text-center" style="font-weight: bold; font-style: italic; font-size: 30px; font-family: Arial, sans-serif;">Data Mahasiswa</h2>
<br>

<table class="table table-dark table-striped ">
    <tr>
        <th>NIM</th>
        <th>Nama</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Ponsel</th>
        <th>Foto</th>
        <th><i>Proses</i></th>
    </tr>

    <?php
    include('koneksi.php');
    $sql = "SELECT * FROM data_mahasiswa"; 
    $result = $conn->query($sql);

    while ($data = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= htmlspecialchars($data['nim']) ?></td>
            <td><?= htmlspecialchars($data['nama']) ?></td>
            <td><?= htmlspecialchars($data['gender']) ?></td>
            <td><?= htmlspecialchars($data['email']) ?></td>
            <td><?= htmlspecialchars($data['ponsel']) ?></td>
            <td>
                <img src="foto/<?= htmlspecialchars($data['foto']) ?>" width="90" height="85" alt="Foto">
            </td>
            <td>
                <a href="edit.php?nim=<?= $data['nim'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?nim=<?= $data['nim'] ?>" onclick="return confirm('Yakin menghapus?')" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<div class="mb-3">
    <a href="form.php" class="btn btn-light">Tambah Data</a>
    <a href="logout.php" class="btn btn-secondary">Logout</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
