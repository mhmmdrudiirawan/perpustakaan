<?php
// Sertakan file koneksi database
include('koneksi.php');

// Periksa apakah data yang dibutuhkan telah diterima melalui metode POST
if(isset($_POST['peminjamanID']) && isset($_POST['tanggalPeminjaman']) && isset($_POST['tanggalPengembalian'])) {
    // Tangkap data yang diterima
    $peminjamanID = $_POST['peminjamanID'];
    $tanggalPeminjaman = $_POST['tanggalPeminjaman'];
    $tanggalPengembalian = $_POST['tanggalPengembalian'];

    // Query untuk mengupdate data peminjaman berdasarkan ID
    $sql = "UPDATE peminjaman SET TanggalPeminjaman = '$tanggalPeminjaman', TanggalPengembalian = '$tanggalPengembalian' WHERE PeminjamanID = '$peminjamanID'";
    
    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman riwayat peminjaman
        header("Location: tampil_peminjaman.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi ke database
    $conn->close();
} else {
    // Jika data tidak lengkap, kembalikan pengguna ke halaman sebelumnya
    header("Location: edit_peminjaman.php?id=" . $_POST['peminjamanID']);
    exit();
}
?>
