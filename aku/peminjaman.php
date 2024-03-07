<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
    <!-- Tambahkan CSS Anda di sini -->
    <style>
        /* Tambahkan CSS sesuai kebutuhan */
    </style>
</head>
<body>
    <header>
        <!-- Tambahkan header sesuai kebutuhan -->
    </header>

    <main>
        <h1>Riwayat Peminjaman</h1>
        <table>
            <thead>
                <tr>
                    <th>Peminjaman ID</th>
                    <th>UserID</th>
                    <th>BukuID</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Looping data riwayat peminjaman di sini -->
                <tr>
    <td><?php echo isset($PeminjamanID) ? $PeminjamanID : ""; ?></td>
    <td><?php echo isset($UserID) ? $UserID : ""; ?></td>
    <td><?php echo isset($BukuID) ? $BukuID : ""; ?></td>
    <td><?php echo isset($TanggalPeminjaman) ? $TanggalPeminjaman : ""; ?></td>
    <td><?php echo isset($TanggalPengembalian) ? $TanggalPengembalian : ""; ?></td>
    <td><?php echo isset($StatusPeminjaman) ? $StatusPeminjaman : ""; ?></td>
    <td>
        <?php if (isset($StatusPeminjaman) && $StatusPeminjaman == "Dipinjam") { ?>
            <button onclick="kembalikan()">Kembalikan</button>
        <?php } ?>
    </td>
</tr>


            </tbody>
        </table>
    </main>

    <footer>
        <!-- Tambahkan footer sesuai kebutuhan -->
    </footer>

    <!-- Tambahkan script JavaScript Anda di sini -->
    <script>
        // Tambahkan fungsi kembalikan di sini
        function kembalikan() {
            // Implementasi logika pengembalian buku
        }
    </script>
</body>
</html>
