<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$getID = mysqli_query($conn, "
SELECT MAX(MaNV) AS max_id
FROM NHANVIEN
");

$data = mysqli_fetch_assoc($getID);

$max = $data['max_id'];

$num = (int) substr($max, 2);

$num++;

$newID = "NV" . str_pad($num, 2, "0", STR_PAD_LEFT);

if(isset($_POST['them'])){

    $manv = $newID;
    $tennv = $_POST['tennv'];
    $namsinh = $_POST['namsinh'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];

    $sql = "
    INSERT INTO NHANVIEN
    VALUES(
        '$manv',
        '$tennv',
        '$namsinh',
        '$sdt',
        '$email',
        '$diachi'
    )
    ";

    mysqli_query($conn, $sql);

    header("Location: index.php");
}

?>

<div class="content">

<h2 class="mb-4">
    THÊM NHÂN VIÊN
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
name="tennv"
class="form-control mb-3"
placeholder="Tên nhân viên">

<label>Năm sinh</label>

<input type="date"
name="namsinh"
class="form-control mb-3">

<input type="text"
name="sdt"
class="form-control mb-3"
placeholder="Số điện thoại">

<input type="email"
name="email"
class="form-control mb-3"
placeholder="Email">

<input type="text"
name="diachi"
class="form-control mb-3"
placeholder="Địa chỉ">

<button class="btn btn-success"
name="them">

Thêm

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>