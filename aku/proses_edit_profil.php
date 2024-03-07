<?php
// Sertakan file koneksi.php
include 'koneksi.php';

// Proses form edit profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $UserID = $_POST['userID'];
    $Username = $_POST['username'];
    $Password = $_POST['password']; // Password lama
    $Email = $_POST['email'];
    $NamaLengkap = $_POST['nama_lengkap'];
    $Alamat = $_POST['alamat'];
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validasi data (misalnya: pastikan semua input tidak kosong, email valid, dll.)
    if (empty($Username) || empty($Email) || empty($NamaLengkap) || empty($Alamat) || empty($newUsername) || empty($newPassword) || empty($confirmPassword)) {
        echo "Harap lengkapi semua kolom!";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format email tidak valid!";
        exit();
    }

    if ($newPassword != $confirmPassword) {
        echo "Password baru dan konfirmasi password tidak cocok!";
        exit();
    }

    // Periksa kecocokan password lama dengan yang ada di database
    $sqlCheckPassword = "SELECT Password FROM user WHERE UserID = '$userID'";
    $result = $conn->query($sqlCheckPassword);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row["Password"];
        if (!password_verify($password, $storedPassword)) {
            echo "Password lama tidak cocok!";
            exit();
        }
    } else {
        echo "User tidak ditemukan!";
        exit();
    }

    // Hash password baru sebelum menyimpan ke database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Kueri SQL untuk memperbarui entri pengguna
    $sql = "UPDATE user SET Username='$newUsername', Password='$hashedPassword', Email='$email', NamaLengkap='$namaLengkap', Alamat='$alamat' WHERE UserID='$userID'";

    if ($conn->query($sql) === TRUE) {
        echo "Profil berhasil diperbarui!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
