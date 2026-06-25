<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "SELECT * FROM NHANVIEN";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ NHÂN VIÊN
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Thêm nhân viên

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã NV</th>
<th>Tên NV</th>
<th>Năm sinh</th>
<th>SDT</th>
<th>Email</th>
<th>Địa chỉ</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaNV'] ?></td>

<td><?= $row['TenNV'] ?></td>

<td><?= date("d/m/Y", strtotime($row['NamSinh'])) ?></td>

<td><?= $row['SDT'] ?></td>

<td><?= $row['Email'] ?></td>

<td><?= $row['DiaChi'] ?></td>

<td>

<a href="sua.php?id=<?= $row['MaNV'] ?>"
class="btn btn-warning btn-sm">

Sửa

</a>

<a href="xoa.php?id=<?= $row['MaNV'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa nhân viên?')">

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