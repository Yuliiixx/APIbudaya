Berikut adalah README.md untuk API yang disediakan:

# Dokumentasi API

API ini menyediakan endpoint-endpoint untuk membaca data dari beberapa tabel dalam database serta untuk melakukan operasi-operasi CRUD pada tabel pengguna.

## Endpoint

### Membaca Data Berita

- **URL**: `localhost/read.php?data=berita`
- **Metode HTTP**: GET
- **Deskripsi**: Mengembalikan data berita dari tabel `tb_berita`.
- **Parameter**: Tidak ada
- **Response Sukses**:
  ```json
  {
    "sukses": true,
    "status": 200,
    "pesan": "Data berita berhasil diambil",
    "data": [ ...data berita... ]
  }
  ```

### Membaca Data Pegawai

- **URL**: `localhost/read.php?data=pegawai`
- **Metode HTTP**: GET
- **Deskripsi**: Mengembalikan data pegawai dari tabel `tb_pegawai`.
- **Parameter**: Tidak ada
- **Response Sukses**:
  ```json
  {
    "sukses": true,
    "status": 200,
    "pesan": "Data pegawai berhasil diambil",
    "data": [ ...data pegawai... ]
  }
  ```

### Membaca Data Galeri

- **URL**: `localhost/read.php?data=galeri`
- **Metode HTTP**: GET
- **Deskripsi**: Mengembalikan data galeri dari tabel `tb_galeri`.
- **Parameter**: Tidak ada
- **Response Sukses**:
  ```json
  {
    "sukses": true,
    "status": 200,
    "pesan": "Data galeri berhasil diambil",
    "data": [ ...data galeri... ]
  }
  ```

### Membaca Data User

- **URL**: `localhost/read.php?data=user`
- **Metode HTTP**: GET
- **Deskripsi**: Mengembalikan data user dari tabel `tb_user`.
- **Parameter**: Tidak ada
- **Response Sukses**:
  ```json
  {
    "sukses": true,
    "status": 200,
    "pesan": "Data user berhasil diambil",
    "data": [ ...data user... ]
  }
  ```

### Menambahkan User Baru

- **URL**: `localhost/auth.php`
- **Metode HTTP**: POST
- **Deskripsi**: Menambahkan user baru ke dalam tabel `tb_user`.
- **Parameter**:
  - `nama_user` (string): Nama lengkap user baru
  - `alamat_user` (string): Alamat user baru
  - `nohp_user` (string): Nomor HP user baru
  - `username` (string): Username untuk login
  - `password` (string): Password untuk login
- **Response Sukses**:
  ```json
  {
    "sukses": true,
    "status": 200,
    "pesan": "Data user berhasil ditambahkan"
  }
  ```

### Login User

- **URL**: `localhost/auth.php`
- **Metode HTTP**: POST
- **Deskripsi**: Melakukan proses login user.
- **Parameter**:
  - `login` (string): Tanda untuk menandai bahwa ini adalah proses login
  - `username` (string): Username user yang ingin login
  - `password` (string): Password user yang ingin login
- **Response Sukses**:
  ```json
  {
    "sukses": true,
    "status": 200,
    "pesan": "Login berhasil",
    "data": { ...data user yang berhasil login... }
  }
  ```

### Mengedit Data User

- **URL**: `localhost/auth.php`
- **Metode HTTP**: POST
- **Deskripsi**: Mengedit data user yang sudah ada.
- **Parameter**:
  - `edit_user` (string): Tanda untuk menandai bahwa ini adalah proses edit user
  - `id_user` (integer): ID user yang akan diubah
  - `nama_user` (string): Nama lengkap user yang baru
  - `alamat_user` (string): Alamat user yang baru
  - `nohp_user` (string): Nomor HP user yang baru
  - `username` (string): Username baru
  - `password` (string): Password baru
- **Response Sukses**:
  ```json
  {
    "sukses": true,
    "status": 200,
    "pesan": "Data user berhasil diubah"
  }
  ```

# API CRUD Data Pegawai

API ini menyediakan operasi CRUD (Create, Read, Update, Delete) untuk mengelola data pegawai dalam tabel `tb_pegawai`.

## Penggunaan

Base URL: `http://localhost/`

### 1. Mendapatkan Data Pegawai (Read)

**Endpoint**: `/`

**Metode**: GET

**Contoh Permintaan**:
```
GET http://localhost/
```

**Contoh Respon**:
```json
[
    {
        "id_pegawai": 1,
        "nama": "John Doe",
        "no_bp": "BP001",
        "no_hp": "081234567890",
        "email": "john.doe@example.com",
        "created_date": "2024-03-14 12:00:00"
    },
    {
        "id_pegawai": 2,
        "nama": "Jane Doe",
        "no_bp": "BP002",
        "no_hp": "081234567891",
        "email": "jane.doe@example.com",
        "created_date": "2024-03-14 12:01:00"
    }
]
```

### 2. Menambah Data Pegawai (Create)

**Endpoint**: `/`

**Metode**: POST

**Parameter Body**: 
- `nama`: Nama pegawai
- `no_bp`: Nomor BP pegawai
- `no_hp`: Nomor HP pegawai
- `email`: Email pegawai

**Contoh Permintaan**:
```
POST http://localhost/
Body:
{
    "nama": "John Doe",
    "no_bp": "BP001",
    "no_hp": "081234567890",
    "email": "john.doe@example.com",
    "action": "tambah"
}
```

**Contoh Respon**:
```json
{
    "sukses": true,
    "status": 200,
    "pesan": "Data pegawai berhasil ditambahkan"
}
```

### 3. Mengedit Data Pegawai (Update)

**Endpoint**: `/`

**Metode**: POST

**Parameter Body**:
- `id_pegawai`: ID pegawai yang akan diubah
- `nama`: Nama pegawai baru
- `no_bp`: Nomor BP pegawai baru
- `no_hp`: Nomor HP pegawai baru
- `email`: Email pegawai baru

**Contoh Permintaan**:
```
POST http://localhost/
Body:
{
    "id_pegawai": 1,
    "nama": "John Doe",
    "no_bp": "BP001",
    "no_hp": "081234567890",
    "email": "john.doe@example.com",
    "action": "edit"
}
```

**Contoh Respon**:
```json
{
    "sukses": true,
    "status": 200,
    "pesan": "Data pegawai berhasil diperbarui"
}
```

### 4. Menghapus Data Pegawai (Delete)

**Endpoint**: `/`

**Metode**: POST

**Parameter Body**:
- `id_pegawai`: ID pegawai yang akan dihapus

**Contoh Permintaan**:
```
POST http://localhost/
Body:
{
    "id_pegawai": 1,
    "action": "hapus"
}
```

**Contoh Respon**:
```json
{
    "sukses": true,
    "status": 200,
    "pesan": "Data pegawai berhasil dihapus"
}
```

Pastikan untuk menyesuaikan base URL dan hak akses pada API sesuai dengan konfigurasi server Anda.

## Catatan

- Semua endpoint mengembalikan respons dalam format JSON dengan status yang sesuai.
- Pastikan untuk menyertakan parameter yang diperlukan sesuai dengan deskripsi endpoint masing-masing.
- Endpoint untuk menambahkan user baru dan mengedit data user memerlukan autentikasi.