<?php
// Sertakan file koneksi database
include('koneksi.php');

// Periksa apakah session telah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna telah masuk
if (!isset($_SESSION['UserID'])) {
    // Redirect ke halaman login jika pengguna belum masuk
    header("Location: login.php");
    exit;
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['UserID'];

// Inisialisasi variabel
$username = $email = $namaLengkap = $alamat = '';
$error = '';
$success_message = '';

// Ambil data pengguna berdasarkan ID
$sql = "SELECT * FROM user WHERE UserID = $user_id";
$result = $conn->query($sql);

if ($result) {
    // Jika query berhasil dijalankan
    if ($result->num_rows > 0) {
        // Jika data pengguna ditemukan, isi variabel dengan nilai yang ada
        $row = $result->fetch_assoc();
        $username = isset($row['Username']) ? $row['Username'] : '';
        $email = isset($row['Email']) ? $row['Email'] : '';
        $namaLengkap = isset($row['NamaLengkap']) ? $row['NamaLengkap'] : '';
        $alamat = isset($row['Alamat']) ? $row['Alamat'] : '';
    } else {
        // Jika tidak ada data pengguna yang sesuai dengan ID, tampilkan pesan error
        $error = 'Tidak ada data pengguna yang ditemukan.';
    }
} else {
    // Jika terjadi kesalahan saat menjalankan query, tangani error
    $error = "Error: " . $conn->error;
}

// Proses update profil jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $namaLengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];

    // Query untuk melakukan update data pengguna
    $sql_update = "UPDATE user SET Username='$username', Email='$email', NamaLengkap='$namaLengkap', Alamat='$alamat' WHERE UserID=$user_id";

    if ($conn->query($sql_update) === TRUE) {
        // Jika update berhasil, arahkan ke halaman lain
        header("Location: update_success.php");
        exit;
    } else {
        // Jika terjadi kesalahan saat update, tangani error
        $error = "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('img/lib.jpg'); /* Ganti 'path/to/background/image.jpg' dengan lokasi gambar latar belakang Anda */
    background-size: cover; /* Menyesuaikan ukuran gambar agar mencakup seluruh area */
    background-position: center; /* Memusatkan gambar latar belakang */
}

                    .book-img {
    width: 150px; /* Sesuaikan ukuran gambar logo buku */
    height: auto; /* Biarkan tinggi menyesuaikan dengan proporsi */
    margin-left: 0px; /* Berikan margin kiri agar terpisah dari tombol navigasi */
}
</style>
<img src="img/buku1.png" alt="image" class="book-img">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="content">
        <div class="container">
            <?php if($error != ''): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>"><br><br>
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>"><br><br>
                <label for="nama_lengkap">Nama Lengkap:</label><br>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $namaLengkap; ?>"><br><br>
                <label for="alamat">Alamat:</label><br>
                <textarea id="alamat" name="alamat"><?php echo $alamat; ?></textarea><br><br>
                <input type="submit" value="Update">
            </form>
            <form method="post" action="ubah_password.php">
    <button type="submit">Ubah Password</button>
</form>

            
        </div>
    </section>
</body>
</html>

