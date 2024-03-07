<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman</title>
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
        </div>
    </header>

    <section class="content">
        <div class="container">
            <h2>Edit Peminjaman</h2>
            <?php
            // Sertakan file koneksi database
            include('koneksi.php');

            // Periksa apakah data peminjaman ID telah diterima
            if(isset($_GET['id'])) {
                $peminjamanID = $_GET['id'];

                // Query untuk mengambil data peminjaman dari tabel peminjaman berdasarkan ID
                $sql = "SELECT * FROM peminjaman WHERE PeminjamanID = '$peminjamanID'";
                $result = $conn->query($sql);

                // Periksa apakah query berhasil dieksekusi
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // Tampilkan formulir untuk mengedit peminjaman
                    echo "<form action='proses_edit_peminjaman.php' method='POST'>";
                    echo "<input type='hidden' name='peminjamanID' value='" . $row['PeminjamanID'] . "'>";
                    echo "Tanggal Peminjaman: <input type='date' name='tanggalPeminjaman' value='" . $row['TanggalPeminjaman'] . "'><br>";
                    echo "Tanggal Pengembalian: <input type='date' name='tanggalPengembalian' value='" . $row['TanggalPengembalian'] . "'><br>";
                    echo "<input type='submit' value='Simpan'>";
                    echo "</form>";
                } else {
                    echo "Peminjaman tidak ditemukan.";
                }
            }

            // Tutup koneksi ke database
            $conn->close();
            ?>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>Hak Cipta © 2024 Perpustakaan. Hak Cipta Ini Punya Muhammad Rudi Irawan.</p>
        </div>
    </footer>
</body>
</html>
