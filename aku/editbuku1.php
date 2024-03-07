<?php
// Sertakan file koneksi database
include('koneksi.php');

// Periksa apakah parameter id buku dikirimkan melalui URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil informasi buku berdasarkan BukuID
    $query = "SELECT * FROM buku WHERE BukuID = '$id'";
    $result = mysqli_query($conn, $query);

    // Periksa apakah ada hasil dari query
    if(mysqli_num_rows($result) == 1) {
        // Ambil data buku dari hasil query
        $row = mysqli_fetch_assoc($result);
        $judul = $row['Judul'];
        $penulis = $row['Penulis'];
        $penerbit = $row['Penerbit'];
        $tahun_terbit = $row['TahunTerbit'];
    } else {
        // Jika tidak ada hasil dari query, arahkan pengguna kembali ke halaman pendataan buku
        header("Location: pendataanbuku.php");
        exit();
    }
} else {
    // Jika parameter id buku tidak dikirimkan melalui URL, arahkan pengguna kembali ke halaman pendataan buku
    header("Location: pendataanbuku.php");
    exit();
}

// Aksi Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_baru = $_POST['Judul'];
    $penulis_baru = $_POST['Penulis'];
    $penerbit_baru = $_POST['Penerbit'];
    $tahun_terbit_baru = $_POST['TahunTerbit'];

    // Query untuk memperbarui informasi buku
    $query_update = "UPDATE buku SET Judul = '$judul_baru', Penulis = '$penulis_baru', Penerbit = '$penerbit_baru', TahunTerbit = '$tahun_terbit_baru' WHERE BukuID = '$id'";
    $result_update = mysqli_query($conn, $query_update);

    // Periksa apakah pembaruan berhasil
    if ($result_update) {
        echo '<script>alert("Informasi buku berhasil diperbarui."); window.location.href = "pendataanbuku.php";</script>';
    } else {
        echo '<script>alert("Gagal memperbarui informasi buku. Silakan coba lagi.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
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
                            <li class="nav-item"><a href="petugas.php">Dashboard</a></li>
                            <li class="nav-item"><a href="tampilpeminjaman.php">Informasi Peminjaman</a></li>
                            <li class="nav-item"><a href="tampilulasan1.php">Ulasan dan Rating</a></li>
                            <li class="nav-item"><a href="pendataanbuku1.php">Pendataan Buku</a></li>                        
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
            <h2>Edit Buku</h2>
            <button onclick="location.href='pendataanbuku.php';" style="margin-bottom: 20px;">Kembali</button>
            <form action="" method="post">
                <label for="Judul">Judul:</label>
                <input type="text" name="Judul" value="<?php echo $judul; ?>" required><br>

                <label for="Penulis">Penulis:</label>
                <input type="text" name="Penulis" value="<?php echo $penulis; ?>" required><br>

                <label for="Penerbit">Penerbit:</label>
                <input type="text" name="Penerbit" value="<?php echo $penerbit; ?>" required><br>

                <label for="TahunTerbit">Tahun Terbit:</label>
                <input type="number" name="TahunTerbit" value="<?php echo $tahun_terbit; ?>" required><br>

                <input type="submit" value="Simpan Perubahan">
            </form>
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