<?php
include 'koneksi.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Konversi ke integer untuk keamanan
    
    // Cek apakah koneksi berhasil
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }
    
    // Gunakan prepared statement
    $stmt = $koneksi->prepare("DELETE FROM checkin_checkout WHERE ID_CHECKIN_OUT = ?");
    
    if ($stmt === false) {
        die("Error prepare statement: " . $koneksi->error);
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            $koneksi->close();
            echo "<script>
                    alert('✅ Data check-in/check-out berhasil dihapus!');
                    window.location.href='checkinout_admin.php';
                  </script>";
            exit();
        } else {
            $stmt->close();
            $koneksi->close();
            echo "<script>
                    alert('⚠️ Data tidak ditemukan atau sudah dihapus!');
                    window.location.href='checkinout_admin.php';
                  </script>";
            exit();
        }
    } else {
        $error_message = $stmt->error;
        $stmt->close();
        $koneksi->close();
        
        // Cek apakah error karena foreign key constraint
        if (strpos($error_message, 'foreign key constraint') !== false || 
            strpos($error_message, 'Cannot delete') !== false) {
            echo "<script>
                    alert('❌ Tidak dapat menghapus data karena masih terkait dengan data lain (kamar/pembayaran)!\\nHapus data terkait terlebih dahulu.');
                    window.location.href='checkinout_admin.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Gagal menghapus data: " . addslashes($error_message) . "');
                    window.location.href='checkinout_admin.php';
                  </script>";
        }
        exit();
    }
} else {
    $koneksi->close();
    echo "<script>
            alert('❌ ID tidak valid!');
            window.location.href='checkinout_admin.php';
          </script>";
    exit();
}
?>