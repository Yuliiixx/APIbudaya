<?php

include 'koneksi.php';
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');


// Fungsi untuk membaca data dari tabel berita
function bacaDataBerita() {
    global $koneksi;
    $sql = "SELECT * FROM tb_berita";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk membaca data dari tabel pahlawan
function bacaDataPahlawan() {
    global $koneksi;
    $sql = "SELECT * FROM tb_pahlawan";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk membaca data dari tabel makanan
function bacaDataMakanan() {
    global $koneksi;
    $sql = "SELECT * FROM tb_makanan";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk membaca data dari tabel alat musik
function bacaDataAlatmusik() {
    global $koneksi;
    $sql = "SELECT * FROM tb_alatmusik";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk membaca data dari tabel pakaian
function bacaDataPakaian() {
    global $koneksi;
    $sql = "SELECT * FROM tb_pakaian";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk membaca data dari tabel culture
function bacaDataCulture() {
    global $koneksi;
    $sql = "SELECT * FROM tb_culture";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk membaca data dari tabel user
function bacaDataUser() {
    global $koneksi;
    $sql = "SELECT * FROM tb_user";
    $result = mysqli_query($koneksi, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

// Fungsi untuk mengembalikan response API
function kirimResponse($sukses, $status, $pesan, $data) {
    $response = [
        'sukses' => $sukses,
        'status' => $status,
        'pesan' => $pesan,
        'data' => $data
    ];
    echo json_encode($response);
}

// Endpoint untuk membaca data berita
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'berita') {
    $data = bacaDataBerita();
    kirimResponse(true, 200, 'Data berita berhasil diambil', $data);
}

// Endpoint untuk membaca data pahlawan
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'pahlawan') {
    $data = bacaDataPahlawan();
    kirimResponse(true, 200, 'Data pahlawan berhasil diambil', $data);
}

// Endpoint untuk membaca data makanan
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'makanan') {
    $data = bacaDataMakanan();
    kirimResponse(true, 200, 'Data makanan berhasil diambil', $data);
}

// Endpoint untuk membaca data alat musik
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'alatmusik') {
    $data = bacaDataAlatmusik();
    kirimResponse(true, 200, 'Data alatmusik berhasil diambil', $data);
}

// Endpoint untuk membaca data pakaian
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'pakaian') {
    $data = bacaDataPakaian();
    kirimResponse(true, 200, 'Data pakaian berhasil diambil', $data);
}

// Endpoint untuk membaca data culture
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'culture') {
    $data = bacaDataCulture();
    kirimResponse(true, 200, 'Data culture berhasil diambil', $data);
}

// Endpoint untuk membaca data user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'user') {
    $data = bacaDataUser();
    kirimResponse(true, 200, 'Data user berhasil diambil', $data);
}

// Menutup koneksi database
mysqli_close($koneksi);
?>
