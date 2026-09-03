<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


include "koneksi.php";
session_start();

function sendmail_verify($email, $verify_token){
    require __DIR__ . '/vendor/autoload.php';
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nylapens@gmail.com';
        $mail->Password   = 'zetgzaowceqvkups';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('nylapens@gmail.com', 'Hotel System');
        $mail->addAddress($email); // ← email tujuan dari user
        $mail->addReplyTo('no-reply@example.com', 'Information');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Email Anda';
        $mail->Body = "
            <h2>Terima kasih telah registrasi</h2>
            <p>Silakan klik link berikut untuk verifikasi akun Anda:</p>
            <a href='http://localhost/PemesananKamarHotel1/verify_email.php?token=$verify_token'>
                Klik untuk verifikasi
            </a>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 🔒 enkripsi password

    // Nilai default
    $status = "Aktif";
    $role   = "Pelanggan";
$verify_token = md5(rand()); 
    // Simpan ke tabel pelanggan
    $sql = "INSERT INTO pelanggan (NAMA_PELANGGAN, EMAIL, PASSWORD, STATUS_PELANGGAN, ROLE, verify_token, verify_status)
            VALUES ('$nama', '$email', '$password', '$status', '$role', '$verify_token', '0')";

    if ($koneksi->query($sql) === TRUE) {
      $_SESSION['NAMA_PELANGGAN'] = $nama; // $nama = dari form POST 'nama'
      sendmail_verify($email, $verify_token); {
       $_SESSION['status'] = "warning, Silahkan cek email!, <a href='verify_ulang.php'>Tidak terima email?</a>";
        header('location: login.php');
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index2.html"><b>Halaman Registrasi</b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Registrasi</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="nama" class="form-control" placeholder="Nama">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <?php
if(isset($_SESSION['log'])) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal,</strong> email sudah terdaftar !
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php
    session_unset();
}
?>

          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!--<div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Ulangi password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>-->
        <div class="row">
          <div class="col-8">
            <!--<div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>-->
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Registrasi</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!--<div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Masuk Dengan Google
        </a>
      </div>-->

      <a href="login.php" class="text-center">Sudah Mempunyai Akun?</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
