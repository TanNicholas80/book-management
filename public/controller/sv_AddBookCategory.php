<?php 
require "../connect_db.php";

$category_name=$_POST["category_name"];
$category_desc=$_POST["description"];
$category_status=$_POST["status"];
$uploadOk=1;
$cekNPP=mysqli_num_rows(mysqli_query($koneksi, "select category_name from book_category where category_name='$category_name'"));
if($cekNPP > 0) {
    echo '<script languange="javascript">
        alert("Category Name Sudah Terdaftar");
        window.location="../index.php?page=add-book-category";
        </script>';
        exit();
} else {
    $sql="insert book_category values('', '$category_name','$category_desc','$category_status')";
    mysqli_query($koneksi,$sql);
    header("location:../index.php?page=book-category");
} 
?>