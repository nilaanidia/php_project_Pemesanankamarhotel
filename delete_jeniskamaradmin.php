<?php

include "koneksi.php";


if (isset($_GET['id'])) {

    $id = $_GET['id'];


    $stmt = $koneksi->prepare("DELETE FROM jenis_kamar WHERE ID_JENIS_KAMAR = ?");

   
    $stmt->bind_param("i", $id); 

   
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
          
            echo "<script>
                    alert('🗑️ Data jenis kamar berhasil dihapus!');
                    window.location='jenis-kamaradmin.php';
                  </script>";
        } else {
            
             echo "<script>
                    alert('⚠️ Data jenis kamar dengan ID tersebut tidak ditemukan!');
                    window.history.back();
                  </script>";
        }
        $stmt->close();
        exit;
    } else {
        // Gagal eksekusi (Foreign Key Constraint, dll.)
        echo "<script>
                alert('❌ Gagal menghapus data: " . addslashes($stmt->error) . "');
                window.history.back();
              </script>";
        $stmt->close();
        exit;
    }
} else {

    echo "<script>
            alert('ID tidak ditemukan!');
            window.location='jenis-kamaradmin.php';
          </script>";
    exit;
}
?>