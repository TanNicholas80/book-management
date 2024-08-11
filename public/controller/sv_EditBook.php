<?php 
require "../connect_db.php";

$id = mysqli_real_escape_string($koneksi, $_POST["id"]);
$title = mysqli_real_escape_string($koneksi, $_POST["title"]);
$author = mysqli_real_escape_string($koneksi, $_POST["author"]);
$publication_date = date("Y-m-d", strtotime($_POST["date"]));
$publisher = mysqli_real_escape_string($koneksi, $_POST["publisher"]);
$number_of_pages = mysqli_real_escape_string($koneksi, $_POST["pages"]);
$category_id = mysqli_real_escape_string($koneksi, $_POST["category"]);
$uploadOk = 1;

// Menangani file upload
$filefoto = null;
if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
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
            // File berhasil diunggah
        } else {
            echo "Maaf, file gagal diunggah.";
            $uploadOk = 0;
        }
    }
}

// Jika tidak ada file yang diunggah, gunakan nilai default dari database
if ($uploadOk == 0 || !$filefoto) {
    $result = mysqli_query($koneksi, "SELECT book_cover FROM book WHERE book_id='$id'");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $filefoto = $row['book_cover'];
    } else {
        echo "Error fetching data: " . mysqli_error($koneksi);
        exit();
    }
}

// Membuat query
$sql = "UPDATE book SET title='$title', book_cover='$filefoto', author='$author', publication_date='$publication_date', publisher='$publisher', number_of_pages='$number_of_pages', category_id='$category_id' WHERE book_id='$id'";

if (mysqli_query($koneksi, $sql)) {
    header("location:../index.php?page=book");
} else {
    echo "Data gagal tersimpan";
}
?>