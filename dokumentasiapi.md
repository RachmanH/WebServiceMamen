# Dokumentasi API SIAKAD - Postman Collection

> **Status:** [PRODUCTION]
> **Version:** 1.0.0
> **Base URL:** `{{base_url}}` (Ganti dengan URL server Anda, contoh: `http://localhost:8000/api`)

---

## ⚠️ PENTING - Troubleshooting

### Masalah: Response HTML bukan JSON

**Symptom:**
```
Status: 200 OK
Response: <!DOCTYPE html><html>...Laravel welcome page...
```

**Penyebab:**
URL request tidak menggunakan `/api` prefix. Contoh:
- ❌ SALAH: `PUT /matakuliah/1` → response HTML
- ✅ BENAR: `PUT /api/matakuliah/1` → response JSON

**Solusi:**

1. **Cek Collection Variable `base_url`:**
   - Buka Postman Collection
   - Tab **Variables** di atas
   - Pastikan `base_url = http://localhost:8000/api` (dengan `/api`)
   - Bukan `http://localhost:8000` (tanpa `/api`)

2. **Atau gunakan URL lengkap:**
   - Ganti `{{base_url}}/matakuliah/1`
   - Dengan `http://localhost:8000/api/matakuliah/1`

3. **Pastikan Headers ada:**
   ```
   Content-Type: application/json
   Accept: application/json
   ```

---

## Daftar Isi

