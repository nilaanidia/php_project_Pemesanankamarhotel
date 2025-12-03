<?php
// File: update_foodbeverage.php

include 'koneksi.php';

// --- BAGIAN 1: Mengambil Data Lama (Data yang akan di-edit) ---

$data_lama = null;
$error_message = '';

if (isset($_GET['id'])) {
    $id_detail_fnb = $koneksi->real_escape_string($_GET['id']);

    // Query untuk mengambil data yang akan di-update
    $sql_get = "SELECT 
                    dfnb.ID_DETAIL_FNB,
                    dfnb.ID_FNB,
                    dfnb.ID_PELANGGAN,
                    fnb.KODE_FNB,
                    p.NAMA_PELANGGAN,
                    dfnb.TGL_FNB,
                    dfnb.JAM_FNB,
                    dfnb.FOOD,
                    dfnb.BEVERAGE,
                    dfnb.JUMLAH_FNB,
                    dfnb.SUBTOTAL_FNB,
                    dfnb.TOTAL_FNB
                FROM detail_food_n_beverage dfnb
                INNER JOIN pelanggan p ON dfnb.ID_PELANGGAN = p.ID_PELANGGAN
                INNER JOIN food_n_beverage fnb ON dfnb.ID_FNB = fnb.ID_FNB
                WHERE dfnb.ID_DETAIL_FNB = '$id_detail_fnb'";
    
    $result_get = $koneksi->query($sql_get);

    if ($result_get && $result_get->num_rows > 0) {
        $data_lama = $result_get->fetch_assoc();
    } else {
        $error_message = "Data tidak ditemukan.";
    }
} else {
    $error_message = "ID tidak disediakan.";
}

// Query untuk mengisi dropdown (Pelanggan dan FNB)
$sql_pelanggan = "SELECT ID_PELANGGAN, NAMA_PELANGGAN FROM pelanggan ORDER BY NAMA_PELANGGAN";
$result_pelanggan = $koneksi->query($sql_pelanggan);

$sql_fnb = "SELECT ID_FNB, KODE_FNB FROM food_n_beverage ORDER BY KODE_FNB";
$result_fnb = $koneksi->query($sql_fnb);


