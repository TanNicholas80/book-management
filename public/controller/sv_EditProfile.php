<?php 
require "../connect_db.php";

$id = mysqli_real_escape_string($koneksi, $_POST["id"]);
$name = mysqli_real_escape_string($koneksi, $_POST["name"]);
$email = mysqli_real_escape_string($koneksi, $_POST["email"]);
$address = mysqli_real_escape_string($koneksi, $_POST["address"]);
$phone = mysqli_real_escape_string($koneksi, $_POST["phone"]);
$uploadOk = 1;

// Menangani file upload
$filefoto = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $folderupload = $_SERVER['DOCUMENT_ROOT'] . "/internship/public/foto_user/";
    if (!file_exists($folderupload)) {
        mkdir($folderupload, 0777, true);
    }

    $fileupload = $folderupload . basename($_FILES['photo']['name']);
    $filefoto = basename($_FILES['photo']['name']);

    // Ambil jenis file
    $jenisfilefoto = strtolower(pathinfo($fileupload, PATHINFO_EXTENSION));

    // Check ukuran file
    if ($_FILES["photo"]["size"] > 10000000) {
        echo "Maaf, ukuran file foto harus kurang dari 10 MB<br>";
        $uploadOk = 0;
    }

    // Hanya file tertentu yang dapat digunakan
    if ($jenisfilefoto != "jpg" && $jenisfilefoto != "png" && $jenisfilefoto != "jpeg" && $jenisfilefoto != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan<br>";
        $uploadOk = 0;
    }

    // Check jika terjadi kesalahan
    if ($uploadOk == 0) {
        echo "Maaf, file tidak dapat terupload<br>";
    } else {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $fileupload)) {
            // File berhasil diunggah
        } else {
            echo "Maaf, file gagal diunggah.";
            $uploadOk = 0;
        }
    }
}

// Jika tidak ada file yang diunggah, gunakan nilai default dari database
if ($uploadOk == 0 || !$filefoto) {
    $result = mysqli_query($koneksi, "SELECT photo_user FROM user WHERE user_id='$id'");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $filefoto = $row['photo_user'];
    } else {
        echo "Error fetching data: " . mysqli_error($koneksi);
        exit();
    }
}

// Membuat query
$sql = "UPDATE user SET name='$name', email='$email', address='$address', phone='$phone', photo_user='$filefoto' WHERE user_id='$id'";

if (mysqli_query($koneksi, $sql)) {
    header("location:../index.php?page=edit-profile");
} else {
    echo "Data gagal tersimpan";
}
?>