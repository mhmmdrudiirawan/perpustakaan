<?php
// Sertakan file koneksi database
include('koneksi.php');

// Aksi Hapus
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus buku berdasarkan BukuID
    $query_hapus = "DELETE FROM buku WHERE BukuID = '$id'";
    $result_hapus = mysqli_query($conn, $query_hapus);

    // Periksa apakah penghapusan berhasil
    if ($result_hapus) {
        echo '<script>alert("Buku berhasil dihapus."); window.location.href = "pendataanbuku.php";</script>';
    } else {
        echo '<script>alert("Gagal menghapus buku. Silakan coba lagi.");</script>';
    }
}

// Query untuk mengambil data buku dari database
$query = "SELECT * FROM buku";
$result = mysqli_query($conn, $query);

// Cek apakah ada data yang dikembalikan
if (mysqli_num_rows($result) > 0) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Buku</title>
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
            <h2>Data Buku</h2>
            <form method="GET" id="searchForm">
                <input type="text" name="search_query" id="searchQuery" placeholder="Masukkan kata kunci pencarian">
            </form>
            <button onclick="location.href='tambahbuku1.php';" style="margin-bottom: 20px;">Tambah Buku</button>
            <table>
                <tr>
                    <th>BukuID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Aksi</th>
                </tr>
                <?php
                // Tampilkan data buku dalam tabel
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['BukuID'] . "</td>";
                    echo "<td>" . $row['Judul'] . "</td>";
                    echo "<td>" . $row['Penulis'] . "</td>";
                    echo "<td>" . $row['Penerbit'] . "</td>";
                    echo "<td>" . $row['TahunTerbit'] . "</td>";
                    echo "<td><a href='editbuku1.php?id=" . $row['BukuID'] . "'><button>Edit</button></a> | 
                    <a href='hapus_pinjam.php?id=" . $row['BukuID'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus peminjaman ini?\")'>
    <button>Hapus</button>
</a></td>";
                    echo "</tr>";
                }
                ?>
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
        document.getElementById("searchQuery").addEventListener("keyup", function(event) {
            event.preventDefault();
            searchBooks();
        });

        function searchBooks() {
            var searchQuery = document.getElementById("searchQuery").value.trim();
            var queryString = window.location.href.split('?')[0] + "?"; // Mengambil URL saat ini dan menghapus parameter yang ada
            if (searchQuery !== "") {
                queryString += "search_query=" + encodeURIComponent(searchQuery);
            }
            window.history.replaceState(null, null, queryString); // Mengganti URL tanpa reload halaman
            fetchBooks();
        }

        function fetchBooks() {
            // Lakukan pembaruan data buku menggunakan AJAX di sini (jika diperlukan)
        }
    </script>
`
<?php
} else {
    // Tampilkan pesan jika tidak ada data buku
    echo "Tidak ada data buku.";
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
