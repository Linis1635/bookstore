<?php

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$id = $_GET['id'];

//LẤY THÔNG TIN SÁCH
$sach = mysqli_query($conn,"
SELECT *
FROM SACH
WHERE MaSach='$id'
");

$row = mysqli_fetch_assoc($sach);

if(!$row){

    die("Không tìm thấy sách");
}

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

//CẬP NHẬT SÁCH
if(isset($_POST['sua'])){

    $tensach = $_POST['tensach'];

    $matacgia = $_POST['matacgia'];

    $matheloai = $_POST['matheloai'];

    $update = mysqli_query($conn,"

    UPDATE SACH

    SET

        TenSach='$tensach',
        MaTacGia='$matacgia',
        MaTheLoai='$matheloai'

    WHERE MaSach='$id'

    ");

    if(!$update){

        die(mysqli_error($conn));
    }

    header("Location: index.php");
    exit();
}

?>

<div class="content">

<h2 class="mb-4">
    SỬA SÁCH
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<form method="POST">

<label>Mã sách</label>

<input
type="text"
class="form-control mb-3"
value="<?= $row['MaSach'] ?>"
disabled>

<label>Tên sách</label>

<input
type="text"
name="tensach"
class="form-control mb-3"
value="<?= $row['TenSach'] ?>"
required>

<label>Tác giả</label>

<select
name="matacgia"
class="form-control mb-3"
required>

<?php while($tg = mysqli_fetch_assoc($tacgia)){ ?>

<option
value="<?= $tg['MaTacGia'] ?>"
<?= $tg['MaTacGia'] == $row['MaTacGia'] ? 'selected' : '' ?>>

<?= $tg['TenTacGia'] ?>

</option>

<?php } ?>

</select>

<label>Thể loại</label>

<select
name="matheloai"
class="form-control mb-3"
required>

<?php while($tl = mysqli_fetch_assoc($theloai)){ ?>

<option
value="<?= $tl['MaTheLoai'] ?>"
<?= $tl['MaTheLoai'] == $row['MaTheLoai'] ? 'selected' : '' ?>>

<?= $tl['TenTheLoai'] ?>

</option>

<?php } ?>

</select>

<label>Số lượng tồn</label>

<input
type="number"
class="form-control mb-3"
value="<?= $row['SoLuong'] ?>"
disabled>

<label>Đơn giá bán</label>

<input
type="number"
class="form-control mb-3"
value="<?= $row['DonGiaBan'] ?>"
disabled>

<button
class="btn btn-primary"
name="sua">

Cập nhật

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>