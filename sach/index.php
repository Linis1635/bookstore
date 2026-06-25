<?php

session_start();

include("../config/db.php");
include("../config/auth.php");
include("../config/permission.php");

include("../layout/header.php");
include("../layout/sidebar.php");

//KIỂM TRA QUYỀN

if(!checkPermission($conn, 'sach')){

    echo "

    <script>

    alert('Bạn không có quyền truy cập');

    location='../dashboard/index.php';

    </script>

    ";

    exit();
}

//TÌM KIẾM
$tukhoa = "";

$loai = "tatca";

$where = "1=1";

if(isset($_GET['tukhoa'])){

    $tukhoa = trim($_GET['tukhoa']);

    $loai = $_GET['loai'];

        //TRA CỨU TẤT CẢ
        if($loai == "tatca"){

        $where = "

        (
            SACH.MaSach LIKE '%$tukhoa%'

            OR SACH.TenSach LIKE '%$tukhoa%'

            OR TACGIA.TenTacGia LIKE '%$tukhoa%'

            OR THELOAI.TenTheLoai LIKE '%$tukhoa%'
        )

        ";

    }else{

        //TRA CỨU THEO FIELD
        $where = "

        $loai LIKE '%$tukhoa%'

        ";
    }
}

//QUERY DANH SÁCH SÁCH
$sql = "

SELECT

    SACH.*,

    THELOAI.TenTheLoai,

    TACGIA.TenTacGia

FROM SACH

JOIN THELOAI
ON SACH.MaTheLoai = THELOAI.MaTheLoai

JOIN TACGIA
ON SACH.MaTacGia = TACGIA.MaTacGia

WHERE $where

ORDER BY SACH.TenSach ASC

";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
QUẢN LÝ SÁCH
</h2>

<div class="d-flex gap-2 mb-3">

<a href="them.php"
class="btn btn-primary">

Thêm sách

</a>

</div>

<!-- FORM TRA CỨU -->

<form method="GET"
class="row mb-4">

<div class="col-md-5">

<input
type="text"
name="tukhoa"
class="form-control"
placeholder="Nhập từ khóa..."
value="<?= $tukhoa ?>">

</div>

<div class="col-md-3">

<select
name="loai"
class="form-control">

<option
value="tatca"
<?= $loai == "tatca" ? "selected" : "" ?>>

Tất cả

</option>

<option
value="SACH.MaSach"
<?= $loai == "SACH.MaSach" ? "selected" : "" ?>>

Mã sách

</option>

<option
value="SACH.TenSach"
<?= $loai == "SACH.TenSach" ? "selected" : "" ?>>

Tên sách

</option>

<option
value="TACGIA.TenTacGia"
<?= $loai == "TACGIA.TenTacGia" ? "selected" : "" ?>>

Tác giả

</option>

<option
value="THELOAI.TenTheLoai"
<?= $loai == "THELOAI.TenTheLoai" ? "selected" : "" ?>>

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

<div class="col-md-2">


</div>

</form>

<!--TABLE -->

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã sách</th>

<th>Tên sách</th>

<th>Thể loại</th>

<th>Tác giả</th>

<th>Số lượng</th>

<th>Đơn giá</th>

<th width="150">
Action
</th>

</tr>

<?php

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td>

<?= $row['MaSach'] ?>

</td>

<td>

<?= $row['TenSach'] ?>

</td>

<td>

<?= $row['TenTheLoai'] ?>

</td>

<td>

<?= $row['TenTacGia'] ?>

</td>

<td>

<?php

if($row['SoLuong'] <= 5){

    echo "
    <span class='text-danger fw-bold'>
        ".$row['SoLuong']."
    </span>
    ";

}else{

    echo $row['SoLuong'];
}

?>

</td>

<td>

<?= number_format($row['DonGiaBan']) ?> VNĐ

</td>

<td>

<a href="sua.php?id=<?= $row['MaSach'] ?>"
class="btn btn-warning btn-sm">

Sửa

</a>

<a href="xoa.php?id=<?= $row['MaSach'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa sách này?')">

Xóa

</a>

</td>

</tr>

<?php }

}else{

echo "

<tr>

<td colspan='7'
class='text-center text-danger'>

Không tìm thấy dữ liệu

</td>

</tr>

";
}

?>

</table>

</div>

<?php
include("../layout/footer.php");
?>