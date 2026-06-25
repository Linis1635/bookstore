<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$tukhoa = "";
$loai = "tatca";

$result = null;

if(isset($_GET['tukhoa'])){

    $tukhoa = trim($_GET['tukhoa']);

    $loai = $_GET['loai'];

    $where = "";

    /*
    TRA CỨU TẤT CẢ
    */

    if($loai == "tatca"){

        $where = "
        s.MaSach LIKE '%$tukhoa%'
        OR s.TenSach LIKE '%$tukhoa%'
        OR tg.TenTacGia LIKE '%$tukhoa%'
        OR tl.TenTheLoai LIKE '%$tukhoa%'
        ";

    }else{

        /*
        TRA CỨU THEO ĐIỀU KIỆN
        */

        $where = "
        $loai LIKE '%$tukhoa%'
        ";
    }

    $sql = "
    SELECT 
        s.MaSach,
        s.TenSach,
        tg.TenTacGia,
        tl.TenTheLoai,
        s.SoLuong

    FROM SACH s

    JOIN TACGIA tg 
    ON s.MaTacGia = tg.MaTacGia

    JOIN THELOAI tl 
    ON s.MaTheLoai = tl.MaTheLoai

    WHERE $where
    ";

    $result = mysqli_query($conn, $sql);
}

?>

<div class="content">

<h2 class="mb-4">
    TRA CỨU SÁCH
</h2>

<form method="GET" class="row mb-4">

<div class="col-md-5">

<input 
type="text"
name="tukhoa"
class="form-control"
placeholder="Nhập từ khóa..."
value="<?= $tukhoa ?>"
required>

</div>

<div class="col-md-3">

<select name="loai" class="form-control">

<option 
value="tatca"
<?= $loai == "tatca" ? "selected" : "" ?>>

    Tất cả

</option>

<option 
value="s.MaSach"
<?= $loai == "s.MaSach" ? "selected" : "" ?>>

    Mã sách

</option>

<option 
value="s.TenSach"
<?= $loai == "s.TenSach" ? "selected" : "" ?>>

    Tên sách

</option>

<option 
value="tg.TenTacGia"
<?= $loai == "tg.TenTacGia" ? "selected" : "" ?>>

    Tác giả

</option>

<option 
value="tl.TenTheLoai"
<?= $loai == "tl.TenTheLoai" ? "selected" : "" ?>>

    Thể loại

</option>

</select>

</div>

<div class="col-md-2">

<button 
type="submit"
class="btn btn-primary w-100">

Tra cứu

</button>

</div>

</form>

<?php if($result){ ?>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã sách</th>
<th>Tên sách</th>
<th>Tác giả</th>
<th>Thể loại</th>
<th>Số lượng</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaSach'] ?></td>

<td><?= $row['TenSach'] ?></td>

<td><?= $row['TenTacGia'] ?></td>

<td><?= $row['TenTheLoai'] ?></td>

<td><?= $row['SoLuong'] ?></td>

</tr>

<?php } ?>

</table>

<?php } ?>

</div>

<?php
include("../layout/footer.php");
?>