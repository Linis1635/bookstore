<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$getID = mysqli_query($conn, "
SELECT MAX(MaTacGia) AS max_id
FROM TACGIA
");

$data = mysqli_fetch_assoc($getID);

$max = $data['max_id'];

$num = (int) substr($max, 2);

$num++;

$newID = "TG" . str_pad($num, 2, "0", STR_PAD_LEFT);

if(isset($_POST['them'])){

    $matacgia = $newID;
    $tentacgia = $_POST['tentacgia'];
    $namsinh = $_POST['namsinh'];

    $sql = "
    INSERT INTO TACGIA
    VALUES(
        '$matacgia',
        '$tentacgia',
        '$namsinh'
    )
    ";

    mysqli_query($conn, $sql);

    header("Location: index.php");
}

?>

<div class="content">

<h2 class="mb-4">
    THÊM TÁC GIẢ
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<form method="POST">

<input type="text"
class="form-control mb-3"
value="<?= $newID ?>"
readonly>

<input type="text"
name="tentacgia"
class="form-control mb-3"
placeholder="Tên tác giả">

<label>Năm sinh</label>

<input type="date"
name="namsinh"
class="form-control mb-3">

<button class="btn btn-success"
name="them">

Thêm

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>