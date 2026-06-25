<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$id = $_GET['id'];

$sql = "
SELECT * FROM THELOAI
WHERE MaTheLoai='$id'
";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['sua'])){

    $tentheloai = $_POST['tentheloai'];

    $update = "
    UPDATE THELOAI
    SET
    TenTheLoai='$tentheloai'
    WHERE MaTheLoai='$id'
    ";

    mysqli_query($conn, $update);

    header("Location: index.php");
}

?>

<div class="content">

<h2 class="mb-4">
    SỬA THỂ LOẠI
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<form method="POST">

<label>Mã thể loại</label>

<input
type="text"
class="form-control mb-3"
value="<?= $row['MaTheLoai'] ?>"
disabled>

<label>Tên thể loại</label>

<input
type="text"
name="tentheloai"
class="form-control mb-3"
value="<?= $row['TenTheLoai'] ?>"
required>

<button
class="btn btn-warning"
name="sua">

Cập nhật

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>