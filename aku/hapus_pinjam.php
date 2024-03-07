<?php
include "koneksi.php";

// Ambil ID buku dari URL
$BukuID = $_GET['id'];

// Periksa apakah ada peminjaman terkait dengan buku yang akan dihapus
$sql_check_peminjaman = "SELECT * FROM peminjaman WHERE BukuID = '$BukuID'";
$result_check_peminjaman = $conn->query($sql_check_peminjaman);

if ($result_check_peminjaman->num_rows > 0) {
    // Jika ada peminjaman terkait, beri pesan kesalahan dan kembalikan pengguna ke halaman sebelumnya
    echo "Tidak dapat menghapus buku karena ada peminjaman yang terkait dengan buku ini.";
    exit();
} else {
    // Jika tidak ada peminjaman terkait, lanjutkan untuk menghapus buku dari database
    $sql = "DELETE FROM buku WHERE BukuID = '$BukuID'";

    if ($conn->query($sql) === TRUE) {
        // Redirect kembali ke halaman tampil_buku.php setelah menghapus buku
        header("Location: pendataanbuku.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>
