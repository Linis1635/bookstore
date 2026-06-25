<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

//LẤY DANH SÁCH TÁC GIẢ
$tacgia = mysqli_query($conn,"
SELECT *
FROM TACGIA
ORDER BY TenTacGia
");

//LẤY DANH SÁCH THỂ LOẠI
$theloai = mysqli_query($conn,"
SELECT *
FROM THELOAI
ORDER BY TenTheLoai
");

//TẠO MÃ SÁCH
$getID = mysqli_query($conn, "
SELECT MAX(CAST(SUBSTRING(MaSach,2) AS UNSIGNED)) AS max_id
FROM SACH
");

$data = mysqli_fetch_assoc($getID);

$num = (int)$data['max_id'];

$num++;

$newID = "S" . str_pad($num, 3, "0", STR_PAD_LEFT);

//THÊM SÁCH
if(isset($_POST['them'])){

    $masach = $newID;

    $tensach = $_POST['tensach'];

    $matacgia = $_POST['matacgia'];

    $matheloai = $_POST['matheloai'];

    $insert = mysqli_query($conn, "

    INSERT INTO SACH(

        MaSach,
        TenSach,
        MaTheLoai,
        MaTacGia,
        SoLuong,
        DonGiaBan

    )

    VALUES(

        '$masach',
        '$tensach',
        '$matheloai',
        '$matacgia',
        0,
        0

    )

    ");

    if(!$insert){

        die(mysqli_error($conn));
    }

    header("Location: index.php");

    exit();
}

?>

<div class="content">

<h2 class="mb-4">
THÊM SÁCH
</h2>

<a href="index.php"
class="btn btn-secondary mb-3">

← Quay lại

</a>

<form method="POST">

<label>Mã sách</label>

<input
type="text"
class="form-control mb-3"
value="<?= $newID ?>"
readonly>

<label>Tên sách</label>

<input
type="text"
name="tensach"
class="form-control mb-3"
placeholder="Tên sách"
required>

<label>Tác giả</label>

<select
name="matacgia"
class="form-control mb-3"
required>

<option value="">
-- Chọn tác giả --
</option>

<?php while($tg = mysqli_fetch_assoc($tacgia)){ ?>

<option value="<?= $tg['MaTacGia'] ?>">

<?= $tg['TenTacGia'] ?>

</option>

<?php } ?>

</select>

<label>Thể loại</label>

<select
name="matheloai"
class="form-control mb-3"
required>

<option value="">
-- Chọn thể loại --
</option>

<?php while($tl = mysqli_fetch_assoc($theloai)){ ?>

<option value="<?= $tl['MaTheLoai'] ?>">

<?= $tl['TenTheLoai'] ?>

</option>

<?php } ?>

</select>

<button
class="btn btn-success"
name="them">

Thêm sách

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>