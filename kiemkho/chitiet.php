<?php

include("../config/auth.php");
include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$id = $_GET['id'];

/*
LẤY THÔNG TIN PHIẾU
*/

$phieu = mysqli_query($conn, "
SELECT *
FROM PHIEUKIEMKHO
WHERE MaPhieu='$id'
");

$p = mysqli_fetch_assoc($phieu);

/*
LẤY CHI TIẾT KIỂM KHO
*/

$ct = mysqli_query($conn, "
SELECT
    CT_PHIEUKIEMKHO.*,
    SACH.TenSach,
    SACH.SoLuong

FROM CT_PHIEUKIEMKHO

JOIN SACH
ON CT_PHIEUKIEMKHO.MaSach = SACH.MaSach

WHERE MaPhieu='$id'
");

?>

<div class="content">

<h2 class="mb-4">
    CHI TIẾT PHIẾU KIỂM KHO
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<div class="card shadow mb-4">

<div class="card-body">

<div class="row">

<div class="col-md-6">

<p>

<b>Mã phiếu:</b>

<?= $p['MaPhieu'] ?>

</p>

</div>

<div class="col-md-6">

<p>

<b>Ngày lập:</b>

<?= date("d/m/Y", strtotime($p['NgayLap'])) ?>

</p>

</div>

</div>

</div>

</div>

<div class="card shadow">

<div class="card-body">

<h4 class="mb-3">
Danh sách kiểm kho
</h4>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Tên sách</th>
<th>Thực tế kiểm</th>
<th>Chênh lệch</th>
<th>Ghi chú</th>

</tr>

<?php while($row = mysqli_fetch_assoc($ct)){ ?>

<tr>

<td>

<?= $row['TenSach'] ?>

</td>



<td>

<?= $row['SoLuongThucTe'] ?>

</td>

<td>

<?php

if($row['ChenhLech'] > 0){

    echo "
    <span class='text-success fw-bold'>
        +".$row['ChenhLech']."
    </span>
    ";

}else if($row['ChenhLech'] < 0){

    echo "
    <span class='text-danger fw-bold'>
        ".$row['ChenhLech']."
    </span>
    ";

}else{

    echo "
    <span class='text-primary fw-bold'>
        0
    </span>
    ";
}

?>

</td>

<td>

<?= $row['GhiChu'] ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

<?php
include("../layout/footer.php");
?>