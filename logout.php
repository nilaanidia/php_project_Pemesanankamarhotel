<?php
session_start();
include "koneksi.php";

// Cek apakah user sudah login
if(isset($_SESSION['email'])) {

    $email = $_SESSION['email'];

    // Update status pelanggan menjadi tidak aktif
    $update = "UPDATE pelanggan 
               SET STATUS_PELANGGAN='Tidak Aktif', verify_status='0'
               WHERE EMAIL='$email'";
    mysqli_query($koneksi, $update);

    // Hapus session
    session_unset();
    session_destroy();

    // Mencegah halaman tersimpan cache
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Pindah ke login
    echo "<script>
            alert('Anda telah logout. Status berubah menjadi tidak aktif dan verifikasi dinonaktifkan.');
            window.location='login.php';
          </script>";
    exit;

} else {

    // Jika tidak ada session
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    header("Location: login.php");
    exit;
}
?>
