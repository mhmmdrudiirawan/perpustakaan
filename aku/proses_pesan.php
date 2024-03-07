<?php
// Mulai sesi untuk mengakses variabel sesi
session_start();

// Periksa koneksi
include "koneksi.php";

// Periksa apakah pengguna sudah login
if(isset($_SESSION['UserID'])) {
    // Jika sudah login, simpan ID pengguna dalam variabel
    $userID = $_SESSION['UserID'];
} else {
    // Jika tidak login, arahkan pengguna ke halaman login atau lakukan tindakan lainnya
    header("Location: login.php"); // Ganti dengan halaman login yang sesuai
    exit(); // Pastikan untuk keluar dari skrip saat melakukan redirect
}

// Periksa apakah pesan dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data pesan dari formulir
    $pesan = $_POST['pesan'];
    
    // Query untuk menyimpan pesan ke dalam tabel pesan
    $sql = "INSERT INTO pesan (IsiPesan) VALUES ('$pesan')";

    if ($conn->query($sql) === TRUE) {
        echo "Pesan berhasil dikirim";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Jika pesan tidak dikirim melalui metode POST, kembali ke halaman peminjam
    header("Location: peminjam.php");
    exit();
}

// Tutup koneksi
$conn->close();
?>
