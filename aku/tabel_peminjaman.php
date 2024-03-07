<?php
// Sertakan file koneksi database
include('koneksi.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil nilai bulan yang dipilih oleh pengguna, jika ada
$selectedMonth = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Ambil bulan saat ini jika tidak ada yang dipilih
$selectedYear = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Ambil tahun saat ini jika tidak ada yang dipilih

// Query untuk mengambil data peminjaman dari semua peminjam berdasarkan bulan dan tahun yang dipilih
$sql = "SELECT PeminjamanID, user.Username, buku.Judul, peminjaman.TanggalPeminjaman, peminjaman.TanggalPengembalian, peminjaman.StatusPeminjaman 
        FROM peminjaman 
        JOIN buku ON peminjaman.BukuID = buku.BukuID
        JOIN user ON peminjaman.UserID = user.UserID
        WHERE MONTH(peminjaman.TanggalPeminjaman) = '$selectedMonth'
        AND YEAR(peminjaman.TanggalPeminjaman) = '$selectedYear'";
$result = $conn->query($sql);

// Periksa apakah query berhasil dieksekusi
if ($result) {
    if ($result->num_rows > 0) {
        // Buat array untuk menyimpan data peminjaman
        $peminjamanArray = array();

        // Loop melalui hasil query dan tambahkan ke array peminjaman
        while ($row = $result->fetch_assoc()) {
            $peminjamanArray[] = $row;
        }

        // Kembalikan data peminjaman sebagai respons AJAX dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($peminjamanArray);
    } else {
        // Jika tidak ada data peminjaman, kembalikan respons kosong
        echo json_encode(array());
    }
} else {
    // Jika terjadi kesalahan dalam eksekusi query, kembalikan pesan kesalahan
    echo json_encode(array('error' => 'Error: ' . $sql . "<br>" . $conn->error));
}

// Tutup koneksi ke database
$conn->close();
?>
