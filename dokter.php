<?php
// Mengecek apakah form disubmit
if (isset($_POST['submit'])) {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nomor_handphone = $_POST['no_hp'];

    // Query untuk memasukkan data ke dalam tabel dokter
    $sql = "INSERT INTO dokter (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$nomor_handphone')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Dokter berhasil ditambahkan!</div>";
        
        // Redirect setelah berhasil menambah data untuk menghindari pengulangan
        header("Location: " . $_SERVER['PHP_SELF']);
        exit; // Pastikan script berhenti setelah redirect
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Ambil data dokter dari database
$sql = "SELECT * FROM dokter";
$result = $conn->query($sql);
?>

<div class="container mt-5">
    <h2>Form Input Dokter</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor Handphone</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
    </form>

    <hr>

    <h4>Data Dokter</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nomor Handphone</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data dokter</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
