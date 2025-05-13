<?php
session_start();
include "koneksi.php";

// Daftar halaman yang boleh diakses
$allowed_pages = ['home', 'dosen', 'data_mahasiswa', 'login', 'regis', 'formdos'];
$page = $_GET['page'] ?? 'home';


if (!in_array($page, $allowed_pages)) {
    $page = 'home';


$check = $conn->prepare("SELECT nim FROM data_mahasiswa WHERE nim = ?");
$check->bind_param("s", $nim);
$check->execute();

if($check->get_result()->num_rows > 0) {

    die("NIM sudah terdaftar. Silakan gunakan NIM lain.");
} else {

    $stmt = $conn->prepare("INSERT INTO data_mahasiswa (...) VALUES (...)");
    // ... lanjutkan proses insert
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Website Akademik</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #BDC3C7;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .container-wrapper {
            flex: 1;
            padding-bottom: 60px; /* Space for footer */
        }
        
        footer {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: relative;
            margin-top: auto;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .navbar {
            margin-bottom: 20px;
        }
        
 
        .main-content {
            margin-bottom: 20px;
        }
      
.table-responsive {
    margin-top: 0 !important;
}

.table {
    margin-bottom: 0.5rem !important;
}

.card-body {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
}


.card {
    margin-top: 0;
    border-top: none;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
    </style>
</head>
<body class="bg-secondary">

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <a class="navbar-brand" href="index.php?page=home"><i class="fas fa-university fa-sm me-2"></i>Kampus -Umi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=home">
                    <i class="fas fa-home me-2"></i>Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=dosen">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Dosen
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=data_mahasiswa">
                    <i class="fas fa-user-graduate me-2"></i>Mahasiswa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            </li>
        </ul>
        <span class="navbar-text ms-auto text-body-secondary">
            <i>Indonesian Christian College.</i>
        </span>
    </div>
</nav>

<!-- Main Content Wrapper -->
<div class="container-wrapper">
    <div class="container main-content">
        <?php
        switch ($page) {
            case 'dosen':
                if (file_exists('readdos.php')) {
                    include 'readdos.php';
                } else {
                    echo "Halaman dosen tidak ditemukan.";
                }
                break;
            case 'data_mahasiswa':
                if (file_exists('read.php')) {                
                    include 'read.php';
                } else {
                    echo "Halaman data mahasiswa tidak ditemukan.";
                }
                break;
            case 'login':
                if (file_exists('login.php')) {
                    include 'login.php';
                } else {
                    echo "Halaman login tidak ditemukan.";
                }
                break;
            case 'edit':
                if (file_exists('edit.php')) {
                    include 'index.php';
                } else {
                    echo "Halaman edit tidak ditemukan.";
                }
                break;
            case 'updatedos':
                if (file_exists('updatedos.php')) {
                    include 'updatedos.php';
                } else {
                    echo "Halaman login tidak ditemukan.";
                }
                break;
            case 'regis':
                if (file_exists('regis.php')) {
                    include 'regis.php';
                } else {
                    echo "Halaman registrasi tidak ditemukan.";
                }
                break;
            case 'formdos':
                if (file_exists('formdos.php')) {
                    include 'formdos.php';
                } else {
                    echo "Halaman form dosen tidak ditemukan.";
                }
                break;
            case 'deletedos':
                if (file_exists('deletedos.php')) {
                    include 'deletedos.php';
                } else {
                    echo "Halaman form dosen tidak ditemukan.";
                }
                break;
            case 'editdos':
                if (file_exists('editdos.php')) {
                    include 'editdos.php';
                } else {
                    echo "Halaman form dosen tidak ditemukan.";
                }
                break;
            case 'daftar':
                if (file_exists('daftar.php')) {
                    include 'daftar.php';
                } else {
                    echo "Halaman form dosen tidak ditemukan.";
                }
                break;
            case 'home':
                echo "<h3>Selamat Datang di Sistem Informasi Akademik</h3>";
                if (file_exists('home.php')) {
                    include 'home.php';
                }
                break;
            default:
                break;
        }
        ?>
    </div>
</div>

<!-- Footer -->
<footer>
    &copy; <?= date('Y') ?> - Sistem Akademik
</footer>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
