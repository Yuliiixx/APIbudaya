<?php
// include file koneksi.php
include 'koneksi.php';
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');

// Fungsi untuk mengambil data pahlawan dari database
function ambilData() {
    global $koneksi;

    $query = "SELECT * FROM tb_pahlawan";
    $result = mysqli_query($koneksi, $query);

    $pahlawan = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pahlawan[] = $row;
        }
    }

    return json_encode($pahlawan);
}

// Fungsi untuk menghasilkan nama file acak untuk foto pahlawan
function generateRandomFileName($prefix = '', $suffix = '') {
    // Generate unique ID
    $uniqueId = uniqid();

    // Menggunakan md5 untuk membuat hash dari unique ID
    $randomHash = md5($uniqueId);

    // Menggabungkan prefix, hash acak, dan akhiran file jika diperlukan
    $randomFileName = $prefix . $randomHash . $suffix;

    return $randomFileName;
}

// Fungsi tambah data pahlawan
function tambahDataPahlawan($data) {
    global $koneksi;

    $nama = $data['nama'];
    $foto = $data['foto'];
    $tanggal_lahir = $data['tanggal_lahir'];
    $asal = $data['asal'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $deskripsi = $data['deskripsi'];

    $outputfile = "gambar/" . generateRandomFileName('foto', ''); // Menghilangkan ekstensi file
    $filehandler = fopen($outputfile, 'wb');
    fwrite($filehandler, base64_decode($foto));
    fclose($filehandler);

    $query = "INSERT INTO tb_pahlawan (nama, foto, tanggal_lahir, asal, jenis_kelamin, deskripsi) VALUES ('$nama', '$outputfile', '$tanggal_lahir', '$asal', '$jenis_kelamin', '$deskripsi')";

    if (mysqli_query($koneksi, $query)) {
        $response = [
            'sukses' => true,
            'status' => 200,
            'pesan' => 'Data pahlawan berhasil ditambahkan'
        ];
    } else {
        $response = [
            'sukses' => false,
            'status' => 500,
            'pesan' => 'Gagal menambahkan data pahlawan: ' . mysqli_error($koneksi)
        ];
    }

    return json_encode($response);
}

// Fungsi edit data pahlawan
function editDataPahlawan($data) {
    global $koneksi;

    // Cek apakah parameter ID pahlawan ada
    if (!isset($data['id_pahlawan'])) {
        return json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'ID pahlawan tidak ditemukan']);
    }

    $id_pahlawan = $data['id_pahlawan']; // Perubahan disini
    $nama = $data['nama'];
    $tanggal_lahir = $data['tanggal_lahir'];
    $asal = $data['asal'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $deskripsi = $data['deskripsi'];

    // Cek keberadaan ID pahlawan dalam database sebelum melakukan edit
    $queryCekId = "SELECT id_pahlawan FROM tb_pahlawan WHERE id_pahlawan = '$id_pahlawan'";
    $resultCekId = mysqli_query($koneksi, $queryCekId);
    
    if (mysqli_num_rows($resultCekId) == 0) {
        return json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'ID pahlawan tidak ditemukan']);
    }

    // Proses edit data pahlawan...
    $query = "UPDATE tb_pahlawan SET nama = '$nama', tanggal_lahir = '$tanggal_lahir', asal = '$asal', jenis_kelamin = '$jenis_kelamin', deskripsi = '$deskripsi' WHERE id_pahlawan = '$id_pahlawan'";

    if (mysqli_query($koneksi, $query)) {
        $response = [
            'sukses' => true,
            'status' => 200,
            'pesan' => 'Data pahlawan berhasil diperbarui'
        ];
    } else {
        $response = [
            'sukses' => false,
            'status' => 500,
            'pesan' => 'Gagal memperbarui data pahlawan: ' . mysqli_error($koneksi)
        ];
    }

    return json_encode($response);
}

// Fungsi hapus data pahlawan
function hapusDataPahlawan($id_pahlawan) {
    global $koneksi;

    // Ambil lokasi foto pahlawan sebelum dihapus
    $querySelectFoto = "SELECT foto FROM tb_pahlawan WHERE id_pahlawan = '$id_pahlawan'"; // Perubahan disini
    $resultSelectFoto = mysqli_query($koneksi, $querySelectFoto);
    $row = mysqli_fetch_assoc($resultSelectFoto);
    $foto = $row['foto'];

    // Jika foto pahlawan ada, hapus foto dari server
    if (!empty($foto) && file_exists($foto)) {
        unlink($foto);
    }

    // Buat query untuk hapus data pahlawan dari database
    $query = "DELETE FROM tb_pahlawan WHERE id_pahlawan='$id_pahlawan'"; // Perubahan disini

    if (mysqli_query($koneksi, $query)) {
        $response = [
            'sukses' => true,
            'status' => 200,
            'pesan' => 'Data pahlawan berhasil dihapus'
        ];
    } else {
        $response = [
            'sukses' => false,
            'status' => 500,
            'pesan' => 'Gagal menghapus data pahlawan: ' . mysqli_error($koneksi)
        ];
    }

    return json_encode($response);
}

// Main Program
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Ambil data
        echo ambilData();
        break;
    case 'POST':
        // Cek jika parameter action ada
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            // Cek jenis action
            switch ($action) {
                case 'tambah':
                    // Tambah data
                    echo tambahDataPahlawan($_POST);
                    break;
                case 'edit':
                    // Cek jika parameter id_pahlawan ada
                    if (isset($_POST['id_pahlawan'])) {
                        $id_pahlawan = $_POST['id_pahlawan']; // Perubahan disini
                        // Edit data
                        echo editDataPahlawan($_POST);
                    } else {
                        echo json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'ID pahlawan tidak ditemukan']);
                    }
                    break;
                case 'hapus':
                    // Cek jika parameter id_pahlawan ada
                    if (isset($_POST['id_pahlawan'])) {
                        $id_pahlawan = $_POST['id_pahlawan']; // Perubahan disini
                        // Hapus data
                        echo hapusDataPahlawan($id_pahlawan);
                    } else {
                        echo json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'ID pahlawan tidak ditemukan']);
                    }
                    break;
                default:
                    echo json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'Aksi tidak valid']);
                    break;
            }
        } else {
            echo json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'Aksi tidak ditemukan']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['sukses' => false, 'status' => 405, 'pesan' => 'Method tidak diizinkan']);
        break;
}
?>
