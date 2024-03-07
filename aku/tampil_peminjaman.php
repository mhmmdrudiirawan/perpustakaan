<?php
// Sertakan file koneksi database
include('koneksi.php');

// Fungsi untuk mengedit peminjaman
function editPeminjaman($conn, $peminjamanID) {
    // Implementasikan logika untuk mengedit peminjaman di sini
    // Misalnya, Anda bisa mengarahkan pengguna ke halaman edit peminjaman dengan membawa ID peminjaman
    header("Location: editpeminjaman.php?id=" . $peminjamanID);
    exit();
}

// Fungsi untuk menghapus peminjaman
function hapusPeminjaman($conn, $peminjamanID) {
    // Lakukan penghapusan data peminjaman dari database
    $sql = "DELETE FROM peminjaman WHERE PeminjamanID = '$peminjamanID'";
    if ($conn->query($sql) === TRUE) {
        echo "Peminjaman berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Periksa apakah ada permintaan POST untuk menghapus peminjaman
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hapus_peminjaman'])) {
    $peminjamanID = $_POST['peminjaman_id'];
    hapusPeminjaman($conn, $peminjamanID);
}

// Periksa apakah ada permintaan POST untuk mengedit peminjaman
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_peminjaman'])) {
    $peminjamanID = $_POST['peminjaman_id'];
    editPeminjaman($conn, $peminjamanID);
}

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil nilai bulan yang dipilih oleh pengguna, jika ada
$selectedMonth = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Ambil bulan saat ini jika tidak ada yang dipilih
$selectedYear = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Ambil tahun saat ini jika tidak ada yang dipilih

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
    <link rel="stylesheet" href="style.css">
    <style>
                .no-data {
                    text-align: center;
                    margin-top: 20px;
                }
                .btn-back {
                    margin-top: 10px;
                    display: block;
                    margin: 0 auto;
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
        <style>
            /* Gaya untuk mencetak hanya tabel */
            @media print {
                body * {
                    visibility: hidden;
                }
                #table-container, #table-container * {
                    visibility: visible;
                }
                #table-container {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
            }
        </style>

    </header>
    <section class="content">
        <div class="container">
            <h2>Riwayat Peminjaman</h2>
            <form action="" method="get">
                <label for="bulan">Pilih Bulan:</label>
                <select name="bulan" id="bulan">
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $monthName = date('F', mktime(0, 0, 0, $i, 1));
                        $selected = ($i == $selectedMonth) ? 'selected' : ''; // Tambahkan ini untuk menentukan opsi yang dipilih
                        echo "<option value='$i' $selected>$monthName</option>";
                    }
                    ?>
                </select>
                <label for="tahun">Pilih Tahun:</label>
                <select name="tahun" id="tahun">
                    <?php
                    $currentYear = date('Y');
                    for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                        $selected = ($i == $selectedYear) ? 'selected' : '';
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>
                <button type="submit">Tampilkan</button>
                <button type="button" onclick="cetakData()">Cetak</button>
            </form>

            <?php
            // Query untuk mengambil data peminjaman dari semua peminjam berdasarkan bulan dan tahun yang dipilih
            $sql = "SELECT PeminjamanID, user.Username, buku.Judul, peminjaman.TanggalPeminjaman, peminjaman.TanggalPengembalian, peminjaman.StatusPeminjaman 
                    FROM peminjaman 
                    JOIN buku ON peminjaman.BukuID = buku.BukuID
                    JOIN user ON peminjaman.UserID = user.UserID
                    WHERE MONTH(peminjaman.TanggalPeminjaman) = '$selectedMonth'
                    AND YEAR(peminjaman.TanggalPeminjaman) = '$selectedYear'";
            $result = $conn->query($sql);

            // Periksa apakah query berhasil dieksekusi
            if ($result) {
                if ($result->num_rows > 0) {
                    ?>
                    <div id="table-container">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th><button type="button" onclick="sortTable(1)">Nama </button></th>
                                    <th style="text-align: center;"><button type="button" onclick="sortTable(2)">Judul Buku</button></th>
                                    <th><button type="button" onclick="sortTable(3)">Tanggal Peminjaman</button></th>
                                    <th><button type="button" onclick="sortTable(4)">Tanggal Pengembalian</button></th>
                                    <th><button type="button" onclick="sortTable(5)">Status Peminjaman</button></th>
                                    <th class="aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $row['Username'] ?></td>
                                        <td><?= $row['Judul'] ?></td>
                                        <td><?= $row['TanggalPeminjaman'] ?></td>
                                        <td><?= $row['TanggalPengembalian'] ?></td>
                                        <td><?= $row['StatusPeminjaman'] ?></td>
                                        <td class="aksi">
                                            <form action="" method="post">
                                                <input type="hidden" name="peminjaman_id" value="<?= $row['PeminjamanID'] ?>">
                                                <button type="submit" name="edit_peminjaman">Edit</button>
                                                <button type="submit" name="hapus_peminjaman">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="no-data">
                        <p>Tidak ada riwayat peminjaman.</p>
                        <!-- Tambahkan link atau tombol untuk kembali ke halaman sebelumnya -->
                    </div>
                    <?php
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            ?>
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
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }
    </script>

<script>
    function cetakData() { var bulan = document.getElementById("bulan").value; var tahun = document.getElementById("tahun").value; window.location.href = "print.php?bulan=" + bulan + "&tahun=" + tahun; }
</script>
<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.querySelector(".content-table");
        switching = true;
        // Set ke mode ascending
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[n];
                y = rows[i + 1].getElementsByTagName("td")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>



</body>
</html>

<?php
// Tutup koneksi ke database
$conn->close();
?>
