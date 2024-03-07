<?php
// Sertakan file koneksi database
include('koneksi.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil nilai bulan yang dipilih oleh pengguna, jika ada
$selectedMonth = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Ambil bulan saat ini jika tidak ada yang dipilih
$selectedYear = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Ambil tahun saat ini jika tidak ada yang dipilih

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
        // Buat tabel HTML
        echo "<table border='1'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pengguna</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status Peminjaman</th>
                    </tr>
                </thead>
                <tbody>";
        $no = 1;
        // Tampilkan data peminjaman dalam tabel
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>$no</td>
                    <td>{$row['Username']}</td>
                    <td>{$row['Judul']}</td>
                    <td>{$row['TanggalPeminjaman']}</td>
                    <td>{$row['TanggalPengembalian']}</td>
                    <td>{$row['StatusPeminjaman']}</td>
                  </tr>";
            $no++;
        }
        echo "</tbody></table>";

        // Script JavaScript untuk menyimpan halaman sebagai file HTML
        echo "<script>
                var downloadButton = document.createElement('button');
                downloadButton.innerHTML = 'Download';
                downloadButton.onclick = function() {
                    var htmlContent = document.documentElement.outerHTML;
                    var blob = new Blob([htmlContent], {type: 'text/html'});
                    var url = URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'riwayat_peminjaman.html';
                    a.click();
                    URL.revokeObjectURL(url);
                };
                document.body.appendChild(downloadButton);
              </script>";
    } else {
        echo "Tidak ada data peminjaman untuk bulan dan tahun yang dipilih.";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi ke database
$conn->close();
?>
