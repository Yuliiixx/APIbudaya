<?php
// Informasi koneksi database
$host = "localhost"; // Lokasi database (biasanya localhost)
$username = "root"; // Username database
$password = ""; // Password database (kosongkan jika tidak ada)
$database = "db_minangkabau"; // Nama database

// Membuat koneksi
$koneksi = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Jika koneksi berhasil
// echo "Koneksi berhasil terhubung ke database '$database'.";
?>
