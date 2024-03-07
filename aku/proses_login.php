<?php
// Sertakan file koneksi ke database
include 'koneksi.php';

// Mulai sesi PHP
session_start();

// Periksa apakah data formulir telah terkirim
if(isset($_POST['Username'], $_POST['Password'], $_POST['level'])) {
    // Ambil data dari form login
    $username = $_POST['Username'];
    $Password = $_POST['Password'];
    $level = $_POST['level'];

    // Lakukan query untuk memeriksa apakah kombinasi username dan level yang dimasukkan benar
    $sql = "SELECT * FROM user WHERE Username='$username' AND level='$level'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Jika data ditemukan, maka simpan data pengguna ke dalam sesi
        $row = $result->fetch_assoc();

        // Gunakan password_verify untuk memeriksa kecocokan kata sandi
        if($Password == $row['Password']) {
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['Username'] = $row['Username'];
            $_SESSION['level'] = $row['level'];

            // Redirect pengguna ke halaman sesuai dengan levelnya
            switch ($level) {
                case 'administrator':
                    header('Location: index.php');
                    exit;
                case 'petugas':
                    header('Location: petugas.php');
                    exit;
                case 'peminjam':
                    header('Location: peminjam.php');
                    exit;
                default:
                    // Jika level tidak valid, arahkan ke halaman login dengan pesan kesalahan
                    header('Location: login.php?error=level_invalid');
                    exit;
            }
        } else {
            // Jika kata sandi tidak cocok, arahkan kembali ke halaman login dengan pesan kesalahan
            header('Location: login.php?error=login_failed');
            exit;
        }
    } else {
        // Jika data tidak ditemukan, arahkan kembali ke halaman login dengan pesan kesalahan
        header('Location: login.php?error=login_failed');
        exit;
    }
} else {
    // Jika data formulir belum terkirim, arahkan kembali ke halaman login dengan pesan kesalahan
    header('Location: login.php?error=form_not_submitted');
    exit;
}

// Tutup koneksi ke database
$conn->close();
?>
