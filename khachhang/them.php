<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$getID = mysqli_query($conn, "
SELECT MAX(MaKH) AS max_id
FROM KHACHHANG
");

$data = mysqli_fetch_assoc($getID);

$max = $data['max_id'];

$num = (int) substr($max, 2);

$num++;

$newID = "KH" . str_pad($num, 2, "0", STR_PAD_LEFT);

if(isset($_POST['them'])){

    $makh = $newID;
    $tenkh = $_POST['tenkh'];
    $namsinh = $_POST['namsinh'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $tienno = $_POST['tienno'];

    $sql = "
    INSERT INTO KHACHHANG
    VALUES(
        '$makh',
        '$tenkh',
        '$namsinh',
        '$sdt',
        '$email',
        '$diachi',
        '$tienno'
    )
    ";

    mysqli_query($conn, $sql);

    header("Location: index.php");
}

?>

<div class="content">

<h2 class="mb-4">
    THÊM KHÁCH HÀNG
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
name="tenkh"
class="form-control mb-3"
placeholder="Tên khách hàng">

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

<input type="hidden"
name="tienno"
value="0">

<button class="btn btn-success"
name="them">

Thêm

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>