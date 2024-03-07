<?php
// Pastikan terhubung ke database
include 'koneksi.php';
// Mulai sesi PHP
session_start();

// Inisialisasi variabel username
$username = '';

// Cek apakah pengguna sudah login
if(isset($_SESSION['Username'])) {
    // Ambil username dari sesi
    $username = $_SESSION['Username'];
}

// Periksa jika formulir telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirimkan melalui formulir
    $Username = $username; // Gunakan nilai dari sesi untuk Username
    $Judul = $_POST['Judul'];
    $Ulasan = $_POST['Ulasan'];
    $Rating = $_POST['Rating'];
    $randomID = rand(100, 999);

    // Query untuk mendapatkan UserID berdasarkan Username
    $query_user = "SELECT UserID FROM user WHERE Username = '$Username'";
    $result_user = mysqli_query($conn, $query_user);
    $row_user = mysqli_fetch_assoc($result_user);
    $UserID = $row_user['UserID'];

    // Query untuk mendapatkan BukuID berdasarkan Judul
    $query_buku = "SELECT BukuID FROM buku WHERE Judul = '$Judul'";
    $result_buku = mysqli_query($conn, $query_buku);
    $row_buku = mysqli_fetch_assoc($result_buku);
    $BukuID = $row_buku['BukuID'];

    // Query untuk menyimpan data ulasan dan rating ke dalam database
    $query = "INSERT INTO ulasanbuku (UlasanID, UserID, BukuID, Ulasan, Rating) VALUES ('$randomID','$UserID', '$BukuID', '$Ulasan', '$Rating')";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "Ulasan dan rating berhasil disimpan.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<header class="header">
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
        <div class="container">
        <img src="img/buku1.png" alt="image" class="book-img">
            <h1 class="logo">Perpustakaan</h1>
            <nav class="navbar">
                <ul class="nav-menu">
                <li class="nav-item"><a href="peminjam.php">Dashboard</a></li>
                    <li class="nav-item"><a href="peminjamann.php">Pinjam Buku</a></li>
                    <li class="nav-item"><a href="ulasanrating.php">Ulasan dan Rating</a></li>
                    <li class="nav-item"><a href="riwayat_peminjaman.php">riwayat peminjaman</a></li>
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Ulasan dan Rating</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Form Ulasan dan Rating</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="Username">Username:</label>
        <?php
                // Sertakan file koneksi database
                include('koneksi.php');

                // Query untuk mendapatkan data user_id dari tabel user
                $query = "SELECT UserID, NamaLengkap FROM user";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();
            ?><br>
            <input type="hidden" name="UserID" value="<?php echo $row['UserID'];?>">
            <input type="text" value="<?php echo $username; ?>" readonly>
        </select><br>

        <label for="Judul">Judul Buku:</label>
        <select name="Judul" id="Judul" required>
            <?php
                // Query untuk mendapatkan data Judul dari tabel buku
                $query_judul = "SELECT Judul FROM buku";
                $result_judul = mysqli_query($conn, $query_judul);
                while ($row_judul = mysqli_fetch_assoc($result_judul)) {
                    echo "<option value='".$row_judul['Judul']."'>".$row_judul['Judul']."</option>";
                }
            ?>
        </select><br>

        <label for="Ulasan">Ulasan:</label>
        <textarea name="Ulasan" id="Ulasan" required></textarea>
        <br>

        <label for="Rating">Rating:</label>
        <select name="Rating" id="Rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br>

        <input type="submit" value="Submit">
    </form>
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