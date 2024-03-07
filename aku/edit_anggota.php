<?php
// Sertakan file koneksi database
include('koneksi.php');

// Inisialisasi variabel
$username = $email = $namaLengkap = $alamat = $level = '';
$error = '';

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah ada parameter ID yang dikirimkan
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil data anggota berdasarkan ID
    $sql = "SELECT * FROM user WHERE UserID = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Jika data anggota ditemukan, isi variabel dengan nilai yang ada
        $row = $result->fetch_assoc();
        $username = $row['Username'];
        $email = $row['Email'];
        $namaLengkap = $row['NamaLengkap'];
        $alamat = $row['Alamat'];
        $level = $row['level'];
    } else {
        // Jika tidak ada data anggota yang sesuai dengan ID, tampilkan pesan error
        $error = 'Tidak ada data anggota yang ditemukan.';
    }
} else {
    // Jika tidak ada parameter ID yang dikirimkan, tampilkan pesan error
    $error = 'ID anggota tidak valid.';
}

// Proses update anggota jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $namaLengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $level = $_POST['level'];

    // Query untuk melakukan update data anggota
    $sql_update = "UPDATE user SET Username='$username', Email='$email', NamaLengkap='$namaLengkap', Alamat='$alamat', level='$level' WHERE UserID=$id";

    if ($conn->query($sql_update) === TRUE) {
        // Jika update berhasil, redirect kembali ke halaman daftar anggota
        header("Location: anggota.php");
        exit;
    } else {
        // Jika terjadi kesalahan saat update, tangani error
        $error = "Error: " . $conn->error;
    }
}

// Tutup koneksi ke database
$conn->close();
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
                    <img src="profil.png" alt="Profil" class="profile-img">
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
            <?php if($error != ''): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php else: ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $id); ?>">
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br><br>
                    <label for="email">Email:</label><br>
                    <input type="text" id="email" name="email" value="<?php echo $email; ?>"><br><br>
                    <label for="nama_lengkap">Nama Lengkap:</label><br>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $namaLengkap; ?>"><br><br>
                    <label for="alamat">Alamat:</label><br>
                    <textarea id="alamat" name="alamat"><?php echo $alamat; ?></textarea><br><br>
                    <label for="level">Level:</label><br>
                    <input type="text" id="level" name="level" value="<?php echo $level; ?>"><br><br>
                    <input type="submit" value="Update">
                </form>
            <?php endif; ?>
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