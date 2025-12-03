<?php
$host = "localhost";
$user = "root";
$password_db = ""; 
$database = "hotel"; 

$koneksi = new mysqli($host, $user, $password_db, $database);


if ($koneksi->connect_error) {
    die("Koneksi database GAGAL: " . $koneksi->connect_error);
}

 ?> 