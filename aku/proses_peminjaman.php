<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Laporan Peminjam</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .notification-success {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .notification-success button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .notification-success button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    include "koneksi.php";

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Pastikan data yang diperlukan tersedia dalam $_POST sebelum mengaksesnya
    if(isset($_POST['UserID'], $_POST['BukuID'], $_POST['TanggalPeminjaman'], $_POST['TanggalPengembalian'], $_POST['StatusPeminjaman'])) {
        // Ambil data dari formulir
        $UserID = $_POST['UserID'];
        $BukuID = $_POST['BukuID'];
        $TanggalPeminjaman = $_POST['TanggalPeminjaman'];
        $TanggalPengembalian = $_POST['TanggalPengembalian'];
        $StatusPeminjaman = $_POST['StatusPeminjaman'];
        $randomID = rand(100000, 999999);

        // Query untuk memeriksa apakah BukuID yang dimasukkan ada di tabel buku
        $check_book_query = "SELECT BukuID FROM buku WHERE BukuID = '$BukuID'";
        $result = $conn->query($check_book_query);

        if ($result->num_rows > 0) {
            // Jika BukuID tersedia, maka lakukan INSERT ke dalam tabel peminjaman
            $sql = "INSERT INTO peminjaman (PeminjamanID, UserID, BukuID, TanggalPeminjaman, TanggalPengembalian, StatusPeminjaman)
                    VALUES ('$randomID', '$UserID', '$BukuID', '$TanggalPeminjaman', '$TanggalPengembalian', '$StatusPeminjaman')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='container'>";
                echo "<div class='notification-success'>Peminjaman berhasil disimpan</div>";
                echo "<button onclick='goBack()'>Oke</button>";
                echo "</div>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // Jika BukuID tidak tersedia di tabel buku, tampilkan pesan error
            echo "<div class='container'>";
            echo "<div class='notification-success'>Buku tidak ditemukan.</div>";
            echo "<button onclick='goBack()'>Kembali</button>";
            echo "</div>";
        }
    } else {
        echo "Data yang dibutuhkan tidak lengkap.";
    }

    // Tutup koneksi
    $conn->close();
    ?>

    <script>
    function goBack() {
        window.history.back();
    }
    </script>
</body>
</html>
