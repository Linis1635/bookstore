<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "
SELECT
    PHIEUCHI.*,
    NHANVIEN.TenNV

FROM PHIEUCHI

JOIN NHANVIEN
ON PHIEUCHI.MaNV = NHANVIEN.MaNV
";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ PHIẾU CHI
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Lập phiếu chi

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã phiếu chi</th>
<th>Ngày chi</th>
<th>Nhân viên</th>
<th>Số tiền</th>
<th>Nội dung</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaPhieuChi'] ?></td>

<td><?= date("d/m/Y", strtotime($row['NgayChi'])) ?></td>

<td><?= $row['TenNV'] ?></td>

<td><?= number_format($row['SoTien']) ?></td>

<td><?= $row['NoiDung'] ?></td>

<td>

<a href="xoa.php?id=<?= $row['MaPhieuChi'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa phiếu chi?')">

Xóa

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

<?php
include("../layout/footer.php");
?>