<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Form Penginputan Data Dosen</title>
</head>
<body class="bg-secondary text-dark">

    <h1 class="text-center mt-1  "><i>Penginputan Data Dosen</i></h1>
    <hr class="mb-0">
     <form action="savedos.php" method="post" class="mt-0" enctype="multipart/form-data">
   
        <div >
            <label for="disabledTextInput" class="form-label" >Nidn</label>
            <input type="text" id="disabledTextInput" name="nidn" class="form-control" placeholder="Input Nidn">
        </div>
        <div>
            <label for="disabledTextInput" class="form-label">Nama</label>
            <input type="text" id="disabledTextInput" name="nama" class="form-control" placeholder="Input Nama">
        </div>
        <div>
            <label for="disabledTextInput" class="form-label">Jabatan</label>
            <input type="text" id="disabledTextInput" name="jabatan" class="form-control" placeholder="Input Jabatan">
        </div>

        <label for="Select" class="form-label">Gender</label>
            <select id="disabledSelect" name="gender" class="form-select">
                <option>Select Gender...</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

       <div>
            <label for="disabledTextInput" class="form-label">Email</label>
            <input type="text" id="disabledTextInput" name="email" class="form-control" placeholder="Input Email">
       </div>
        <div>
            <label for="disabledTextInput" class="form-label">Ponsel</label>
            <input type="text" id="disabledTextInput" name="telpon" class="form-control" placeholder="Input Nomor">
        </div>
        <div>
            <label for="disabledTextInput" class="form-label">Foto</label>
            <input type="file" id="foto" name="foto" id="" class="form-control" placeholder="Input Foto"> <br>
        </div>
        <button type="submit" class="btn btn-primary mb-3 mg-3">Submit</button>
   
 </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>