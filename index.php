<?php
session_start();

include_once("koneksi.php");

// Log out jika tombol logout diklik
if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    session_unset();  // Menghapus session
    session_destroy();  // Menghancurkan session
    header("Location: login.php");  // Redirect ke halaman login
    exit();
}

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Periksa Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #6f42c1;
        }
        .navbar-custom a {
            color: white;
        }
        .container {
            max-width: 900px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data Master
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?page=pasien">Pasien</a></li>
                            <li><a class="dropdown-item" href="index.php?page=dokter">Dokter</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=periksa">Pemeriksaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main role="main" class="container my-4">
        <?php
        // Load the requested page if it exists
        if (isset($_GET['page'])) {
            $page = basename($_GET['page']); // Sanitize the input to avoid directory traversal
            $allowed_pages = ['loginUser', 'registrasiUser', 'dokter', 'pasien', 'periksa'];
            
            if (in_array($page, $allowed_pages) && file_exists($page . ".php")) {
                echo "<h2>" . ucwords($page) . "</h2>";
                include($page . ".php");
            } else {
                echo "<div class='alert alert-danger'>Page not found.</div>";
            }
        } else {
            echo "<h2>Selamat Datang di Sistem Informasi Poliklinik</h2>";
        }
        ?>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
