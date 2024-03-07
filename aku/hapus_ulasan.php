<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Sertakan file koneksi database
        include('koneksi.php');

        // Periksa apakah permintaan POST telah diterima dengan benar
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Peroleh nilai UlasanID dari permintaan POST
            $ulasan_id = $_POST["UlasanID"];

            // Buat query SQL untuk menghapus ulasan berdasarkan UlasanID
            $sql = "DELETE FROM ulasanbuku WHERE UlasanID = $ulasan_id";

            // Eksekusi query
            if ($conn->query($sql) === TRUE) {
                // Jika penghapusan berhasil, tampilkan notifikasi berhasil
                echo "<div class='success'>Ulasan berhasil dihapus.</div>";
            } else {
                // Jika terjadi kesalahan dalam penghapusan, tampilkan pesan kesalahan
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // Jika permintaan tidak valid, tampilkan pesan tidak valid
            echo "Permintaan tidak valid.";
        }

        // Tutup koneksi ke database
        $conn->close();
        ?>
        <a href="tampilulasan.php" class="btn">Oke</a>
    </div>
</body>
</html>
