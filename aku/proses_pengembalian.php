<?php
// Sertakan file koneksi database
include('koneksi.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah ada permintaan POST untuk mengembalikan buku
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kembalikan'])) {
    $peminjamanID = $_POST['peminjaman_id'];
    // Perbarui status peminjaman menjadi "Dikembalikan" di database
    $sql_update = "UPDATE peminjaman SET StatusPeminjaman = 'Dikembalikan' WHERE PeminjamanID = '$peminjamanID'";
    if ($conn->query($sql_update) === TRUE) {
        echo "Buku berhasil dikembalikan.";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

// Tutup koneksi ke database
$conn->close();
?>
