<?php
session_start();

// Jika session UserID belum diset, redirect ke halaman login
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

// Ambil level pengguna dari session
$user_level = $_SESSION['level'];

// Tentukan URL tujuan berdasarkan level pengguna
if ($user_level == 'administrator') {
    $redirect_url = 'index.php';
} elseif ($user_level == 'petugas') {
    $redirect_url = 'petugas.php';
} elseif ($user_level == 'peminjam') {
    $redirect_url = 'peminjam.php';
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Sukses</title>
    <style>
        /* Style untuk section content */
        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2; /* Warna latar belakang */
        }

        /* Style untuk container */
        .container {
            text-align: center;
            background-color: #fff; /* Warna latar belakang container */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Bayangan */
        }

        /* Style untuk pesan kesuksesan */
        .success {
            color: #155724; /* Warna teks */
            background-color: #d4edda; /* Warna latar belakang */
            border: 1px solid #c3e6cb; /* Warna border */
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Style untuk tombol kembali */
        .back-button {
            background-color: #155724; /* Warna latar belakang tombol */
            color: #fff; /* Warna teks tombol */
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        /* Hover effect untuk tombol kembali */
        .back-button:hover {
            background-color: #1e7e34; /* Warna latar belakang tombol saat dihover */
        }
    </style>
</head>
<body>
    <section class="content">
        <div class="container">
            <div class="success">Profil berhasil diperbarui!</div>
            <a href="<?php echo $redirect_url; ?>" class="back-button">Kembali</a>
        </div>
    </section>
</body>
</html>



