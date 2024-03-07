<?php
// Sertakan file koneksi database
include('koneksi.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah ada permintaan POST untuk menghapus peminjaman
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['peminjamanID'])) {
    // Tangkap ID peminjaman dari form
    $peminjamanID = $_POST['peminjamanID'];

    // Query untuk menghapus peminjaman dari tabel berdasarkan ID peminjaman
    $sql_delete = "DELETE FROM peminjaman WHERE PeminjamanID = '$peminjamanID'";

    if ($conn->query($sql_delete) === TRUE) {
        echo "Peminjaman berhasil dihapus.";
    } else {
        echo "Error: " . $sql_delete . "<br>" . $conn->error;
    }
}

// Tutup koneksi ke database
$conn->close();
?>
