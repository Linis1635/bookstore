<?php

include("../config/auth.php");
include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "

SELECT
    HOADON.*,
    KHACHHANG.TenKH,
    KHACHHANG.SDT

FROM HOADON

JOIN KHACHHANG
ON HOADON.MaKH = KHACHHANG.MaKH

ORDER BY MaHD DESC

";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>
QUẢN LÝ HÓA ĐƠN
</h2>

<a href="them.php"
class="btn btn-primary">

+ Tạo hóa đơn

</a>

</div>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th>Mã HD</th>
<th>Ngày lập</th>
<th>Khách hàng</th>
<th>Tổng tiền</th>
<th>Đã trả</th>
<th>Còn nợ</th>
<th>Trạng thái</th>
<th>Thao tác</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<?php
$conno = $row['TongTien'] - $row['DaTra'];
?>

<tr>

<td><?= $row['MaHD'] ?></td>

<td>
<?= date("d/m/Y", strtotime($row['NgayLapHD'])) ?>
</td>

<td>

<b><?= $row['TenKH'] ?></b>

<br>

<small class="text-muted">
<?= $row['SDT'] ?>
</small>

</td>

<td class="text-danger fw-bold">
<?= number_format($row['TongTien']) ?>
</td>

<td class="text-success fw-bold">
<?= number_format($row['DaTra']) ?>
</td>

<td class="text-primary fw-bold">
<?= number_format($conno) ?>
</td>

<td>

<?php if($conno <= 0){ ?>

<span class="badge bg-success">
Đã thanh toán
</span>

<?php }else{ ?>

<span class="badge bg-warning text-dark">
Còn nợ
</span>

<?php } ?>

</td>

<td>

<a href="chitiet.php?id=<?= $row['MaHD'] ?>"
class="btn btn-info btn-sm">

Chi tiết

</a>

<a href="xoa.php?id=<?= $row['MaHD'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa hóa đơn?')">

Xóa

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php
include("../layout/footer.php");
?>