<?php

include("../config/auth.php");
include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$id = $_GET['id'];

$hd = mysqli_query($conn,"
SELECT
    HOADON.*,
    KHACHHANG.TenKH

FROM HOADON

JOIN KHACHHANG
ON HOADON.MaKH = KHACHHANG.MaKH

WHERE MaHD='$id'
");

$hoadon = mysqli_fetch_assoc($hd);

$ct = mysqli_query($conn,"
SELECT
    CT_HOADON.*,
    SACH.TenSach

FROM CT_HOADON

JOIN SACH
ON CT_HOADON.MaSach = SACH.MaSach

WHERE MaHD='$id'
");

?>

<div class="content">

<h2 class="mb-4">
CHI TIẾT HÓA ĐƠN
</h2>

<div class="card shadow mb-4">

<div class="card-body">

<p>
<b>Mã hóa đơn:</b>
<?= $hoadon['MaHD'] ?>
</p>

<p>
<b>Khách hàng:</b>
<?= $hoadon['TenKH'] ?>
</p>

<p>
<b>Tổng tiền:</b>
<?= number_format($hoadon['TongTien']) ?> VNĐ
</p>

<p>
<b>Đã trả:</b>
<?= number_format($hoadon['DaTra']) ?> VNĐ
</p>

<p>
<b>Còn nợ:</b>

<?= number_format(
$hoadon['TongTien'] - $hoadon['DaTra']
) ?>

VNĐ

</p>

</div>

</div>

<table class="table table-bordered">

<tr class="table-dark">

<th>Tên sách</th>
<th>Số lượng</th>
<th>Thành tiền</th>

</tr>

<?php while($row = mysqli_fetch_assoc($ct)){ ?>

<tr>

<td><?= $row['TenSach'] ?></td>

<td><?= $row['SoLuongBan'] ?></td>

<td>
<?= number_format($row['ThanhTien']) ?> VNĐ
</td>

</tr>

<?php } ?>

</table>

<a href="index.php"
class="btn btn-secondary">

← Quay lại

</a>

</div>

<?php
include("../layout/footer.php");
?>