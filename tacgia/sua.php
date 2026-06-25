<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$id = $_GET['id'];

$sql = "
SELECT * FROM TACGIA
WHERE MaTacGia='$id'
";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['sua'])){

    $tentacgia = $_POST['tentacgia'];
    $namsinh = $_POST['namsinh'];

    $update = "
    UPDATE TACGIA
    SET
        TenTacGia='$tentacgia',
        NamSinh='$namsinh'
    WHERE MaTacGia='$id'
    ";

    mysqli_query($conn, $update);

    header("Location: index.php");
}

?>

<div class="content">

<h2 class="mb-4">
    SỬA TÁC GIẢ
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<form method="POST">

<label>Mã tác giả</label>

<input
type="text"
class="form-control mb-3"
value="<?= $row['MaTacGia'] ?>"
readonly
disabled>

<label>Tên tác giả</label>

<input
type="text"
value="<?= $row['TenTacGia'] ?>"
name="tentacgia"
class="form-control mb-3"
required>

<label>Năm sinh</label>

<input
type="date"
value="<?= !empty($row['NamSinh']) 
    ? date('Y-m-d', strtotime($row['NamSinh'])) 
    : '' ?>"
name="namsinh"
class="form-control mb-3">

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