// --- BAGIAN 2: Menangani Proses Update (Data dari POST) ---

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data_lama) {
    // Ambil data dari formulir
    $id_detail_fnb_post = $koneksi->real_escape_string($_POST['ID_DETAIL_FNB']);
    $id_pelanggan_post = $koneksi->real_escape_string($_POST['ID_PELANGGAN']);
    $id_fnb_post = $koneksi->real_escape_string($_POST['ID_FNB']);
    
    $tgl_fnb_post = $koneksi->real_escape_string($_POST['TGL_FNB']);
    $jam_fnb_post = $koneksi->real_escape_string($_POST['JAM_FNB']);
    $food_post = $koneksi->real_escape_string($_POST['FOOD']);
    $beverage_post = $koneksi->real_escape_string($_POST['BEVERAGE']);
    
    // Ambil nilai numerik dari form untuk perhitungan
    $jumlah_fnb_post = (float)$_POST['JUMLAH_FNB']; // Harga Satuan
    $subtotal_fnb_post = (float)$_POST['SUBTOTAL_FNB']; // Kuantitas Pesanan
    
    // Re-hitung TOTAL di sisi server untuk validasi (Penting!)
    $total_fnb_post = $jumlah_fnb_post * $subtotal_fnb_post; 

    // Query UPDATE
    $sql_update = "UPDATE detail_food_n_beverage SET
                    ID_PELANGGAN = '$id_pelanggan_post',
                    ID_FNB = '$id_fnb_post',
                    TGL_FNB = '$tgl_fnb_post',
                    JAM_FNB = '$jam_fnb_post',
                    FOOD = '$food_post',
                    BEVERAGE = '$beverage_post',
                    JUMLAH_FNB = '$jumlah_fnb_post',
                    SUBTOTAL_FNB = '$subtotal_fnb_post',
                    TOTAL_FNB = '$total_fnb_post' -- Menggunakan nilai yang dihitung di server
                   WHERE ID_DETAIL_FNB = '$id_detail_fnb_post'";

    if ($koneksi->query($sql_update) === TRUE) {
        echo "<script>
                alert('Data Food & Beverage berhasil diupdate!');
                window.location.href = 'detail_food_n_beverage.php'; 
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error saat mengupdate data: " . $koneksi->error . "');
                window.location.href = 'detail_food_n_beverage.php?id=" . $id_detail_fnb_post . "';
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
    <title>Update Food & Beverage</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>UPDATE DATA FOOD & BEVERAGE</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Formulir Update Detail F&B</h3>
                </div>
                
                <?php if ($error_message): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php elseif ($data_lama): ?>

                <form method="POST" action="">
                    <div class="card-body">
                        <input type="hidden" name="ID_DETAIL_FNB" value="<?php echo htmlspecialchars($data_lama['ID_DETAIL_FNB']); ?>">

                        <div class="form-group">
                            <label for="ID_PELANGGAN">Nama Pelanggan</label>
                            <select class="form-control" id="ID_PELANGGAN" name="ID_PELANGGAN" required>
                                <?php 
                                if ($result_pelanggan && $result_pelanggan->num_rows > 0) {
                                    mysqli_data_seek($result_pelanggan, 0); // Reset pointer
                                    while ($row_pelanggan = $result_pelanggan->fetch_assoc()) {
                                        $selected = ($row_pelanggan['ID_PELANGGAN'] == $data_lama['ID_PELANGGAN']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row_pelanggan['ID_PELANGGAN']) . "' $selected>" . htmlspecialchars($row_pelanggan['NAMA_PELANGGAN']) . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada pelanggan tersedia</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="ID_FNB">Kode F&B</label>
                            <select class="form-control" id="ID_FNB" name="ID_FNB" required>
                                <?php 
                                if ($result_fnb && $result_fnb->num_rows > 0) {
                                    mysqli_data_seek($result_fnb, 0); // Reset pointer
                                    while ($row_fnb = $result_fnb->fetch_assoc()) {
                                        $selected = ($row_fnb['ID_FNB'] == $data_lama['ID_FNB']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row_fnb['ID_FNB']) . "' $selected>" . htmlspecialchars($row_fnb['KODE_FNB']) . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada F&B tersedia</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="TGL_FNB">Tanggal F&B</label>
                            <input type="date" class="form-control" id="TGL_FNB" name="TGL_FNB" 
                                   value="<?php echo htmlspecialchars($data_lama['TGL_FNB']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="JAM_FNB">Jam F&B</label>
                            <input type="time" class="form-control" id="JAM_FNB" name="JAM_FNB" 
                                   value="<?php echo htmlspecialchars($data_lama['JAM_FNB']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="FOOD">Food</label>
                            <input type="text" class="form-control" id="FOOD" name="FOOD" 
                                   value="<?php echo htmlspecialchars($data_lama['FOOD']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="BEVERAGE">Beverage</label>
                            <input type="text" class="form-control" id="BEVERAGE" name="BEVERAGE" 
                                   value="<?php echo htmlspecialchars($data_lama['BEVERAGE']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="JUMLAH_FNB">Harga Satuan (Rp)</label>
                            <input type="number" class="form-control" id="JUMLAH_FNB" name="JUMLAH_FNB" 
                                   value="<?php echo htmlspecialchars($data_lama['JUMLAH_FNB']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="SUBTOTAL_FNB">Kuantitas Pesanan</label>
                            <input type="number" class="form-control" id="SUBTOTAL_FNB" name="SUBTOTAL_FNB" 
                                   value="<?php echo htmlspecialchars($data_lama['SUBTOTAL_FNB']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="TOTAL_FNB">Total (Rp)</label>
                            <input type="number" class="form-control" id="TOTAL_FNB" name="TOTAL_FNB" 
                                   value="<?php echo htmlspecialchars($data_lama['TOTAL_FNB']); ?>" required readonly>
                        </div>
                        

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Data</button>
                        <a href="data_food_beverage.php" class="btn btn-default">Batal</a>
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
    /**
     * Fungsi untuk menghitung TOTAL FNB secara otomatis.
     * TOTAL_FNB = Harga Satuan (dari field JUMLAH_FNB) * Kuantitas (dari field SUBTOTAL_FNB)
     */
    function hitungTotal() {
        // Ambil nilai Harga Satuan
        var hargaSatuan = parseFloat($('#JUMLAH_FNB').val()) || 0;
        
        // Ambil nilai Kuantitas Pesanan
        var kuantitas = parseFloat($('#SUBTOTAL_FNB').val()) || 0;
        
        // Hitung Total
        var total = hargaSatuan * kuantitas;
        
        // Isi nilai Total ke dalam field TOTAL_FNB
        $('#TOTAL_FNB').val(total.toFixed(0));
    }

    $(document).ready(function() {
        // Inisialisasi perhitungan saat halaman dimuat (untuk memastikan data lama sudah benar)
        hitungTotal(); 
        
        // Panggil fungsi hitungTotal setiap kali nilai dari dua input ini berubah
        $('#JUMLAN_FNB, #SUBTOTAL_FNB').on('input', hitungTotal);
    });
</script>
</body>
</html>