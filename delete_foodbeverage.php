<?php
// File: delete_foodbeverage.php

// 1. Sertakan file koneksi database
include 'koneksi.php';

// Cek apakah parameter ID_DETAIL_FNB telah diterima melalui GET
if (isset($_GET['id'])) {
    // Ambil dan bersihkan ID untuk mencegah SQL Injection
    $id_detail_fnb = $koneksi->real_escape_string($_GET['id']);

    // 2. Buat query DELETE
    // Perhatikan: Karena data ini adalah detail transaksi (detail_food_n_beverage),
    // kita hanya menghapus baris dari tabel detail tersebut.
    $sql = "DELETE FROM detail_food_n_beverage WHERE ID_DETAIL_FNB = '$id_detail_fnb'";

    // 3. Jalankan query
    if ($koneksi->query($sql) === TRUE) {
        // Jika penghapusan berhasil, tampilkan pesan sukses dan redirect kembali ke halaman utama
        echo "<script>
                alert('Data Food & Beverage berhasil dihapus!');
                window.location.href = 'detail_food_n_beverage.php'; // Ganti dengan nama file tabel utama Anda
              </script>";
        exit;
    } else {
        // Jika terjadi error saat menjalankan query
        echo "<script>
                alert('Error saat menghapus data: " . $koneksi->error . "');
                window.location.href = 'detail_food_n_beverage.php'; 
              </script>";
        exit;
    }
} else {
    // Jika ID tidak ditemukan di URL
    echo "<script>
            alert('ID Detail F&B tidak ditemukan.');
            window.location.href = 'detail_food_n_beverage.php';
          </script>";
    exit;
}

// Tutup koneksi (meskipun exit akan menghentikan skrip)
$koneksi->close();
?>