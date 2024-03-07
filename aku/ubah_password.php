<?php
// Sertakan file koneksi database
include('koneksi.php');

// Mulai session jika belum dimulai
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
$error = '';
$success_message = '';

// Proses update password jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah old_password dan password ada di $_POST sebelum mencoba mengaksesnya
    if(isset($_POST['old_password']) && isset($_POST['password'])) {
        // Ambil data dari form
        $old_password = $_POST['old_password'];
        $new_password = $_POST['password'];

        // Query untuk memeriksa password lama
        $sql_check_password = "SELECT Password FROM user WHERE UserID = ?";
        $stmt = $conn->prepare($sql_check_password);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result_check_password = $stmt->get_result();

        if ($result_check_password->num_rows > 0) {
            $row_password = $result_check_password->fetch_assoc();
            $stored_password = $row_password['Password'];
            if ($old_password == $stored_password) {
                // Jika password lama cocok, lanjutkan dengan update
                // Lakukan update password
                $sql_update = "UPDATE user SET Password=? WHERE UserID=?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("si", $new_password, $user_id);
                if ($stmt_update->execute()) {
                    $success_message = 'Password berhasil diperbarui!';
                } else {
                    // Jika terjadi kesalahan saat update, tangani error
                    $error = "Error: Gagal memperbarui password.";
                }
            } else {
                // Jika password lama tidak cocok, tampilkan pesan kesalahan
                $error = "Password lama tidak sesuai.";
            }
        } else {
            // Jika tidak ada hasil dari query password, tangani error
            $error = "Error: Tidak dapat memeriksa password lama.";
        }
    } 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('img/1.jpg'); /* Ganti 'path/to/background/image.jpg' dengan lokasi gambar latar belakang Anda */
    background-size: cover; /* Menyesuaikan ukuran gambar agar mencakup seluruh area */
    background-position: center; /* Memusatkan gambar latar belakang */
}
</style>
</head>
<body>
    <section class="content">
        <div class="container">
            <button onclick="location.href='profile.php';" style="margin-bottom: 20px;" >kembali</button>
            <?php if($error != ''): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php elseif($success_message != ''): ?>
                <div class="success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="old_password">Password Lama:</label><br>
                <input type="password" id="old_password" name="old_password" required><br><br>
                <label for="password">Password Baru:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Update">
            </form>
        </div>
    </section>
</body>
</html>
