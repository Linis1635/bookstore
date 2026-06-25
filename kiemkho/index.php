<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "
SELECT * FROM PHIEUKIEMKHO
";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ PHIẾU KIỂM KHO
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Tạo phiếu kiểm kho

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã phiếu</th>
<th>Ngày lập</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaPhieu'] ?></td>

<td><?= date("d/m/Y", strtotime($row['NgayLap'])) ?></td>

<td>

<a href="chitiet.php?id=<?= $row['MaPhieu'] ?>"
class="btn btn-info btn-sm">

Chi tiết

</a>

<a href="xoa.php?id=<?= $row['MaPhieu'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa phiếu kiểm kho?')">

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