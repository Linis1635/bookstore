<?php

include("../config/db.php");

$id = $_GET['id'];

/*
XÓA CHI TIẾT KIỂM KHO TRƯỚC
*/

mysqli_query($conn, "
DELETE FROM CT_PHIEUKIEMKHO
WHERE MaPhieu='$id'
");

/*
XÓA PHIẾU KIỂM KHO
*/

mysqli_query($conn, "
DELETE FROM PHIEUKIEMKHO
WHERE MaPhieu='$id'
");

header("Location: index.php");

?>