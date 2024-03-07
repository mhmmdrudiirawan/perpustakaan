<?php
// Mulai sesi PHP
session_start();

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman lain yang diinginkan
header("Location: login.php");
exit;
?>
