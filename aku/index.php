<?php
// Mulai sesi PHP
session_start();

// Inisialisasi variabel username
$username = 'Username';

// Cek apakah pengguna sudah login
if(isset($_SESSION['Username']) && isset($_SESSION['level']) && isset($_SESSION['UserID'])) {
    // Ambil username, level, dan UserID dari sesi
    $username = $_SESSION['Username'];
    $level = $_SESSION['level'];
    $UserID = $_SESSION['UserID'];
     // Periksa apakah pengguna memiliki level "administrator"
     if($level !== 'administrator') {
        // Jika tidak, redirect ke halaman lain atau tampilkan pesan kesalahan
        header("Location: login.php"); // Ganti error.php dengan halaman lain yang ingin Anda arahkan
        exit;
    }
} else {
    // Jika pengguna belum login, redirect ke halaman login
    header("Location: login.php");
    exit;
}


// Proses logout jika tombol logout ditekan
if(isset($_POST['logout'])) {
    // Hapus semua variabel sesi
    session_unset();
    // Hancurkan sesi
    session_destroy();
    // Redirect ke halaman login
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS untuk desain username */
        .username {
            font-size: 18px; /* Ubah ukuran teks sesuai preferensi Anda */
            font-weight: bold; /* Membuat teks menjadi tebal */
            color: #333; /* Warna teks */
            text-align: center;
        }

        /* CSS untuk tata letak tombol navigasi */
        .nav-menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center; /* Pusatkan tombol navigasi */
        }

        .nav-item {
            display: inline-block;
            margin: 0 5px; /* Berikan jarak antara tombol navigasi */
        }

        .nav-item a {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-item a:hover {
            background-color: #f0f0f0;
        }

        /* CSS untuk garis horizontal */
        .nav-menu hr {
            display: none; /* Sembunyikan garis */
        }

        /* CSS untuk garis horizontal pada setiap item kecuali yang terakhir */
        .nav-item:not(:last-child) {
            border-right: 1px solid #ccc; /* Berikan garis kanan pada setiap item kecuali yang terakhir */
        }
        
        .profile-img {
    width: 30px; /* Sesuaikan ukuran gambar profil */
    height: 30px; /* Sesuaikan ukuran gambar profil */
    border-radius: 50%; /* Agar gambar profil menjadi lingkaran */
}
.header {
            position: relative;
        }
        
        .profile {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        
        .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    max-width: 200px; /* Lebar maksimum dropdown */
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    right: 0; /* Mengatur agar dropdown muncul di sebelah kanan */
}

.nav-menu {
    position: relative; /* Mengatur posisi relatif untuk kontainer menu */
}

.nav-menu .nav-item {
    display: inline-block;
    margin-right: 20px; /* Mengatur jarak antar menu */
}

.nav-item .profile {
    position: absolute;
    top: 100%; /* Mengatur agar dropdown muncul di bawah profile */
    right: 0;
    background-color: #f9f9f9;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    z-index: 1;
    display: none;
}

.nav-item .profile a {
    display: block;
    padding: 5px 10px;
    color: #333;
    text-decoration: none;
}

.nav-item:hover .profile {
    display: block; /* Menampilkan dropdown saat profile dihover */
}

        
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        /* CSS untuk desain logo buku */
/* CSS untuk desain logo buku */
/* CSS untuk desain logo buku */
.book-img {
    width: 150px; /* Sesuaikan ukuran gambar logo buku */
    height: auto; /* Biarkan tinggi menyesuaikan dengan proporsi */
    margin-left: 0px; /* Berikan margin kiri agar terpisah dari tombol navigasi */
}




    </style>
</head>
<body>
<header class="header">
    <div class="container">
    <img src="img/buku1.png" alt="image" class="book-img">
        <h1 class="logo">Perpustakaan</h1>
        <nav class="navbar">
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php">Dashboard</a></li>
                <li class="nav-item"><a href="tampil_peminjaman.php">Informasi Peminjaman</a></li>
                <li class="nav-item"><a href="tampilulasan.php">Ulasan dan Rating</a></li>
                <li class="nav-item"><a href="pendataanbuku.php">Pendataan Buku</a></li>
                <li class="nav-item"><a href="registrasi.php">Registrasi</a></li>
                <li class="nav-item"><a href="Anggota.php">Anggota</a></li>
               
            </ul>
            <div class="profile" onclick="toggleDropdown()">
                    <img src="img/profile.png" alt="Profil" class="profile-img">
                    <div class="dropdown-content" id="dropdownContent">
                        <a href="profile.php">Profil</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
        </nav>
    </div>
</header>


    <section class="content">
        <div class="container">
            <table class="content-table">
                <tr>
                    <td>
                        <h2>Selamat Datang di Perpustakaan. HALLO!!!</h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="username"><?php echo $username; ?></p>
                    </td>
                </tr>
            </table>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>Hak Cipta © 2024 Perpustakaan. Hak Cipta Ini Punya Muhammad Rudi Irawan.</p>
        </div>
    </footer>
</body>
</html>
<script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdownContent");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }
    </script>
`