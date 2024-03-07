<?php
// Mulai sesi PHP
session_start();

// Inisialisasi variabel username
$username = '';

// Cek apakah pengguna sudah login
if(isset($_SESSION['Username'])) {
    // Ambil username dari sesi
    $username = $_SESSION['Username'];
    if(isset($_SESSION['UserID'])) {
        $userID = $_SESSION['UserID'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Buku</title>
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
    width: 150px; 
    height: auto;
    margin-left: 0px;
}



input[type="text"],
input[type="date"],
select,
textarea {
    width: 1200px; 
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

    <form action="proses_peminjaman.php" method="post">
        <label for="UserID">Nama:</label>
            <?php
                // Sertakan file koneksi database
                include('koneksi.php');

              
            ?><br>
           <input type="text" value="<?php echo $username; ?>" readonly>
<input type="hidden" name="UserID" value="<?php echo $userID; ?>">

        <label for="BukuID">Judul Buku:</label>
        <select name="BukuID" required>
            <?php
                // Query untuk mendapatkan data BukuID dari tabel buku
                $query = "SELECT BukuID, Judul FROM buku";
                $result = $conn->query($query);

                // Tampilkan pilihan dalam dropdown
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='".$row['BukuID']."'>".$row['Judul']."</option>";
                }
            ?>
        </select><br>

        <label for="TanggalPeminjaman">Tanggal Peminjaman:</label>
        <input type="date" id="tanggalPeminjaman" name="TanggalPeminjaman" required><br>

        <label for="TanggalPengembalian" >Tanggal Pengembalian:</label>
        <input type="date" id="tanggalPengembalian" name="TanggalPengembalian" readonly required><br>

        <label for="StatusPeminjaman">Status Peminjaman:</label>
        
        <small>Silakan ketikkan "dipinjam" jika Anda ingin meminjam buku.</small><br>
<textarea id="statusPeminjaman" name="StatusPeminjaman" required></textarea><br>



        <button id="tombolPinjam" type="submit" style="display:none;">Pinjam</button>
    </form>

    <footer class="footer">
        <div class="container">
            <p>Hak Cipta © 2024 Perpustakaan. Hak Cipta Ini Punya Muhammad Rudi Irawan.</p>
        </div>
    </footer>

    <script>
        document.getElementById('tanggalPeminjaman').addEventListener('change', function() {
            var tanggalPeminjaman = new Date(this.value);
            tanggalPeminjaman.setDate(tanggalPeminjaman.getDate() + 3);
            var tahun = tanggalPeminjaman.getFullYear();
            var bulan = ('0' + (tanggalPeminjaman.getMonth() + 1)).slice(-2);
            var hari = ('0' + tanggalPeminjaman.getDate()).slice(-2);
            var tanggalPengembalian = tahun + '-' + bulan + '-' + hari;
            document.getElementById('tanggalPengembalian').value = tanggalPengembalian;
        });

        document.getElementById('statusPeminjaman').addEventListener('input', function() {
            var statusPeminjaman = this.value;
            var tombolPinjam = document.getElementById('tombolPinjam');

            if (statusPeminjaman.toLowerCase() === 'dipinjam') {
                tombolPinjam.style.display = 'block';
            } else {
                tombolPinjam.style.display = 'none';
            }
        });
    </script>
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