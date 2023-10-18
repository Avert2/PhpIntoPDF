<?php
   session_start(); 
?>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
    include "config/koneksi.php";

    $sql = mysqli_query($koneksi, "SELECT * FROM identitas");
    $row1 = mysqli_fetch_assoc($sql);
    ?>
    <title>Pendaftaran | <?= $row1['nama_app']; ?></title>
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
    <link rel="icon" type="icon" href="assets/dist/img/logo_itenas.png">
    <!-- Custom -->
    <link rel="stylesheet" href="assets/dist/css/custom.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="assets/dist/css/toastr.min.css">

</head>

    <body class="hold-transition login-page" style="font-family: 'Quicksand', sans-serif;">
        <div class="login-box">
        <div class="login-logo">
            <a href="masuk"><b><?= $row1['nama_app']; ?></b></a>
        </div>
        <div class="login-box-body" style="border-radius: 10px;">
            <img src="assets/dist/img/logo_itenas.png" height="80px" width="80px" style="display: block; margin-left: auto; margin-right: auto; margin-top: -12px; margin-bottom: 5px;">
            <form name="formLogin" action="function/Process.php?aksi=ver" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="email" placeholder="email" id="email">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Verifikasi Email</button>
            </div>
    
        <p style="text-align: center; font-size: 13px;">Hak Cipta &copy; <?= date('Y'); ?> .<?= $row1['nama_app']; ?> by KP Team.</p>   
        
    
        <!-- jQuery 3 -->
    <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Fungsi mengarahkan kehalaman masuk -->
    <script>
        function Masuk() {
            window.location.href = "masuk";
        }
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
            if (document.forms["formLogin"]["email"].value == "") {
                toastr.error("Email Lengkap harus diisi !!");
                document.forms["formLogin"]["email"].focus()
                return false;
            }
            
        }
    </script>
<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="assets/dist/js/sweetalert.min.js"></script>
<script>
    <?php
    if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] <> '') {
        echo "swal({
            icon: 'success',
            title: 'Berhasil',
            text: '$_SESSION[berhasil]'
        })";
    }
    $_SESSION['berhasil'] = '';
    ?>
</script>
<!-- Pesan Gagal Edit -->
<script>
    <?php
    if (isset($_SESSION['gagal']) && $_SESSION['gagal'] <> '') {
        echo "swal({
                icon: 'error',
                title: 'Gagal',
                text: '$_SESSION[gagal]'
              })";
    }
    $_SESSION['gagal'] = '';
    ?>
</script>

    </body>


</html>