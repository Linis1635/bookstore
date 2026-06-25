<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$getID = mysqli_query($conn, "
SELECT MAX(MaTheLoai) AS max_id
FROM THELOAI
");

$data = mysqli_fetch_assoc($getID);

$max = $data['max_id'];

$num = (int) substr($max, 2);

$num++;

$newID = "TL" . str_pad($num, 2, "0", STR_PAD_LEFT);

if(isset($_POST['them'])){

    $matheloai = $newID;
    $tentheloai = $_POST['tentheloai'];

    $sql = "
    INSERT INTO THELOAI
    VALUES(
        '$matheloai',
        '$tentheloai'
    )
    ";

    mysqli_query($conn, $sql);

    header("Location: index.php");
}

?>

<div class="content">

<h2 class="mb-4">
    THÊM THỂ LOẠI
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<form method="POST">

<input
type="text"
class="form-control mb-3"
value="<?= $newID ?>"
readonly>

<input type="text"
name="tentheloai"
class="form-control mb-3"
placeholder="Tên thể loại">

<button class="btn btn-success"
name="them">

Thêm

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>