<?php
$conn = new mysqli ("localhost","root","","perpustakaan1");

if ($conn->connect_error){
    die("koneksi gagal:".$conn->connect_error);
}