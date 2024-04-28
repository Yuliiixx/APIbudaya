<?php
// include file koneksi.php
include 'koneksi.php';
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');


// Fungsi Create (Tambah Data)
function tambahData($data) {
    global $koneksi;

    $nama = $data['nama'];
    $foto = $data['foto'];
    $tanggal_lahir = $data['tanggal_lahir'];
    $asal = $data['asal'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $deskripsi = $data['deskripsi'];

    $query = "INSERT INTO tb_pahlawan (nama, foto, tanggal_lahir, asal, jenis_kelamin, deskripsi) VALUES ('$nama', '$foto', '$tanggal_lahir', '$asal', '$jenis_kelamin', '$deskripsi')";

    if(mysqli_query($koneksi, $query)) {
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

// Fungsi Read (Ambil Data)
function ambilData() {
    global $koneksi;

    $query = "SELECT * FROM tb_pahlawan";
    $result = mysqli_query($koneksi, $query);

    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return json_encode($data);
}

// Fungsi Update (Edit Data)
function editData($id, $data) {
    global $koneksi;

    $nama = $data['nama'];
    $foto = $data['foto'];
    $tanggal_lahir = $data['tanggal_lahir'];
    $asal = $data['asal'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $deskripsi = $data['deskripsi'];


    $query = "UPDATE tb_pahlawan SET nama='$nama', foto='$foto', tanggal_lahir='$tanggal_lahir', asal='$asal', jenis_kelamin='$jenis_kelamin', deskripsi='$deskripsi' WHERE id_pahlawan=$id";

    if(mysqli_query($koneksi, $query)) {
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

// Fungsi Delete (Hapus Data)
function hapusData($id) {
    global $koneksi;

    $query = "DELETE FROM tb_pahlawan WHERE id_pahlawan=$id";

    if(mysqli_query($koneksi, $query)) {
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
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
            // Cek jenis action
            switch ($action) {
                case 'tambah':
                    // Tambah data
                    echo tambahData($_POST);
                    break;
                case 'edit':
                    // Cek jika parameter id_pahlawan ada
                    if(isset($_POST['id_pahlawan'])) {
                        $id = $_POST['id_pahlawan'];
                        // Edit data
                        echo editData($id, $_POST);
                    } else {
                        echo json_encode(['sukses' => false, 'status' => 400, 'pesan' => 'ID pahlawan tidak ditemukan']);
                    }
                    break;
                case 'hapus':
                    // Cek jika parameter id_pahlawan ada
                    if(isset($_POST['id_pahlawan'])) {
                        $id = $_POST['id_pahlawan'];
                        // Hapus data
                        echo hapusData($id);
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
