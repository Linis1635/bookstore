<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$id = $_GET['id'];

$sql = "
SELECT * FROM KHACHHANG
WHERE MaKH='$id'
";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['sua'])){

    $tenkh = $_POST['tenkh'];
    $namsinh = $_POST['namsinh'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];

    $update = "
    UPDATE KHACHHANG
    SET
        TenKH='$tenkh',
        NamSinh='$namsinh',
        SDT='$sdt',
        Email='$email',
        DiaChi='$diachi'
    WHERE MaKH='$id'
    ";

    mysqli_query($conn, $update);

    header("Location: index.php");
}

?>

<div class="content">

<h2 class="mb-4">
    SỬA KHÁCH HÀNG
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<form method="POST">

<label>Mã khách hàng</label>

<input
type="text"
class="form-control mb-3"
value="<?= $row['MaKH'] ?>"
readonly
disabled>

<input type="text"
value="<?= $row['TenKH'] ?>"
name="tenkh"
class="form-control mb-3">

<label>Năm sinh</label>

<input type="date"
value="<?= date('Y-m-d', strtotime($row['NamSinh'])) ?>"
name="namsinh"
class="form-control mb-3">

<label>Số điện thoại</label>
<input type="text"
value="<?= $row['SDT'] ?>"
name="sdt"
class="form-control mb-3">

<label>Email</label>
<input type="email"
value="<?= $row['Email'] ?>"
name="email"
class="form-control mb-3">

<label>Địa chỉ</label>
<input type="text"
value="<?= $row['DiaChi'] ?>"
name="diachi"
class="form-control mb-3">


<button class="btn btn-warning"
name="sua">

Cập nhật

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>