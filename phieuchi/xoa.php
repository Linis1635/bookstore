<?php

include("../config/db.php");

$id = $_GET['id'];

mysqli_query($conn, "
DELETE FROM PHIEUCHI
WHERE MaPhieuChi='$id'
");

header("Location: index.php");

?>