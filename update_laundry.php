<?php
// File: update_detail_laundry.php

include 'koneksi.php';

// =======================================================
// === BAGIAN 1: Mengambil Data Lama (Data yang akan di-edit) ===
// =======================================================
$data_lama = null;
$error_message = '';

if (isset($_GET['id'])) {
    $id_detail_laundry = $koneksi->real_escape_string($_GET['id']);

    // Query join untuk mengambil semua data yang diperlukan
    $sql_get = "SELECT 
                    dl.ID_DETAIL_LAUNDRY,
                    dl.ID_LAUNDRY,
                    dl.ID_PELANGGAN,
                    dl.TGL_LAUNDRY,
                    dl.JAM_LAUNDRY,
                    dl.JENIS_LAUNDRY,
                    dl.HARGA_SATUAN,
                    dl.JUMLAH_LAUNDRY,
                    dl.TOTAL_LAUNDRY,
                    l.KODE_LAUNDRY,
                    p.NAMA_PELANGGAN,
                    k.NO_KAMAR
                FROM detail_laundry dl
                INNER JOIN laundry l ON dl.ID_LAUNDRY = l.ID_LAUNDRY
                INNER JOIN pelanggan p ON dl.ID_PELANGGAN = p.ID_PELANGGAN
                INNER JOIN kamar k ON l.ID_KAMAR = k.ID_KAMAR
                WHERE dl.ID_DETAIL_LAUNDRY = '$id_detail_laundry' LIMIT 1";
    
    $result_get = $koneksi->query($sql_get);

    if ($result_get && $result_get->num_rows > 0) {
        $data_lama = $result_get->fetch_assoc();
    } else {
        $error_message = "Data Detail Laundry tidak ditemukan.";
    }
} else {
    $error_message = "ID Detail Laundry tidak disediakan.";
}

// =======================================================
// === BAGIAN 2: Menangani Proses Update (Data dari POST) ===
// =======================================================

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_data']) && $data_lama) {
    
    // Ambil data dari formulir
    $id_detail_laundry_post = $koneksi->real_escape_string($_POST['ID_DETAIL_LAUNDRY']);
    // ID_LAUNDRY dan ID_PELANGGAN tidak diubah karena merupakan kunci relasi utama detail
    $tgl_laundry_post       = $koneksi->real_escape_string($_POST['tgl_laundry']);
    $jam_laundry_post       = $koneksi->real_escape_string($_POST['jam_laundry']);
    $jenis_laundry_post     = $koneksi->real_escape_string($_POST['jenis_laundry']);
    
    // Ambil nilai numerik untuk perhitungan
    $harga_satuan_post      = (float)$_POST['harga_satuan'];
    $jumlah_laundry_post    = (float)$_POST['jumlah_laundry'];
    
    // Re-hitung Total Laundry di sisi server untuk validasi
    $total_laundry_post = $harga_satuan_post * $jumlah_laundry_post; 

    // Query UPDATE
    $sql_update = "UPDATE detail_laundry SET
                    TGL_LAUNDRY = ?,
                    JAM_LAUNDRY = ?,
                    JENIS_LAUNDRY = ?,
                    HARGA_SATUAN = ?,
                    JUMLAH_LAUNDRY = ?,
                    TOTAL_LAUNDRY = ?
                   WHERE ID_DETAIL_LAUNDRY = ?";

    $update_stmt = $koneksi->prepare($sql_update);
    
    if ($update_stmt) {
        // iissiii (integer, string, string, string, integer, integer, integer)
        $update_stmt->bind_param("sssdddi", 
                                $tgl_laundry_post, 
                                $jam_laundry_post, 
                                $jenis_laundry_post, 
                                $harga_satuan_post, 
                                $jumlah_laundry_post, 
                                $total_laundry_post,
                                $id_detail_laundry_post);

        if ($update_stmt->execute()) {
            echo "<script>
                    alert('✅ Data Detail Laundry berhasil diupdate! Total Baru: Rp " . number_format($total_laundry_post, 0, ',', '.') . "');
                    window.location.href = 'detail_laundry.php'; 
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('❌ Error saat mengupdate data: " . addslashes($update_stmt->error) . "');
                    window.history.back();
                  </script>";
            exit;
        }
        $update_stmt->close();
    } else {
        echo "<script>
                alert('❌ Gagal menyiapkan statement UPDATE: " . addslashes($koneksi->error) . "');
                window.history.back();
              </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Detail Laundry</title>
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include 'header.php'; ?>
    <?php include 'navbar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Update Data Detail Laundry</h1>
            </div>
        </section>

        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Update Detail Laundry</h3>
                </div>
                
                <?php if ($error_message): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php elseif ($data_lama): ?>

                <form method="POST" action="">
                    <div class="card-body">
                        <input type="hidden" name="ID_DETAIL_LAUNDRY" value="<?= htmlspecialchars($data_lama['ID_DETAIL_LAUNDRY']); ?>">

                        <div class="form-group">
                            <label>Kode Laundry</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($data_lama['KODE_LAUNDRY']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($data_lama['NAMA_PELANGGAN']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nomor Kamar</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($data_lama['NO_KAMAR']); ?>" readonly> 
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <label for="tgl_laundry">Tanggal Laundry</label>
                            <input type="date" class="form-control" id="tgl_laundry" name="tgl_laundry" 
                                   value="<?= htmlspecialchars($data_lama['TGL_LAUNDRY']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="jam_laundry">Jam Laundry</label>
                            <input type="time" class="form-control" id="jam_laundry" name="jam_laundry" 
                                   value="<?= htmlspecialchars($data_lama['JAM_LAUNDRY']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="jenis_laundry">Jenis Laundry</label>
                            <input type="text" class="form-control" id="jenis_laundry" name="jenis_laundry" 
                                   value="<?= htmlspecialchars($data_lama['JENIS_LAUNDRY']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="harga_satuan">Harga Satuan (Rp)</label>
                            <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" 
                                   value="<?= htmlspecialchars($data_lama['HARGA_SATUAN']); ?>" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_laundry">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah_laundry" name="jumlah_laundry" 
                                   value="<?= htmlspecialchars($data_lama['JUMLAH_LAUNDRY']); ?>" min="1" required>
                        </div>

                        <div class="form-group">
                            <label>Total Laundry (Rp)</label>
                            <input type="text" class="form-control" id="total_laundry_display" 
                                   value="Rp <?= number_format($data_lama['TOTAL_LAUNDRY'], 0, ',', '.'); ?>" readonly>
                            </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" name="update_data" class="btn btn-primary">Update Data</button>
                        <a href="detail_laundry.php" class="btn btn-default">Batal</a>
                    </div>
                </form>
                
                <?php endif; ?>
                
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function(){
    // Fungsi Menghitung Total Otomatis (HARGA * JUMLAH)
    function calculateTotal() {
        const harga = parseFloat($("#harga_satuan").val()) || 0;
        const jumlah = parseFloat($("#jumlah_laundry").val()) || 0;
        const total = harga * jumlah;
        
        // Format dan tampilkan total
        $("#total_laundry_display").val('Rp ' + total.toLocaleString('id-ID'));
    }

    // Panggil fungsi saat halaman dimuat (untuk inisialisasi)
    calculateTotal(); 
    
    // Panggil fungsi saat input harga atau jumlah berubah
    $("#harga_satuan, #jumlah_laundry").on('input', calculateTotal);
});
</script>
</body>
</html>