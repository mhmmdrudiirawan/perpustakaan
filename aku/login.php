<?php
require 'koneksi.php';
session_start();

// Check if cookie is set
if (isset($_COOKIE['UserID']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['UserID'];
    $key = $_COOKIE['key'];

    // Fetch user data based on cookie
    $result = $conn->query("SELECT * FROM user WHERE UserID = '$id'");
    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify cookie
        if ($key === $row['UserID']) {
            $_SESSION['login'] = true;
            $_SESSION['UserID'] = $row['UserID']; // Store user id in session
        }
    }
}

// Handle form submission
if (isset($_POST["login"])) {
    $Username = $_POST["Username"];
    $Password = $_POST["Password"];

    // Check for empty fields
    if (empty($Username) || empty($Password)) {
        echo "<script>alert('Username dan password wajib diisi'); window.location='login.php';</script>";
        exit;
    }

    $result = $conn->query("SELECT * FROM user WHERE Username = '$Username'");
        if ($result->num_rows === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($Password == $row["Password"]) {
            // Set session variables
            $_SESSION["login"] = true;
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['Username'] = $row['Username'];
            $_SESSION['level'] = $row['level'];
            $level = $row['level'];

            // Redirect based on user level
            switch ($level) {
                case 'administrator':
                    header("Location: index.php");
                    exit;
                case 'petugas':
                    header("Location: petugas.php");
                    exit;
                case 'peminjam':
                    header("Location: peminjam.php");
                    exit;
            }
        } else {
            echo "<script>alert('Password salah'); window.location='login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Username tidak ditemukan'); window.location='login.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('img/perpus.jpg'); /* Ganti 'path/to/your/image.jpg' dengan lokasi gambar Anda */
    background-size: cover; /* Sesuaikan ukuran gambar agar menutupi seluruh area */
    background-position: center; /* Pusatkan gambar */
    background-repeat: no-repeat; /* Atur gambar tidak diulang */
}

        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color:#106744;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: black;
        }

        .book-img {
            width: 150px; /* Sesuaikan ukuran gambar logo buku */
            height: auto; /* Biarkan tinggi menyesuaikan dengan proporsi */
            margin-left: 125px; /* Berikan margin kiri agar terpisah dari tombol navigasi */
        }

        .brush-script {
            font-family: "Brush Script MT", cursive;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <p style="text-align: center;">
            <span class="brush-script">-----------PERPUSTAKAANKU HEBAT-----------</span>
        </p>
        
        <img src="img/buku1.png" alt="image" class="book-img">
        <form action="" method="post">
            <label for="Username">Username:</label>
            <input type="text" id="Username" name="Username" required>

            <label for="Password">Password:</label>
            <input type="password" id="Password" name="Password" required>

            <input type="submit" value="Login" name="login">
        </form>
    </div>
</body>
</html>
