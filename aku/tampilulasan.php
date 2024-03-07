<?php
// Mulai sesi untuk mengakses variabel sesi
session_start();

// Sertakan file koneksi database
include('koneksi.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah pengguna sudah login
if(isset($_SESSION['Username'])) {
    // Jika sudah login, simpan nama pengguna dalam variabel
    $username = $_SESSION['Username'];
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan dan Rating Buku</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS untuk desain tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

    </style>
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
            <h2>Ulasan dan Rating Buku</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User ID</th>
                        <th>Buku ID</th>
                        <th>Ulasan</th>
                        <th>Rating</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil data ulasan dan rating buku
                    $sql = "SELECT ulasanbuku.*, user.Username AS NamaPengguna, buku.Judul AS JudulBuku 
                            FROM ulasanbuku 
                            JOIN user ON ulasanbuku.UserID = user.UserID 
                            JOIN buku ON ulasanbuku.BukuID = buku.BukuID";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data setiap baris
                        $no = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $row['NamaPengguna'] . "</td>";
                            echo "<td>" . $row['JudulBuku'] . "</td>";
                            echo "<td>" . $row['Ulasan'] . "</td>";
                            echo "<td>" . $row['Rating'] . "</td>";
                            echo "<td><form method='post' action='hapus_ulasan.php'>";
                            echo "<input type='hidden' name='UlasanID' value='" . $row['UlasanID'] . "'>";
                            echo "<input type='submit' value='Hapus'></form></td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada ulasan atau rating buku</td></tr>";
                    }
                    ?>
                </tbody>
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

<?php
// Tutup koneksi ke database
$conn->close();
?>
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