<?php
session_start();
include "../config/koneksi.php";
use PHPMailer\PHPMailer\PHPMailer;
$error =  NULL;
if ($_GET['aksi'] == "ver"){
    $email = $_POST['email'];

    if (strlen($email) < 3){
        $error = "<p>Error</p>";
    }else{
        $query = mysqli_query($koneksi, "SELECT max(Kode_User) as kodeTerakhir FROM account");
        $data = mysqli_fetch_array($query);
        $kodeTerakhir = $data['kodeTerakhir'];
        $urutan = (int) substr($kodeTerakhir, 3, 3);
        $urutan++;
    
        $huruf = "AP";
        $Anggota = $huruf . sprintf("%03s", $urutan);
        $vkey = md5(time().$email);
        $sql = "INSERT INTO account(Kode_User,email,vkey) VALUES ('" . $Anggota ."','" . $email . "','" .$vkey . "')" ;
        $sql .= mysqli_query($koneksi, $sql);
        if ($sql) {
             $service = mysqli_query($koneksi, "SELECT * FROM identitas ");
             $fact = mysqli_fetch_array($service);
             $usern = $fact['email_app'];
             $passpo = $fact['password_app'];
             $name = 'Verifikasi Email';
             $subject = 'Verifikasi Masuk ke link Ini';
             $body = "<a href='http://localhost:8012/val/user_logic/login.php'>    Verify Account </a><p>kode verifikasi adalah $vkey";
             require_once "../PHPMailer/PHPMailer.php";
             require_once "../PHPMailer/SMTP.php";
             require_once "../PHPMailer/Exception.php";
    
             $mail = new PHPMailer();

             $mail->isSMTP();
             $mail->Host = "smtp.gmail.com";
             $mail->SMTPAuth = true;
             $mail->Username = "$usern"; //email ganti disini
             $mail->Password = "$passpo"; //password gunakan yang app password
             $mail->Port = 465;
             $mail->SMTPSecure = "ssl";

    
             $mail->isHTML(true);
             $mail->setFrom($email, $name);
             $mail->addAddress("$email");
             $mail->Subject = ("$subject");
             $mail->Body = $body;
             if($mail->send()){
             $_SESSION['berhasil'] = "Check Email untuk lanjut";
             header("location: ../pendaftaran");
             }else{
                $_SESSION['gagal'] = "email error";
                
             }
        } else {
            $_SESSION['gagal'] = "Error proses verifikasi gagal";
            header("location: ../pendaftaran");
        }
    }
}
if($_GET['aksi'] == "log"){
    $email = htmlspecialchars($_POST['email']);
    $vkey = htmlspecialchars($_POST['verify_key']);

    $data = mysqli_query($koneksi, "SELECT * FROM account WHERE email = '$email' AND vkey = '$vkey'");
    $cek = mysqli_num_rows($data);

    if ($cek > 0 ){
        $row = mysqli_fetch_assoc($data);
        $_SESSION['id_user'] = $row['id_acc'];
        $id_user = $_SESSION['id_user'];
        
        $query = "UPDATE account SET verified = 1";
        $query .= "WHERE id_acc = $id_user";
        header("location: ../form.php");
    }else{
        $_SESSION['gagal_login'] = "Error proses verifikasi gagal";
        header("location: ../masuk");
    }

}if($_GET['aksi'] == "suratyudi"){
    $kode_yudisium = $_POST['kode_yudisium'];
    $nama_yudisium = $_POST['nama_yudisium'];
    $nrp_yudisium = $_POST['nrp_yudisium'];
    $email_yudisium = $_POST['email_yudisium'];
    $tanggal_pembuatan = date('d-m-Y');
    
    $sql = "INSERT INTO surat_yudisium(kode_yudisium,nama_yudisium,nrp_yudisium,email_yudisium,tanggal_pembuatan)
            VALUES('" . $kode_yudisium . "','" . $nama_yudisium . "','" . $nrp_yudisium . "','" . $email_yudisium . "','" . $tanggal_pembuatan . "')";
    $sql .= mysqli_query($koneksi, $sql);

    if ($sql) {
        $_SESSION['berhasil'] = "Form Berhasil Di Submit !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Form gagal Di Submit!";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}if($_GET['aksi'] == "suratcuti"){
    if (isset($_POST['kirim_do_cu'])) {
        $kode_cuti = $_POST['kode_cuti'];
        $nama_cuti = $_POST['nama_cuti'];
        $nrp_cuti = $_POST['nrp_cuti'];
        $email_cuti = $_POST['email_cuti'];
        $tanggal_cuti = date('d-m-Y');
        $filename = $_FILES['myfile']['name'];
        $destination = '../../databse/' . $filename;
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $file = $_FILES['myfile']['tmp_name'];
        $size = $_FILES['myfile']['size'];
        if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
            echo "You file extension must be .zip, .pdf or .docx";
        } elseif ($_FILES['myfile']['size'] > 20000000) { // file shouldn't be larger than 20Megabyte
            echo "File too large!";
        } else {
            // move the uploaded (temporary) file to the specified destination
            if (move_uploaded_file($file, $destination)) {
                $sql = "INSERT INTO surat_cuti(kode_cuti_do,nama_cuti_do,nrp_cuti_do,email_cuti_do,tanggal_cuti_do,detail_cuti_do)
                 VALUES ('" . $kode_cuti . "','" . $nama_cuti . "','" . $nrp_cuti . "','" . $email_cuti . "','" . $tanggal_cuti . "','" . $filename ."')";
                if (mysqli_query($koneksi, $sql)) {
                    $_SESSION['berhasil'] = "Form Berhasil Di Submit !";
                    header("location: " . $_SERVER['HTTP_REFERER']);
                }
            } else {
                $_SESSION['gagal'] = "Form gagal Di Submit!  Mailer Error: {$mail->ErrorInfo}";
                header("location: " . $_SERVER['HTTP_REFERER']);
            }
        }
        }
}