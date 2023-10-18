<?php
session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
    include "config/koneksi.php";

    $sql = mysqli_query($koneksi, "SELECT * FROM identitas");
    $row1 = mysqli_fetch_assoc($sql);
    ?>
    <title>Masuk | <?= $row1['nama_app']; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">
    <!-- Icon -->
    <link rel="icon" type="icon" href="assets/dist/img/logo_app.png">
    <!-- Custom -->
    <link rel="stylesheet" href="assets/dist/css/custom.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="assets/dist/css/toastr.min.css">
</head>

<body class="hold-transition login-page" style="font-family: 'Quicksand', sans-serif;">
    
<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                        <li class="active"><a href="#srtyd" data-toggle="tab">Form Surat Yudisium</a></li>
                        <li> <a href="#srtcut" data-toggle="tab">Form Surat Cuti / Mengundurkan Diri</a></li>    
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="srtyd">
                        <section id="new">
                        <form action="function/Process.php?aksi=suratyudi" method="POST">
                            <?php
                            include "config/koneksi.php";
                            $id = $_SESSION['id_user'];
                            $query_fullname = mysqli_query($koneksi, "SELECT * FROM account WHERE id_acc = '$id'");
                            $row1 = mysqli_fetch_array($query_fullname);
                            ?>
                            <input type="hidden" class="form-control" name="kode_yudisium" value="<?= $row1['Kode_User']; ?>">
                            <input type="hidden" class="form-control" name="email_yudisium" value="<?= $row1['email']; ?>">
                            <div class="form-group">
                             <label>Nama </label>
                             <input type="text" class="form-control" name="nama_yudisium">
                            </div>
                            <div class="form-group">
                             <label>NRP</label>
                             <input type="text" class="form-control" name="nrp_yudisium" >
                            </div>
                            <div class="form-group">
                             <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                            </div>
                        </form>
                            
                        </section>
                    </div>
                    <div class="tab-pane" id="srtcut">
                        <section id="new">
                         <form action="function/Process.php?aksi=suratcuti"method="POST" enctype="multipart/form-data">
                            <?php
                             $id = $_SESSION['id_user'];
                             $query_fullname = mysqli_query($koneksi, "SELECT * FROM account WHERE id_acc = '$id'");
                             $row1 = mysqli_fetch_array($query_fullname);
                             ?>
                             <input type="hidden" class="form-control" name="kode_cuti" value="B<?= $row1['Kode_User']; ?>">
                             <input type="hidden" class="form-control" name="email_cuti" value="<?= $row1['email']; ?>">
                             <div class="form-group">
                              <label>Nama Anggota</label>
                              <input type="text" class="form-control" name="nama_cuti">
                             </div>
                             <div class="form-group">
                              <label>NRP</label>
                              <input type="text" class="form-control" name="nrp_cuti">
                             </div>
                            <div class="form-group" >
                             <Label>Upload Bukti PDF </Label>
                             <input type="file" name="myfile"  accept=".pdf" title="Upload PDF">  
                            </div>
                            <div class="form-group">
                             <button type="submit" class="btn btn-primary btn-block" name="kirim_do_cu">Kirim</button>
                            </div>
                           
                         </form>   

                        </section>   
                    </div>

                </div>
               
                    
    </section>

    <!-- jQuery 3 -->
    <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- -->
    <script src="assets/json/lottie-player.js"></script>
    <!-- Fungsi mengarahkan kehalaman pendaftaran -->
    <script>
        function Register() {
            window.location.href = "pendaftaran";
        }
    </script>
    <!-- Fungsi mengarahkan kehalaman lupa password -->
    <script>
        function ForgotPassword() {
            window.location.href = "lupa-password";
        }
    </script>
    <!-- Sweet Alert -->
    <script src="assets/dist/js/sweetalert.min.js"></script>
    <!-- Pesan Masuk Dulu -->
    <script>
        <?php
        if (isset($_SESSION['masuk_dulu']) && $_SESSION['masuk_dulu'] <> '') {
            echo "swal({
                icon: 'error',
                title: 'Peringatan',
                text: '$_SESSION[masuk_dulu]',
                buttons: false,
                timer: 3000
              })";
        }
        $_SESSION['masuk_dulu'] = '';
        ?>
    </script>
    <!-- Pesan Pendaftaran -->
    <script>
        <?php
        if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] <> '') {
            echo "swal({
                icon: 'success',
                title: 'Berhasil',
                text: '$_SESSION[berhasil]',
                buttons: false,
                timer: 3000
              })";
        }
        $_SESSION['berhasil'] = '';
        ?>
    </script>
    <script>
        <?php
        if (isset($_SESSION['gagal']) && $_SESSION['gagal'] <> '') {
            echo "swal({
                icon: 'error',
                title: 'Peringatan',
                text: '$_SESSION[gagal]',
                buttons: false,
                timer: 3000
              })";
        }
        $_SESSION['gagal'] = '';
        ?>
    </script>
    <!-- -->
    <script>
        <?php
        if (isset($_SESSION['gagal_login']) && $_SESSION['gagal_login'] <> '') {
            echo "swal({
                icon: 'error',
                title: 'Peringatan',
                text: '$_SESSION[gagal_login]',
                buttons: false,
                timer: 3000
              })";
        }
        $_SESSION['gagal_login'] = '';
        ?>
    </script>
    <script>
        <?php
        if (isset($_SESSION['berhasil_keluar']) && $_SESSION['berhasil_keluar'] <> '') {
            echo "swal({
            icon: 'success',
            title: 'Berhasil',
            text: '$_SESSION[berhasil_keluar]',
            buttons: false,
            timer: 3000
        })";
        }
        $_SESSION['berhasil_keluar'] = '';
        ?>
    </script>
    <!-- Toastr -->
    <script src="assets/dist/js/toastr.min.js"></script>
    <!-- -->
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>
    <!-- -->
    <script>
        function validateForm() {
            if (document.forms["formLogin"]["username"].value == "") {
                toastr.error("Nama Pengguna harus diisi !!");
                document.forms["formLogin"]["username"].focus();
                return false;
            }
            if (document.forms["formLogin"]["password"].value == "") {
                toastr.error("Kata Sandi harus diisi !!");
                document.forms["formLogin"]["password"].focus();
                return false;
            }
        }
    </script>
</body>

</html>