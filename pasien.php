<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "poliklinik";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menangani form untuk insert/update pasien
if (isset($_POST['submit'])) {
    $nama_pasien = $_POST['nama'];
    $alamat_pasien = $_POST['alamat'];
    $nomor_handphone = $_POST['no_hp'];

    if (isset($_POST['edit_id'])) {
        // Update pasien
        $edit_id = $_POST['edit_id'];

        // Memperbaiki query update dengan parameter yang benar
        $stmt = $conn->prepare("UPDATE pasien SET nama = ?, alamat = ?, no_hp = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nama_pasien, $alamat_pasien, $nomor_handphone, $edit_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Data pasien berhasil diperbarui!</div>";
            header("Location: index.php?page=pasien");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    } else {
        // Insert pasien baru
        $stmt = $conn->prepare("INSERT INTO pasien (nama, alamat, no_hp) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama_pasien, $alamat_pasien, $nomor_handphone);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Data pasien berhasil disimpan!</div>";
            header("Location: index.php?page=pasien");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    }
}

// Menangani penghapusan data pasien
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM pasien WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Data pasien berhasil dihapus!</div>";
        header("Location: index.php?page=pasien");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}

// Menangani form edit
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    $stmt = $conn->prepare("SELECT * FROM pasien WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result_edit = $stmt->get_result();

    if ($result_edit->num_rows > 0) {
        $edit_row = $result_edit->fetch_assoc();
        $nama_pasien_edit = $edit_row['nama'];
        $alamat_pasien_edit = $edit_row['alamat'];
        $nomor_handphone_edit = $edit_row['no_hp'];
    }
}

// Mengambil data pasien
$sql_pasien = "SELECT * FROM pasien";
$result_pasien = $conn->query($sql_pasien);
?>

<div class="container mt-5">
    <h2>Form Input Data Pasien</h2>

    <!-- Form Pasien -->
    <?php if (isset($edit_row)) { ?>
        <!-- Form untuk mengedit data pasien -->
        <form action="" method="POST">
            <input type="hidden" name="edit_id" value="<?= $edit_id ?>">
            <div class="mb-3">
                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" id="nama_pasien" name="nama" value="<?= $nama_pasien_edit ?>" required>

                <label for="alamat_pasien" class="form-label">Alamat Pasien</label>
                <input type="text" class="form-control" id="alamat_pasien" name="alamat" value="<?= $alamat_pasien_edit ?>" required>

                <label for="nomor_handphone" class="form-label">Nomor Handphone Pasien</label>
                <input type="text" class="form-control" id="nomor_handphone" name="no_hp" value="<?= $nomor_handphone_edit ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Simpan Perubahan</button>
        </form>
    <?php } else { ?>
        <!-- Form Input Data Pasien Baru -->
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" id="nama_pasien" name="nama" required>

                <label for="alamat_pasien" class="form-label">Alamat Pasien</label>
                <input type="text" class="form-control" id="alamat_pasien" name="alamat" required>

                <label for="nomor_handphone" class="form-label">Nomor Handphone Pasien</label>
                <input type="text" class="form-control" id="nomor_handphone" name="no_hp" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
        </form>
    <?php } ?>

    <hr>

    <!-- Tabel Data Pasien -->
    <h4>Data Pasien</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_pasien->num_rows > 0) {
                $no = 1;
                while ($row = $result_pasien->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
                    echo "<td>
                        <a href='index.php?page=pasien&edit_id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='index.php?page=pasien&delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data?\")'>Delete</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data pasien</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
