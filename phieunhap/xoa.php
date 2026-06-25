<?php

include("../config/db.php");

$id = $_GET['id'];

mysqli_query($conn, "
DELETE FROM CT_PHIEUNHAP
WHERE MaPhieuNhap='$id'
");

mysqli_query($conn, "
DELETE FROM PHIEUNHAP
WHERE MaPhieuNhap='$id'
");

header("Location: index.php");

?>