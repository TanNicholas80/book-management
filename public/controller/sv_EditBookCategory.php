<?php
//memanggil file pustaka fungsi
require "../connect_db.php";

//memindahkan data kiriman dari form ke var biasa
$id = $_POST["id"];
$category_desc = $_POST["description"];
$category_status = $_POST["status"];
$uploadOk = 1;

//membuat query
$sql = "update book_category set category_desc='$category_desc',
					 category_status='$category_status'
					 where category_id='$id'";
mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
header("location:../index.php?page=book-category");
