<?php
session_start(); // Mulai session
require "../connect_db.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = ($_POST['email']);
    $password = ($_POST['password']);
    $hashed_password = md5($password);

    // Validasi: Pastikan semua field diisi
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Semua field harus diisi.";
        header("location: ../login.php");
        exit;
    }

    // Validasi: Email sesuai format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid.";
        header("location: ../login.php");
        exit;
    }

    // Validasi: Password minimal (contoh: minimal 8 karakter)
    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password harus minimal 8 karakter.";
        header("location: ../login.php");
        exit;
    }

    // Cek kecocokan email dan password
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$hashed_password'";
    $hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
    
    if (mysqli_num_rows($hasil) > 0) {
        $user = mysqli_fetch_assoc($hasil);
        // Jika login berhasil
        $_SESSION['user_id'] = $user['user_id'];

        $_SESSION['success'] = "Login berhasil!";
        header("location: ../index.php?page=profil");
    } else {
        // Jika login gagal
        $_SESSION['error'] = "Email atau password salah. Coba lagi.";
        header("location: ../login.php");
    }
    exit;
}
?>