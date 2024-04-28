<?php
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');


// Fungsi untuk mengirim response dalam format JSON
function kirimResponse($sukses, $status, $pesan, $data = null) {
    $response = [
        'sukses' => $sukses,
        'status' => $status,
        'pesan' => $pesan
    ];

    if ($data !== null) {
        $response['data'] = $data;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

// Fungsi untuk membaca data user
function bacaDataUser($koneksi) {
    $query = "SELECT * FROM tb_user";
    $result = mysqli_query($koneksi, $query);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

// Endpoint untuk membaca data user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data']) && $_GET['data'] === 'user') {
    include 'koneksi.php'; // Include file koneksi ke database
    $data = bacaDataUser($koneksi);
    kirimResponse(true, 200, 'Data user berhasil diambil', $data);
}

// Endpoint untuk menambahkan user baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_user'])) {
    include 'koneksi.php'; // Include file koneksi ke database
    $nama_user = $_POST['nama_user'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = tambahUser($koneksi, $nama_user, $email, $password);
    echo $result;
}

// Endpoint untuk login user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    include 'koneksi.php'; // Include file koneksi ke database
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = loginUser($koneksi, $email, $password);
    echo $result;
}

// Endpoint untuk mengedit data user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    include 'koneksi.php'; // Include file koneksi ke database
    $id_user = $_POST['id_user'];
    $nama_user = $_POST['nama_user'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = editUser($koneksi, $id_user, $nama_user, $email, $password);
    echo $result;
}

// Fungsi tambahUser
function tambahUser($koneksi, $nama_user, $email, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO tb_user (nama_user, email, password) VALUES ('$nama_user', '$email', '$hashed_password')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $response = [
            'sukses' => true,
            'status' => 200,
            'pesan' => 'Data user berhasil ditambahkan'
        ];
    } else {
        $response = [
            'sukses' => false,
            'status' => 400,
            'pesan' => 'Gagal menambahkan data user'
        ];
    }

    return json_encode($response);
}

// Fungsi loginUser
function loginUser($koneksi, $email, $password) {
    $query = "SELECT * FROM tb_user WHERE email='$email'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $response = [
                'sukses' => true,
                'status' => 200,
                'pesan' => 'Login berhasil',
                'data' => $row
            ];
        } else {
            $response = [
                'sukses' => false,
                'status' => 401,
                'pesan' => 'Login gagal, email atau password salah',
                'data'=> null
            ];
        }
    } else {
        $response = [
            'sukses' => false,
            'status' => 401,
            'pesan' => 'Login gagal, email atau password salah',
            'data'=> null
        ];
    }

    return json_encode($response);
}
// Fungsi editUser
function editUser($koneksi, $id_user, $nama_user, $email, $password) {
    // Periksa apakah password baru kosong
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE tb_user SET nama_user='$nama_user',  email='$email', password='$hashed_password' WHERE id_user=$id_user";
    } else {
        // Jika password kosong, gunakan password lama
        $query = "UPDATE tb_user SET nama_user='$nama_user',  email='$email' WHERE id_user=$id_user";
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $response = [
            'sukses' => true,
            'status' => 200,
            'pesan' => 'Data user berhasil diubah'
        ];
    } else {
        $response = [
            'sukses' => false,
            'status' => 400,
            'pesan' => 'Gagal mengubah data user'
        ];
    }

    return json_encode($response);
}


?>
