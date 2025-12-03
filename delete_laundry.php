<?php
// File: delete_detail_laundry.php

// Panggil file koneksi
include 'koneksi.php';

// Pastikan ID diterima
if (isset($_GET['id'])) {
    // Ambil dan bersihkan ID untuk mencegah SQL Injection
    $id_detail_laundry = $koneksi->real_escape_string($_GET['id']);

    // Buat query DELETE
    $sql = "DELETE FROM detail_laundry WHERE ID_DETAIL_LAUNDRY = '$id_detail_laundry'";

    // Jalankan query
    if ($koneksi->query($sql) === TRUE) {
        // Jika penghapusan berhasil
        echo "<script>
                alert('✅ Data Detail Laundry berhasil dihapus!');
                window.location.href = 'detail_laundry.php'; // Arahkan ke halaman daftar detail laundry
              </script>";
        exit;
    } else {
        // Jika terjadi error saat menjalankan query
        echo "<script>
                alert('❌ Error saat menghapus data: " . $koneksi->error . "');
                window.location.href = 'detail_laundry.php'; 
              </script>";
        exit;
    }
} else {
    // Jika ID tidak ditemukan di URL
    echo "<script>
            alert('❌ ID Detail Laundry tidak ditemukan.');
            window.location.href = 'detail_laundry.php';
          </script>";
    exit;
}

// Tutup koneksi
$koneksi->close();
?>