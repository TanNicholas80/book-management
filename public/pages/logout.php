<?php
/* menghilangkan semua varibel yang telah dimasukkan */
session_unset();

/* mengakhiri session */
session_destroy();
header("location:../login.php");
exit;
?>