<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>From Data Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
           /* Reduce margin or padding of the header */
   header {
       margin-bottom: 10px; /* Adjust as necessary */
       padding: 5px; /* Adjust as necessary */
   }

   /* Adjust table margin */
   table {
       margin-top: 0; /* Set to zero or a small value */
   }
   
    </style>
</head>
<body class="bg-secondary">

        <?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
    
   
    <div class="w-100 bg-secondary text-white py-4 text-center">
        <h1 class="mb-n3 fw-bold fst-italic">Daftar Data Dosen</h1>
    </div>
    <table class="table table-dark table-striped">
         <tr>
            <td>Nidn</td>
            <td>Nama</td>
            <td>Jabatan</td>
            <td>Gender</td>
            <td>Email</td>
            <td>Telpon</td>
            <td>Foto</td>
            <td><i>Proses</i></td>
        </tr>
        
                <?php
            include("koneksi.php");
            $username = $_SESSION['username'];
            $sql = "select * from dosen ";
            $result = $conn -> query($sql);
            while ($data = $result -> fetch_assoc()){
            ?>
            
            <tr>
                <td><?php echo $data['nidn']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['jabatan']; ?></td>
                <td><?php echo $data['gender']; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><?php echo $data['telpon']; ?></td>
                <td>
                    <img src="foto/<?= htmlspecialchars($data['foto'])?>" width="85" height="90" alt="Foto">
                </td>
                <td>
                    <a href="editdos.php?nidn=<?= $data['nidn']?>"><button type="submit" class="btn btn-info rounded-pill">edit!</button></a>
                    <a href="deletedos.php?nidn=<?= $data['nidn']?>" onclick="return confirm('Yakin Menghapus??')"><button type="submit" class="btn btn-danger rounded-pill">hapus!</button></a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <a href="formdos.php" class="text-light" style="text-decoration: underline; text-decoration-color: white;">
        <button type="submit" class="btn btn-light rounded-pill">Tambah Data!!</button>
    </a>

    <script>
        function addDataMahasiswa() {
  const data = {
    nim: document.getElementById("nim").value,
    nama: document.getElementById("nama").value,
    gender: document.getElementById("gender").value,
    email: document.getElementById("email").value,
    ponsel: document.getElementById("ponsel").value
  };

  fetch('/addMahasiswa', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Perbarui tabel data mahasiswa
      loadDataMahasiswa();
    } else {
      alert('Gagal menambah data! ' + data.message);
    }
  });
}

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>