<?php

include 'koneksi.php';
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');


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


// Endpoint untuk membaca data makanan
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'makanan') {
    $data = bacaDataMakanan();
    kirimResponse(true, 200, 'Data makanan berhasil diambil', $data);
}



// Menutup koneksi database
mysqli_close($koneksi);
?>
