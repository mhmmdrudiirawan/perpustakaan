<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <style>
        header {
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>PERPUSTAKAAN KU HEBAT</h1>
    </header>

    <?php
    // Sertakan file koneksi database
    include('koneksi.php');

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil nilai bulan yang dipilih oleh pengguna, jika ada
    $selectedMonth = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Ambil bulan saat ini jika tidak ada yang dipilih

    // Query untuk mengambil data peminjaman dari semua peminjam berdasarkan bulan yang dipilih
    $sql = "SELECT PeminjamanID, user.Username, buku.Judul, peminjaman.TanggalPeminjaman, peminjaman.TanggalPengembalian, peminjaman.StatusPeminjaman 
            FROM peminjaman 
            JOIN buku ON peminjaman.BukuID = buku.BukuID
            JOIN user ON peminjaman.UserID = user.UserID
            WHERE MONTH(peminjaman.TanggalPeminjaman) = '$selectedMonth'";
    $result = $conn->query($sql);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        if ($result->num_rows > 0) {
            // Tampilkan data peminjaman dalam bentuk tabel
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>PeminjamanID</th>
                            <th>Nama Pengguna</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            // Tampilkan data peminjaman
            while ($row = $result->fetch_assoc()) {
                // Tampilkan data peminjaman dalam baris tabel
                echo "<tr>
                        <td>" . $row['PeminjamanID'] . "</td>
                        <td>" . $row['Username'] . "</td>
                        <td>" . $row['Judul'] . "</td>
                        <td>" . $row['TanggalPeminjaman'] . "</td>
                        <td>" . $row['TanggalPengembalian'] . "</td>
                        <td>" . $row['StatusPeminjaman'] . "</td>
                    </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "Tidak ada data peminjaman untuk bulan ini.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi ke database
    $conn->close();
    ?>
    <script>
        // Fungsi untuk langsung mencetak saat tombol "Print" ditekan
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
