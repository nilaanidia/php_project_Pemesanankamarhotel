<?php
include 'koneksi.php';

// Aktifkan error reporting untuk debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Mulai transaksi
    $koneksi->begin_transaction();
    
    try {
        // Cek apakah data pemesanan ada
        $cek = $koneksi->query("SELECT * FROM pemesanan WHERE ID_PEMESANAN = '$id'");
        
        if ($cek->num_rows == 0) {
            throw new Exception('Data pemesanan tidak ditemukan!');
        }
        
        // Cek data terkait di checkin_checkout
        $cek_checkin = $koneksi->query("SELECT COUNT(*) as total FROM checkin_checkout WHERE ID_PEMESANAN = '$id'");
        $data_checkin = $cek_checkin->fetch_assoc();
        
        if ($data_checkin['total'] > 0) {
            // Hapus data checkin_checkout terlebih dahulu
            $koneksi->query("DELETE FROM checkin_checkout WHERE ID_PEMESANAN = '$id'");
        }
        
        // Cek dan hapus data terkait lainnya jika ada
        // Contoh: pembayaran, transaksi, dll
        $cek_pembayaran = $koneksi->query("SELECT COUNT(*) as total FROM pembayaran WHERE ID_PEMESANAN = '$id'");
        if ($cek_pembayaran) {
            $data_pembayaran = $cek_pembayaran->fetch_assoc();
            if ($data_pembayaran['total'] > 0) {
                $koneksi->query("DELETE FROM pembayaran WHERE ID_PEMESANAN = '$id'");
            }
        }
        
        // Hapus data pemesanan
        $koneksi->query("DELETE FROM pemesanan WHERE ID_PEMESANAN = '$id'");
        
        // Commit transaksi
        $koneksi->commit();
        
        echo "<script>
                alert('✅ Data pemesanan dan semua data terkait berhasil dihapus!');
                window.location.href='data_pemesananadmin.php';
              </script>";
        
    } catch (Exception $e) {
        // Rollback jika ada error
        $koneksi->rollback();
        
        $error_msg = $e->getMessage();
        
        if (strpos($error_msg, 'tidak ditemukan') !== false) {
            echo "<script>
                    alert('⚠️ " . addslashes($error_msg) . "');
                    window.location.href='data_pemesananadmin.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Gagal menghapus data!\\n\\nError: " . addslashes($error_msg) . "');
                    window.location.href='data_pemesananadmin.php';
                  </script>";
        }
    }
    
    $koneksi->close();
    
} else {
    echo "<script>
            alert('❌ ID pemesanan tidak valid!');
            window.location.href='data_pemesananadmin.php';
          </script>";
    exit;
}
?>