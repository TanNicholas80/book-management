<?php 
require "../connect_db.php";

$title = $_POST["title"];
$author = $_POST["author"];
$publication_date = date("Y-m-d", strtotime($_POST["date"]));;
$publisher = $_POST["publisher"];
$number_of_pages = $_POST["pages"];
$category_id = $_POST["category"];
$uploadOk = 1;

$folderupload = $_SERVER['DOCUMENT_ROOT'] . "/internship/public/cover_book/";
if (!file_exists($folderupload)) {
    mkdir($folderupload, 0777, true);
}

$fileupload = $folderupload . basename($_FILES['cover']['name']);
$filefoto = basename($_FILES['cover']['name']);

// Ambil jenis file
$jenisfilefoto = strtolower(pathinfo($fileupload, PATHINFO_EXTENSION));

// Check ukuran file
if ($_FILES["cover"]["size"] > 10000000) {
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
    if (move_uploaded_file($_FILES["cover"]["tmp_name"], $fileupload)) {
        // Membuat query
        $sql = "INSERT INTO book VALUES('', '$title', '$filefoto', '$author', '$publication_date', '$publisher', '$number_of_pages', '$category_id')";
        if (mysqli_query($koneksi, $sql)) {
            header("location:../index.php?page=book");
        } else {
            echo "Data gagal tersimpan";
        }
    } else {
        echo "Maaf, file gagal diunggah.";
    }
}
?>