<?php
// File: project_hotel/index.php

// Mencegah caching
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// **********************************************
// * LOGIKA PENGALIHAN (REDIRECT) UTAMA *
// **********************************************

// Mengalihkan pengguna ke halaman login.php
// Pastikan file login Anda bernama 'login.php'
header("Location: login.php");
exit;

// Jika Anda ingin menambahkan logika otentikasi
/*
session_start();
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, alihkan ke login.php
    header("Location: login.php");
    exit;
} else {
    // Jika sudah login, alihkan ke dashboard.php
    header("Location: dashboard.php");
    exit;
}
*/
?>