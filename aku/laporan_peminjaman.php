<?php
// Sertakan file koneksi database
include('koneksi.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil nilai bulan dan tahun yang dipilih oleh pengguna, jika ada
$selectedMonth = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Ambil bulan saat ini jika tidak ada yang dipilih
$selectedYear = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Ambil tahun saat ini jika tidak ada yang dipilih

// Fungsi untuk mengedit peminjaman
function editPeminjaman($conn, $peminjamanID) {
    // Implementasikan logika untuk mengedit peminjaman di sini
    // Misalnya, Anda bisa mengarahkan pengguna ke halaman edit peminjaman dengan membawa ID peminjaman
    header("Location: editpeminjaman.php?id=" . $peminjamanID);
    exit();
}

// Fungsi untuk menghapus peminjaman
function hapusPeminjaman($conn, $peminjamanID) {
    // Lakukan penghapusan data peminjaman dari database
    $sql = "DELETE FROM peminjaman WHERE PeminjamanID = '$peminjamanID'";
    if ($conn->query($sql) === TRUE) {
        echo "Peminjaman berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Periksa apakah ada permintaan POST untuk menghapus peminjaman
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hapus_peminjaman'])) {
    $peminjamanID = $_POST['peminjaman_id'];
    hapusPeminjaman($conn, $peminjamanID);
}

// Periksa apakah ada permintaan POST untuk mengedit peminjaman
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_peminjaman'])) {
    $peminjamanID = $_POST['peminjaman_id'];
    editPeminjaman($conn, $peminjamanID);
}

// Query untuk mengambil data peminjaman dari semua peminjam berdasarkan bulan dan tahun yang dipilih
$sql = "SELECT COUNT(*) AS totalPeminjaman
        FROM peminjaman 
        WHERE MONTH(TanggalPeminjaman) = '$selectedMonth'
        AND YEAR(TanggalPeminjaman) = '$selectedYear'";
$result = $conn->query($sql);

// Periksa apakah query berhasil dieksekusi
if ($result) {
    $row = $result->fetch_assoc();
    $totalPeminjaman = $row['totalPeminjaman'];
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Peminjaman Bulanan</title>
        <style>
            /* CSS styling */
            .header {
                /* Header styles */
            }

            .container {
                /* Container styles */
            }

            /* Add more styles for your specific elements */
        </style>
    </head>
    <body>
        <header class="header">
            <div class="container">
                <h1 class="logo">Perpustakaan</h1>
            </div>
        </header>
        <section class="content">
            <div class="container">
                <h2>Laporan Peminjaman Bulanan</h2>
                <p>Jumlah total peminjaman untuk bulan <?= date('F', mktime(0, 0, 0, $selectedMonth, 1)) ?> tahun <?= $selectedYear ?> adalah <?= $totalPeminjaman ?></p>
                <a href="petugas.php" class="btn-back">Kembali</a>
            </div>
        </section>
        <footer class="footer">
            <div class="container">
                <p>Hak Cipta © 2024 Perpustakaan. Hak Cipta Dilindungi Undang-Undang.</p>
            </div>
        </footer>
    </body>
    </html>
    <?php
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi ke database
$conn->close();
?>
