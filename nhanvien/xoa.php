<?php

include("../config/db.php");

$id = $_GET['id'];

$sql = "
DELETE FROM NHANVIEN
WHERE MaNV='$id'
";

mysqli_query($conn, $sql);

header("Location: index.php");

?>