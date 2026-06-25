<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "
SELECT
    PHIEUTHU.*,
    KHACHHANG.TenKH,
    KHACHHANG.SDT,
    NHANVIEN.TenNV

FROM PHIEUTHU

JOIN KHACHHANG
ON PHIEUTHU.MaKH = KHACHHANG.MaKH

JOIN NHANVIEN
ON PHIEUTHU.MaNV = NHANVIEN.MaNV
";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ PHIẾU THU
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Lập phiếu thu

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã phiếu thu</th>
<th>Ngày thu</th>
<th>Khách hàng</th>
<th>Hóa đơn</th>
<th>Nhân viên</th>
<th>Số tiền</th>
<th>Nội dung</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaPhieuThu'] ?></td>

<td><?= date("d/m/Y", strtotime($row['NgayThu'])) ?></td>

<td>
<?= $row['TenKH'] ?>
- <?= $row['SDT'] ?>
</td>

<td><?= $row['MaHD'] ?></td>

<td><?= $row['TenNV'] ?></td>

<td><?= number_format($row['SoTien']) ?></td>

<td><?= $row['NoiDung'] ?></td>

</tr>

<?php } ?>

</table>

</div>

<?php
include("../layout/footer.php");
?>