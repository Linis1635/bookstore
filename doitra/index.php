<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "
SELECT
    PHIEUDOITRA.*,
    KHACHHANG.TenKH,
    KHACHHANG.SDT

FROM PHIEUDOITRA

JOIN KHACHHANG
ON PHIEUDOITRA.MaKH = KHACHHANG.MaKH

ORDER BY PHIEUDOITRA.NgayDoiTra DESC
";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ PHIẾU ĐỔI TRẢ
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Tạo phiếu đổi trả

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã phiếu</th>
<th>Ngày đổi trả</th>
<th>Khách hàng</th>
<th>Tổng SL</th>
<th>Ghi chú</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaPhieuDoiTra'] ?></td>

<td><?= date("d/m/Y", strtotime($row['NgayDoiTra'])) ?></td>

<td>
<?= $row['TenKH'] ?>
- <?= $row['SDT'] ?>
</td>

<td><?= $row['TongSoLuong'] ?></td>

<td><?= $row['GhiChu'] ?></td>

<td>

<a href="chitiet.php?id=<?= $row['MaPhieuDoiTra'] ?>"
class="btn btn-info btn-sm">

Chi tiết

</a>

<a href="xoa.php?id=<?= $row['MaPhieuDoiTra'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa phiếu đổi trả?')">

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