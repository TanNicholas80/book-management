<?php
//memanggil file pustaka fungsi
require "../connect_db.php";

//memindahkan data kiriman dari form ke var biasa
$id=$_GET["kode"];

$sql_cover = "SELECT book_cover FROM book WHERE book_id=$id";
$result = mysqli_query($koneksi, $sql_cover);
$row = mysqli_fetch_assoc($result);

// Jika file cover ditemukan, hapus file tersebut
if ($row && $row["book_cover"]) {
    $file_path = "../cover_book/" . $row["book_cover"];
    if (file_exists($file_path)) {
        unlink($file_path); // Hapus file cover dari server
    }
}

//membuat query hapus data
$sql="delete from book where book_id=$id";
mysqli_query($koneksi,$sql);
header("location:../index.php?page=book");
?>