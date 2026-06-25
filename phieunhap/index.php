<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "
SELECT
    PHIEUNHAP.*,
    NHACUNGCAP.TenNCC

FROM PHIEUNHAP

JOIN NHACUNGCAP
ON PHIEUNHAP.MaNCC = NHACUNGCAP.MaNCC

ORDER BY PHIEUNHAP.MaPhieuNhap DESC
";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ PHIẾU NHẬP
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Tạo phiếu nhập

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã phiếu nhập</th>
<th>Ngày nhập</th>
<th>Nhà cung cấp</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaPhieuNhap'] ?></td>

<td><?= date("d/m/Y", strtotime($row['NgayNhap'])) ?></td>

<td><?= $row['TenNCC'] ?></td>

<td>

<a href="chitiet.php?id=<?= $row['MaPhieuNhap'] ?>"
class="btn btn-info btn-sm">

Chi tiết

<?php
// Tạm ẩn chức năng xóa phiếu nhập
/*
<a href="xoa.php?id=<?= $row['MaPhieuNhap'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa phiếu nhập?')">
Xóa
</a>
*/
?>

</td>

</tr>

<?php } ?>

</table>

</div>

<?php
include("../layout/footer.php");
?>