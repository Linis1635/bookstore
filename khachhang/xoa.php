<?php

include("../config/db.php");

$id = $_GET['id'];

$sql = "
DELETE FROM KHACHHANG
WHERE MaKH='$id'
";

mysqli_query($conn, $sql);

header("Location: index.php");

?>