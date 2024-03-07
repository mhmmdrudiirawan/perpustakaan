<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
        /* CSS untuk desain form registrasi */
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        select {
            width: calc(100% - 22px); /* Kurangi 22px untuk mengakomodasi ikon panah */
            padding-right: 22px; /* Ruang untuk ikon panah di dalam elemen select */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23333" width="18px" height="18px"><path d="M7 10l5 5 5-5H7z"/><path d="M0 0h24v24H0z" fill="none"/></svg>'); /* Tambahkan ikon panah sebagai latar belakang */
            background-repeat: no-repeat;
            background-position: right 10px; /* Atur posisi ikon panah */
            appearance: none; /* Sembunyikan panah bawaan */
        }

        select:focus {
            outline: none;
            border-color: #007bff;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #106744;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Pesan sukses dan kesalahan */
        .success-message {
            color: green;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
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
            <?php
            include 'koneksi.php'; 
            // Fungsi untuk melakukan registrasi
            function register($conn) {
                echo "<h2>Registrasi</h2>";
                echo '<form method="post" action="">';
                echo 'Username: <input type="text" name="Username" required><br>';
                echo 'Password: <input type="password" name="Password" required><br>';
                echo 'Email: <input type="email" name="Email" required><br>';
                echo 'Nama Lengkap: <input type="text" name="NamaLengkap" required><br>';
                echo 'Alamat: <textarea name="Alamat"></textarea><br>';
                echo 'Level: <select name="level">
                            <option value="administrator">Administrator</option>
                            <option value="petugas">Petugas</option>
                            <option value="peminjam">Peminjam</option>
                          </select><br>';
                echo '<input type="submit" value="Register">';
                echo '</form>';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $Username = $_POST['Username'];
                    $Password = $_POST['Password'];
                    $Email = $_POST['Email'];
                    $NamaLengkap = $_POST['NamaLengkap'];
                    $Alamat = $_POST['Alamat'];
                    $level = $_POST['level'];
                    $randomID = rand(100000000, 999999999);

                    $sql = "INSERT INTO user (UserID, Username, Password, Email, NamaLengkap, Alamat, Level)
                            VALUES ('$randomID', '$Username', '$Password', '$Email', '$NamaLengkap', '$Alamat', '$level')";

                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="success-message">Registrasi berhasil untuk pengguna: ' . $Username . '</div>';
                    } else {
                        echo '<div class="error-message">Error: ' . $conn->error . '</div>';
                    }
                }
            }

            // Panggil fungsi registrasi
            register($conn);
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