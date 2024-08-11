<?php
//memanggil file pustaka fungsi
require "../connect_db.php";

//memindahkan data kiriman dari form ke var biasa
$id=$_GET["kode"];

//membuat query hapus data
$sql="delete from book_category where category_id=$id";
mysqli_query($koneksi,$sql);
header("location:../index.php?page=book-category");
?>