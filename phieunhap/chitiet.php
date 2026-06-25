```php
<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$id = $_GET['id'];

$phieunhap = mysqli_query($conn, "
SELECT
    PHIEUNHAP.*,
    NHACUNGCAP.TenNCC

FROM PHIEUNHAP

JOIN NHACUNGCAP
ON PHIEUNHAP.MaNCC = NHACUNGCAP.MaNCC

WHERE PHIEUNHAP.MaPhieuNhap='$id'
");

$pn = mysqli_fetch_assoc($phieunhap);

$ct = mysqli_query($conn, "
SELECT
    CT_PHIEUNHAP.*,
    SACH.TenSach

FROM CT_PHIEUNHAP

JOIN SACH
ON CT_PHIEUNHAP.MaSach = SACH.MaSach

WHERE MaPhieuNhap='$id'
");

?>

<div class="content">

<h2 class="mb-4">
    CHI TIẾT PHIẾU NHẬP
</h2>

<a href="index.php"
class="btn btn-secondary mb-3">

← Quay lại

</a>

<div class="card mb-4 shadow-sm">

<div class="card-body">

<div class="row">

<div class="col-md-4">

<p>
<b>Mã phiếu:</b><br>
<?= $pn['MaPhieuNhap'] ?>
</p>

</div>

<div class="col-md-4">

<p>
<b>Nhà cung cấp:</b><br>
<?= $pn['TenNCC'] ?>
</p>

</div>

<div class="col-md-4">

<p>
<b>Ngày nhập:</b><br>
<?= date("d/m/Y", strtotime($pn['NgayNhap'])) ?>
</p>

</div>

</div>

</div>

</div>

<h4 class="mb-3">
    Danh sách sách nhập
</h4>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã sách</th>
<th>Tên sách</th>
<th>Đơn giá nhập</th>
<th>Số lượng nhập</th>
<th>Thành tiền</th>

</tr>

<?php

$tong = 0;

while($row = mysqli_fetch_assoc($ct)){

    $thanhtien =
    $row['DonGiaNhap']
    * $row['SoLuongNhap'];

    $tong += $thanhtien;

?>

<tr>

<td><?= $row['MaSach'] ?></td>

<td><?= $row['TenSach'] ?></td>

<td><?= number_format($row['DonGiaNhap']) ?></td>

<td><?= $row['SoLuongNhap'] ?></td>

<td><?= number_format($thanhtien) ?></td>

</tr>

<?php } ?>

<tr>

<th colspan="4" class="text-end">
    Tổng tiền
</th>

<th>
    <?= number_format($tong) ?>
</th>

</tr>

</table>

</div>

<?php
include("../layout/footer.php");
?>
```
