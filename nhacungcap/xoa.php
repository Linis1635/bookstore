<?php

include("../config/db.php");

$id = $_GET['id'];

$sql = "
DELETE FROM NHACUNGCAP
WHERE MaNCC='$id'
";

mysqli_query($conn, $sql);

header("Location: index.php");

?>