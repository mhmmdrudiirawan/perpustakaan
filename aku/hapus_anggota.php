<?php
include('koneksi.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah pengguna sudah login
session_start();
if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID anggota dari parameter URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: anggota.php");
    exit();
}
$id = $_GET['id'];

// Hapus anggota dari database
$sql_delete = "DELETE FROM user WHERE UserID = $id";

if ($conn->query($sql_delete) === TRUE) {
    echo "Anggota berhasil dihapus.";
} else {
    echo "Error: " . $sql_delete . "<br>" . $conn->error;
}

$conn->close();
?>
