<?php
$databaseHost = 'localhost';
$databaseName = 'poliklinik'; // nama database
$databaseUsername = 'root'; // kalau ini username dari databasemu yakk
$databasePassword = ''; // password


// Ini buat connect ke database
$conn = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// Nek ini buat cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>