<?php

include("../config/db.php");

$id = $_GET['id'];

mysqli_query($conn, "
DELETE FROM SACH
WHERE MaSach='$id'
");

header("Location: index.php");

?>