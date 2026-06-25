<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "SELECT * FROM NHACUNGCAP";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ NHÀ CUNG CẤP
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Thêm nhà cung cấp

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã NCC</th>
<th>Tên NCC</th>
<th>Địa chỉ</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaNCC'] ?></td>

<td><?= $row['TenNCC'] ?></td>

<td><?= $row['DiaChi'] ?></td>

<td>

<a href="sua.php?id=<?= $row['MaNCC'] ?>"
class="btn btn-warning btn-sm">

Sửa

</a>

<a href="xoa.php?id=<?= $row['MaNCC'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa nhà cung cấp?')">

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