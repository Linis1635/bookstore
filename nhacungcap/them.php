<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

//TẠO MÃ NHÀ CUNG CẤP
$getID = mysqli_query($conn, "
SELECT MAX(MaNCC) AS max_id
FROM NHACUNGCAP
");

$data = mysqli_fetch_assoc($getID);

$max = $data['max_id'];

if($max){

    $num = (int) substr($max, 2);

}else{

    $num = 0;
}

$num++;

$newID = "NC" . str_pad($num, 2, "0", STR_PAD_LEFT);

//THÊM NHÀ CUNG CẤP
if(isset($_POST['them'])){

    $mancc = $newID;

    $tenncc = trim($_POST['tenncc']);

    $diachi = trim($_POST['diachi']);

    $sql = "

    INSERT INTO NHACUNGCAP(

        MaNCC,
        TenNCC,
        DiaChi

    )

    VALUES(

        '$mancc',
        '$tenncc',
        '$diachi'

    )

    ";

    $result = mysqli_query($conn, $sql);

    if(!$result){

        die(mysqli_error($conn));
    }

    header("Location: index.php");

    exit();
}

?>

<div class="content">

<h2 class="mb-4">
    THÊM NHÀ CUNG CẤP
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<form method="POST">

<label>Mã nhà cung cấp</label>

<input
type="text"
class="form-control mb-3"
value="<?= $newID ?>"
readonly
disabled>

<label>Tên nhà cung cấp</label>

<input
type="text"
name="tenncc"
class="form-control mb-3"
placeholder="Nhập tên nhà cung cấp"
required>

<label>Địa chỉ</label>

<input
type="text"
name="diachi"
class="form-control mb-3"
placeholder="Nhập địa chỉ"
required>

<button
class="btn btn-success"
name="them">

Thêm nhà cung cấp

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>