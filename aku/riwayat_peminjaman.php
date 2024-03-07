<?php
// Sertakan file koneksi database
include('koneksi.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah pengguna sudah login
session_start();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
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
                    <li class="nav-item"><a href="peminjam.php">Dashboard</a></li>
                    <li class="nav-item"><a href="peminjamann.php">Pinjam Buku</a></li>
                    <li class="nav-item"><a href="ulasanrating.php">Ulasan dan Rating</a></li>
                    <li class="nav-item"><a href="riwayat_peminjaman.php">Riwayat Peminjaman</a></li>
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
            
            <h2>Riwayat Peminjaman</h2>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status Peminjaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Periksa apakah pengguna sudah login
                    if(isset($_SESSION['UserID'])) {
                        $userID = $_SESSION['UserID'];

                        // Query untuk mengambil data peminjaman dari tabel peminjaman berdasarkan UserID
                        $sql = "SELECT PeminjamanID, user.Username, buku.Judul, peminjaman.TanggalPeminjaman, peminjaman.TanggalPengembalian, peminjaman.StatusPeminjaman 
                                FROM peminjaman 
                                JOIN buku ON peminjaman.BukuID = buku.BukuID
                                JOIN user ON peminjaman.UserID = user.UserID
                                WHERE peminjaman.UserID = '$userID'";
                        $result = $conn->query($sql);

                        // Periksa apakah query berhasil dieksekusi
                        if ($result) {
                            if ($result->num_rows > 0) {
                                // Output data setiap baris
                                $no = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . $row['Username'] . "</td>";
                                    echo "<td>" . $row['Judul'] . "</td>";
                                    echo "<td>" . $row['TanggalPeminjaman'] . "</td>";
                                    echo "<td>" . $row['TanggalPengembalian'] . "</td>";
                                    // Tambahkan tombol aksi: kembalikan, edit, hapus
                                    echo "<td>";
                                    if ($row['StatusPeminjaman'] == 'dipinjam') {
                                        // Periksa apakah sudah lewat dari tanggal pengembalian
                                        $tanggalPengembalian = $row['TanggalPengembalian'];
                                        $tanggalSekarang = date("Y-m-d");
                                        if ($tanggalSekarang <= $tanggalPengembalian) {
                                            echo "Dipinjam";
                                        } else {
                                            echo "Telat mengembalikan";
                                            // Perbarui status peminjaman menjadi "Telat Mengembalikan" di database
                                            $sql_update = "UPDATE peminjaman SET StatusPeminjaman = 'Telat Mengembalikan' WHERE PeminjamanID = '" . $row['PeminjamanID'] . "'";
                                            $conn->query($sql_update);
                                        }
                                    } else {
                                        echo "Buku telah dikembalikan";
                                    }
                                    echo "</td>";
                                    echo "<td>";
                                    if ($row['StatusPeminjaman'] == 'dipinjam') {
                                        echo "<form action='proses_pengembalian.php' method='post'>";
                                        echo "<input type='hidden' name='peminjaman_id' value='" . $row['PeminjamanID'] . "'>";
                                        echo "<button type='submit' name='kembalikan'>Kembalikan</button>";
                                        echo "</form>";
                                    } else {
                                        echo "-";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='7'>Tidak ada riwayat peminjaman.</td></tr>";
                            }
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }

                    // Tutup koneksi ke database
                    $conn->close();
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
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdownContent");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }
    </script>
</body>
</html>
