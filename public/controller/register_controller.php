<?php
session_start(); // Mulai session

require "../connect_db.php";
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validasi
if (empty($name) || empty($email) || empty($password)) {
    $_SESSION['error'] = "Semua field harus diisi.";
    header("location:../register.php");
    exit;
}

// Validasi: Cek apakah email sudah terdaftar
$sql_check_email = "SELECT * FROM user WHERE email='$email'";
$result_check_email = mysqli_query($koneksi, $sql_check_email);

if (mysqli_num_rows($result_check_email) > 0) {
    $_SESSION['error'] = "Email sudah terdaftar. Gunakan email lain.";
    header("location:../register.php");
    exit;
}

// Validasi password
if (strlen($password) < 8) {
    $_SESSION['error'] = "Password harus minimal 8 karakter.";
    header("location:../register.php");
    exit;
}

$password_encrypt = md5($password);

// Insert data ke database
$sql = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', '$password_encrypt')";
$hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

if (mysqli_affected_rows($koneksi) > 0) {
    $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
    header("location:../login.php");
} else {
    $_SESSION['error'] = "Maaf, registrasi gagal. Ulangi registrasi.";
    header("location:../register.php");
}
exit;
?>