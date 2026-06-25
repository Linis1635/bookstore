<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$id = $_GET['id'];

$sql = "
SELECT * FROM NHACUNGCAP
WHERE MaNCC='$id'
";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['sua'])){

    $tenncc = $_POST['tenncc'];
    $diachi = $_POST['diachi'];

    $update = "
    UPDATE NHACUNGCAP
    SET
        TenNCC='$tenncc',
        DiaChi='$diachi'
    WHERE MaNCC='$id'
    ";

    mysqli_query($conn, $update);

    header("Location: index.php");
}

?>

<div class="content">

<h2 class="mb-4">
    SỬA NHÀ CUNG CẤP
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<form method="POST">

<label>Mã nhà cung cấp</label>

<input
type="text"
class="form-control mb-3"
value="<?= $row['MaNCC'] ?>"
readonly
disabled>

<label>Tên nhà cung cấp</label>

<input
type="text"
value="<?= $row['TenNCC'] ?>"
name="tenncc"
class="form-control mb-3"
required>

<label>Địa chỉ</label>

<input
type="text"
value="<?= $row['DiaChi'] ?>"
name="diachi"
class="form-control mb-3"
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