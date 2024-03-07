<?php 
include('koneksi.php');

// Start the session
session_start();

// Retrieve data from query parameters
$selectedMonth = $_GET['bulan'];
$selectedYear = $_GET['tahun'];

// Query to fetch data based on selected month and year
$sql = "SELECT PeminjamanID, user.Username, buku.Judul, peminjaman.TanggalPeminjaman, peminjaman.TanggalPengembalian, peminjaman.StatusPeminjaman 
        FROM peminjaman 
        JOIN buku ON peminjaman.BukuID = buku.BukuID
        JOIN user ON peminjaman.UserID = user.UserID
        WHERE MONTH(peminjaman.TanggalPeminjaman) = '$selectedMonth'
        AND YEAR(peminjaman.TanggalPeminjaman) = '$selectedYear'";
$result = $conn->query($sql);

// Check if the query executed successfully
if ($result) {
    // Start HTML document
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <style>
            .book-img {
    width: 150px; /* Sesuaikan ukuran gambar logo buku */
    height: auto; /* Biarkan tinggi menyesuaikan dengan proporsi */
    margin-left: 0px; /* Berikan margin kiri agar terpisah dari tombol navigasi */
}
</style>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PERPUSTAKAANKU HEBAT</title>
    </head>
    <body>
    <img src="img/buku1.png" alt="image" class="book-img">

        <div style="text-align: center;">
            <h1>PERPUSTAKAANKU HEBAT</h1>
        </div>
        <!-- Table to display fetched data -->
        <table border="1">
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
            <tbody>
                <?php
                // Counter for numbering rows
                $no = 1;
                // Loop through each row of fetched data
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $row['Username'] ?></td>
                        <td><?= $row['Judul'] ?></td>
                        <td><?= $row['TanggalPeminjaman'] ?></td>
                        <td><?= $row['TanggalPengembalian'] ?></td>
                        <td><?= $row['StatusPeminjaman'] ?></td>
                    </tr>
                    <?php
                    $no++; // Increment row counter
                }
                ?>
            </tbody>
        </table>
        <!-- Include signature and name of the librarian -->
        <div style="text-align: right;">
            <p>data peminjaman pada tanggal ... / <?= $selectedMonth ?> / <?= $selectedYear ?></p>
            <br>
            <br>
            <p> ____________________</p>
            
            <?php 
                // Check if the session variable is set before displaying it
                if(isset($_SESSION['Username'])) {
                    echo "<p>" . $_SESSION['Username'] . "</p>";
                } else {
                    echo "<p>Session username not set.</p>";
                }
            ?>
            </br>
            </br>
        </div>
        <!-- Include JavaScript for printing -->
        <script>
            // Use window.print() to trigger printing when the page loads
            window.onload = function() {
                window.print();
            };
        </script>
    </body>
    </html>
    <?php
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