1. [01 Authentication](#01-authentication)
2. [02 Master Data Mahasiswa](#02-master-data-mahasiswa)
3. [03 Master Data Dosen](#03-master-data-dosen)
4. [04 Akademik - Mata Kuliah](#04-akademik---mata-kuliah)
5. [05 Fasilitas - Ruang Kelas](#05-fasilitas---ruang-kelas)
6. [06 Operasional - Jadwal Perkuliahan](#06-operasional---jadwal-perkuliahan)
7. [Endpoint Tambahan](#endpoint-tambahan)

---

## 01 Authentication

### Deskripsi Folder

Folder ini mengelola autentikasi pengguna sistem SIAKAD.

> **Catatan:** Saat ini endpoint authentication menggunakan default Laravel. Untuk implementasi JWT, tambahkan package `tymon/jwt-auth`.

### Endpoint yang Tersedia

| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/users` | Mengambil daftar pengguna terdaftar |

---

## 02 Master Data Mahasiswa

### Deskripsi Folder

`STATUS: PRODUCTION`

Folder ini mengelola seluruh informasi biodata mahasiswa.

#### Aturan Penggunaan
- NIM bersifat **unik** dan **immutable** (tidak dapat diubah)
- Format data wajib JSON dengan Content-Type: `application/json`
- Mendukung response format XML dengan header `Accept: application/xml`

### 2.1 GET /datamahasiswa - List All Students

`STATUS: PRODUCTION`

Endpoint untuk mengambil daftar mahasiswa dengan pagination.

#### Request

```http
GET {{base_url}}/datamahasiswa
Accept: application/json
```

#### Parameters (Query String)

| Parameter | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `page` | Integer | Tidak | Nomor halaman (default: 1) |
| `per_page` | Integer | Tidak | Jumlah data per halaman (default: 10) |

#### Response Examples

**200 OK - Success (JSON)**
```json
{
  "data": [
    {
      "id": 1,
      "nim": "2024001",
      "nama": "Ahmad Rizky",
      "email": "ahmad.rizky@student.uhb.ac.id",
      "prodi": "Informatika",
      "created_at": "2026-01-15T08:00:00.000000Z"
    }
  ]
}
```

**200 OK - Success (XML)**
```xml
<?xml version="1.0" encoding="UTF-8"?>
<mahasiswa_list>
  <mahasiswa>
    <id>1</id>
    <nim>2024001</nim>
    <nama>Ahmad Rizky</nama>
    <email>ahmad.rizky@student.uhb.ac.id</email>
    <prodi>Informatika</prodi>
    <created_at>2026-01-15T08:00:00.000000Z</created_at>
  </mahasiswa>
</mahasiswa_list>
```

---

### 2.2 POST /datamahasiswa - Create Student

`STATUS: PRODUCTION`

Endpoint untuk menambahkan data mahasiswa baru.

#### Request

```http
POST {{base_url}}/datamahasiswa
Content-Type: application/json
```

#### Request Body

| Field | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `nim` | String | Ya | Nomor Induk Mahasiswa (unik) |
| `nama` | String | Ya | Nama lengkap mahasiswa |
| `email` | String | Ya | Email aktif mahasiswa |
| `prodi` | String | Ya | Program studi |

```json
{
  "nim": "2024001",
  "nama": "Ahmad Rizky",
  "email": "ahmad.rizky@student.uhb.ac.id",
  "prodi": "Informatika"
}
```

#### Response Examples

**201 Created - Success**
```json
{
  "id": 1,
  "nim": "2024001",
  "nama": "Ahmad Rizky",
  "email": "ahmad.rizky@student.uhb.ac.id",
  "prodi": "Informatika",
  "created_at": "2026-01-15T08:00:00.000000Z",
  "updated_at": "2026-01-15T08:00:00.000000Z"
}
```

**400 Bad Request - Validation Error**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "nim": ["The nim field is required."]
  }
}
```

---

### 2.3 GET /datamahasiswa/:id - Get Student by ID

`STATUS: PRODUCTION`

Endpoint untuk mengambil detail mahasiswa berdasarkan ID.

#### Request

```http
GET {{base_url}}/datamahasiswa/{id}
Accept: application/json
```

#### Path Variables

| Parameter | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | Integer | Ya | ID mahasiswa di database |

#### Response Examples

**200 OK - Data Found**
```json
{
  "data": {
    "id": 1,
    "nim": "2024001",
    "nama": "Ahmad Rizky",
    "email": "ahmad.rizky@student.uhb.ac.id",
    "prodi": "Informatika",
    "created_at": "2026-01-15T08:00:00.000000Z"
  }
}
```

**404 Not Found - Student Not Found**
```json
{
  "message": "Not Found"
}
```

---

### 2.4 GET /mahasiswa - List All (Alternative)

`STATUS: PRODUCTION`

Endpoint alternatif untuk mengambil semua data mahasiswa tanpa pagination.

#### Request

```http
GET {{base_url}}/mahasiswa
Accept: application/json
```

#### Response

**200 OK - Success**
```json
[
  {
    "id": 1,
    "nim": "2024001",
    "nama": "Ahmad Rizky",
    "email": "ahmad.rizky@student.uhb.ac.id",
    "prodi": "Informatika"
  }
]
```

---

### 2.5 POST /mahasiswa - Create (Alternative)

`STATUS: PRODUCTION`

#### Request Body

| Field | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `nim` | String | Ya | NIM (unik, tidak dapat diubah) |
| `nama` | String | Ya | Nama mahasiswa |
| `email` | String | Ya | Email |
| `prodi` | String | Ya | Program studi |

```json
{
  "nim": "2024002",
  "nama": "Siti Aminah",
  "email": "siti.aminah@student.uhb.ac.id",
  "prodi": "Sistem Informasi"
}
```

#### Response

**201 Created**
```json
{
  "id": 2,
  "nim": "2024002",
  "nama": "Siti Aminah",
  "email": "siti.aminah@student.uhb.ac.id",
  "prodi": "Sistem Informasi"
}
```

---

### 2.6 GET /mahasiswa/:id - Show by ID

```http
GET {{base_url}}/mahasiswa/{id}
```

**200 OK**
```json
{
  "id": 1,
  "nim": "2024001",
  "nama": "Ahmad Rizky",
  "email": "ahmad.rizky@student.uhb.ac.id",
  "prodi": "Informatika"
}
```

**404 Not Found**
```json
{
  "message": "Not Found"
}
```

---

### 2.7 PUT /mahasiswa/:id - Update Student

`STATUS: PRODUCTION`

Endpoint untuk mengupdate data mahasiswa.

> ### PENTING
> Field **NIM** bersifat **Unik** dan **Immutable**.
> NIM tidak dapat diubah setelah data dibuat. Jika terjadi kesalahan input NIM, data harus dihapus dan dibuat ulang.

#### Request

```http
PUT {{base_url}}/mahasiswa/{id}
Content-Type: application/json
```

#### Request Body

| Field | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `nama` | String | Tidak | Nama baru |
| `email` | String | Tidak | Email baru |
| `prodi` | String | Tidak | Program studi baru |

```json
{
  "nama": "Ahmad Rizky Pratama",
  "email": "ahmad.pratama@student.uhb.ac.id"
}
```

#### Response

**200 OK - Updated**
```json
{
  "id": 1,
  "nim": "2024001",
  "nama": "Ahmad Rizky Pratama",
  "email": "ahmad.pratama@student.uhb.ac.id",
  "prodi": "Informatika"
}
```

**404 Not Found**
```json
{
  "message": "Not Found"
}
```

---

### 2.8 DELETE /mahasiswa/:id - Delete Student

`STATUS: PRODUCTION`

Endpoint untuk menghapus data mahasiswa.

#### Request

```http
DELETE {{base_url}}/mahasiswa/{id}
```

#### Response

**200 OK - Deleted**
```json
{
  "message": "Deleted"
}
```

**404 Not Found**
```json
{
  "message": "Not Found"
}
```

---

## 03 Master Data Dosen

### Deskripsi Folder

`STATUS: PRODUCTION`

Folder ini mengelola data dosen pengajar di sistem SIAKAD.

#### Aturan Penggunaan
- NIDN bersifat **unik** untuk setiap dosen
- Format response mendukung JSON dan XML

### 3.1 GET /dosen - List All Lecturers

`STATUS: PRODUCTION`

#### Request

```http
GET {{base_url}}/dosen
Accept: application/json
```

#### Response

**200 OK - Success**
```json
[
  {
    "id": 1,
    "nama": "Dr. Ahmad Fauzi, M.Kom",
    "nidn": "0123456789",
    "email": "ahmad.fauzi@uhb.ac.id",
    "prodi": "Informatika"
  }
]
```

---

### 3.2 POST /dosen - Create Lecturer

`STATUS: PRODUCTION`

#### Request Body

| Field | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `nama` | String | Ya | Nama lengkap dengan gelar |
| `nidn` | String | Ya | Nomor Induk Dosen Nasional (10 digit) |
| `email` | String | Ya | Email institusi |
| `prodi` | String | Ya | Program studi |

```json
{
  "nama": "Dr. Ahmad Fauzi, M.Kom",
  "nidn": "0123456789",
  "email": "ahmad.fauzi@uhb.ac.id",
  "prodi": "Informatika"
}
```

#### Response

**201 Created**
```json
{
  "id": 1,
  "nama": "Dr. Ahmad Fauzi, M.Kom",
  "nidn": "0123456789",
  "email": "ahmad.fauzi@uhb.ac.id",
  "prodi": "Informatika"
}
```

---

### 3.3 GET /dosen/:id - Show Lecturer by ID

```http
GET {{base_url}}/dosen/{id}
```

**200 OK**
```json
{
  "id": 1,
  "nama": "Dr. Ahmad Fauzi, M.Kom",
  "nidn": "0123456789",
  "email": "ahmad.fauzi@uhb.ac.id",
  "prodi": "Informatika"
}
```

**404 Not Found**
```json
{
  "message": "Not Found"
}
```

---

### 3.4 PUT /dosen/:id - Update Lecturer

```http
PUT {{base_url}}/dosen/{id}
Content-Type: application/json
```

#### Request Body

```json
{
  "nama": "Dr. Ahmad Fauzi, M.Kom., Ak.",
  "email": "ahmad.fauzi.baru@uhb.ac.id"
}
```

**200 OK**
```json
{
  "id": 1,
  "nama": "Dr. Ahmad Fauzi, M.Kom., Ak.",
  "nidn": "0123456789",
  "email": "ahmad.fauzi.baru@uhb.ac.id",
  "prodi": "Informatika"
}
```

---

### 3.5 DELETE /dosen/:id - Delete Lecturer

```http
DELETE {{base_url}}/dosen/{id}
```

**200 OK**
```json
{
  "message": "Deleted"
}
```

---

## 04 Akademik - Mata Kuliah

### Deskripsi Folder

`STATUS: PRODUCTION`

Folder ini mengelola data mata kuliah yang tersedia di sistem.

### 4.1 GET /matakuliah - List All Courses

```http
GET {{base_url}}/matakuliah
```

**200 OK**
```json
[
  {
    "id": 1,
    "kode_mk": "IF101",
    "nama_mk": "Pemrograman Web"
  },
  {
    "id": 2,
    "kode_mk": "IF102",
    "nama_mk": "Basis Data"
  }
]
```

---

### 4.2 POST /matakuliah - Create Course

#### Request Body

| Field | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `kode_mk` | String | Ya | Kode mata kuliah (unik) |
| `nama_mk` | String | Ya | Nama mata kuliah |

```json
{
  "kode_mk": "IF101",
  "nama_mk": "Pemrograman Web"
}
```

---

### 4.3 GET /matakuliah/:id - Show Course

```http
GET {{base_url}}/matakuliah/{id}
```

---

### 4.4 PUT /matakuliah/:id - Update Course

```http
PUT {{base_url}}/matakuliah/{id}
```

---

### 4.5 DELETE /matakuliah/:id - Delete Course

```http
DELETE {{base_url}}/matakuliah/{id}
```

---

## 05 Fasilitas - Ruang Kelas

### Deskripsi Folder

`STATUS: PRODUCTION`

Folder ini mengelola data ruang kelas/fasilitas perkuliahan.

### 5.1 GET /ruang - List All Rooms

```http
GET {{base_url}}/ruang
```

**200 OK**
```json
[
  {
    "id": 1,
    "nama_ruang": "R.301",
    "gedung": "Gedung A"
  }
]
```

---

### 5.2 POST /ruang - Create Room

#### Request Body

| Field | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `nama_ruang` | String | Ya | Nama/nomor ruang |
| `gedung` | String | Ya | Nama gedung |

```json
{
  "nama_ruang": "R.301",
  "gedung": "Gedung A"
}
```

---

### 5.3 GET /ruang/:id - Show Room

```http
GET {{base_url}}/ruang/{id}
```

---

### 5.4 PUT /ruang/:id - Update Room

```http
PUT {{base_url}}/ruang/{id}
```

---

### 5.5 DELETE /ruang/:id - Delete Room

```http
DELETE {{base_url}}/ruang/{id}
```

---

## 06 Operasional - Jadwal Perkuliahan

### Deskripsi Folder

`STATUS: PRODUCTION`

Endpoint ini mengintegrasikan data dosen, mata kuliah, dan ruang kelas untuk mengelola jadwal perkuliahan.

#### Relasi Data

Input jadwal memerlukan ID valid dari folder berikut:
- `dosen_id` → Ambil dari Folder 03 (Master Data Dosen)
- `matakuliah_id` → Ambil dari Folder 04 (Akademik - Mata Kuliah)
- `ruang_id` → Ambil dari Folder 05 (Fasilitas - Ruang Kelas)

#### Aturan Bentrok (Collision Rule)

Sistem akan menolak (`409 Conflict`) jika:
1. Dosen mengajar di jam yang sama di ruang berbeda
2. Ruangan digunakan oleh mata kuliah lain di jam yang sama

### 6.1 GET /jadwal - List All Schedules

`STATUS: PRODUCTION`

Endpoint untuk mengambil semua jadwal perkuliahan dengan relasi lengkap.

#### Request

```http
GET {{base_url}}/jadwal
Accept: application/json
```

#### Query Parameters

| Parameter | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `nidn` | String | Tidak | Filter berdasarkan NIDN dosen |

#### Response Examples

**200 OK - JSON**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "hari": "Senin",
      "jam_mulai": "08:00",
      "dosen": {
        "id": 1,
        "nama": "Dr. Ahmad Fauzi, M.Kom",
        "nidn": "0123456789"
      },
      "matakuliah": {
        "id": 1,
        "kode_mk": "IF101",
        "nama_mk": "Pemrograman Web"
      },
      "ruang": {
        "id": 1,
        "nama_ruang": "R.301",
        "gedung": "Gedung A"
      },
      "mahasiswas": [
        {
          "id": 1,
          "nim": "2024001",
          "nama": "Ahmad Rizky"
        }
      ]
    }
  ]
}
```

**200 OK - XML**
```xml
<?xml version="1.0" encoding="UTF-8"?>
<akademik_response>
  <status>success</status>
  <daftar_jadwal>
    <pertemuan>
      <hari>Senin</hari>
      <waktu>08:00</waktu>
      <matakuliah>
        <kode>IF101</kode>
        <nama>Pemrograman Web</nama>
      </matakuliah>
      <dosen>
        <nidn>0123456789</nidn>
        <nama>Dr. Ahmad Fauzi, M.Kom</nama>
      </dosen>
      <ruang>
        <nama>R.301</nama>
        <gedung>Gedung A</gedung>
      </ruang>
      <peserta_kuliah>
        <mahasiswa>
          <nim>2024001</nim>
          <nama>Ahmad Rizky</nama>
        </mahasiswa>
      </peserta_kuliah>
    </pertemuan>
  </daftar_jadwal>
</akademik_response>
```

---

### 6.2 POST /jadwal - Create Schedule

`STATUS: PRODUCTION`

Endpoint untuk membuat jadwal perkuliahan baru.

#### Request Body

| Field | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `dosen_id` | Integer | Ya | ID dosen pengampu |
| `matakuliah_id` | Integer | Ya | ID mata kuliah |
| `ruang_id` | Integer | Ya | ID ruang kelas |
| `hari` | String | Ya | Hari (Senin, Selasa, dll) |
| `jam_mulai` | String | Ya | Waktu mulai (HH:mm) |

```json
{
  "dosen_id": 1,
  "matakuliah_id": 1,
  "ruang_id": 1,
  "hari": "Senin",
  "jam_mulai": "08:00"
}
```

#### Response

**201 Created**
```json
{
  "id": 1,
  "dosen_id": 1,
  "matakuliah_id": 1,
  "ruang_id": 1,
  "hari": "Senin",
  "jam_mulai": "08:00"
}
```

**409 Conflict - Jadwal Bentrok**
```json
{
  "message": "Jadwal bentrok dengan ruangan lain pada waktu yang sama"
}
```

---

### 6.3 PUT /jadwal/:id - Update Schedule

```http
PUT {{base_url}}/jadwal/{id}
Content-Type: application/json
```

---

### 6.4 DELETE /jadwal/:id - Delete Schedule

```http
DELETE {{base_url}}/jadwal/{id}
```

---

## Endpoint Tambahan

### Hitung Luas Persegi Panjang

`STATUS: PRODUCTION`

Endpoint utilitas untuk menghitung luas persegi panjang.

#### Request

```http
POST {{base_url}}/hitung-luas
Content-Type: application/json
```

#### Request Body

| Field | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `panjang` | Number | Ya | Panjang (numeric) |
| `lebar` | Number | Ya | Lebar (numeric) |

```json
{
  "panjang": 10,
  "lebar": 5
}
```

#### Response

**200 OK**
```json
{
  "success": true,
  "message": "Perhitungan luas berhasil",
  "data": {
    "panjang": 10,
    "lebar": 5,
    "luas": 50
  }
}
```

**400 Bad Request - Validation Error**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "panjang": ["The panjang field is required."]
  }
}
```

---

## Appendix

### A. Error Codes Reference

| Code | Description |
| :--- | :--- |
| `200 OK` | Request berhasil |
| `201 Created` | Data berhasil dibuat |
| `400 Bad Request` | Validasi input gagal |
| `401 Unauthorized` | Token tidak valid (untuk auth) |
| `404 Not Found` | Resource tidak ditemukan |
| `409 Conflict` | Konflik data (jadwal bentrok) |
| `500 Internal Server Error` | Error server |

### B. Format Response Standar

#### JSON Response
```json
{
  "success": true,
  "message": "Deskripsi hasil",
  "data": {}
}
```

#### XML Response
```xml
<?xml version="1.0" encoding="UTF-8"?>
<response>
  <success>true</success>
  <message>Deskripsi hasil</message>
  <data>...</data>
</response>
```

### C. Postman Automation Script

Untuk otomatisasi token di Postman, tambahkan script berikut di tab **Tests** pada endpoint Login:

```javascript
// Pastikan kode respon adalah 200 (berhasil)
if (pm.response.code === 200) {
    // Mengambil data JSON dari respon
    var jsonData = pm.response.json();
    // Menyimpan nilai access_token ke dalam variabel koleksi
    pm.collectionVariables.set("token", jsonData.access_token);
    console.log("Token berhasil diperbarui otomatis!");
}
```

### D. Collection Variables Setup

Di Postman Collection, setup variabel berikut:

| Variable | Initial Value | Current Value |
| :--- | :--- | :--- |
| `base_url` | `http://localhost:8000/api` | (auto) |
| `token` | (kosong) | (auto-filled after login) |

---

## Cara Import ke Postman

1. Buka Postman
2. Klik **Import** → **Raw Text**
3. Copy struktur folder sesuai panduan di modul:
   - `01 Authentication`
   - `02 Master Data Mahasiswa`
   - `03 Master Data Dosen`
   - `04 Akademik - Mata Kuliah`
   - `05 Fasilitas - Ruang Kelas`
   - `06 Operasional - Jadwal Perkuliahan`
4. Untuk setiap endpoint, tambahkan deskripsi Markdown sesuai format di atas
5. Klik **Save as Example** untuk setiap skenario response
6. Publish dokumentasi dengan klik **...** pada Collection → **View Documentation** → **Publish**

---

*Dokumentasi ini dibuat sesuai standar SATUSEHAT Postman Collection*
