<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "SELECT * FROM KHACHHANG";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ KHÁCH HÀNG
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Thêm khách hàng

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã KH</th>
<th>Tên KH</th>
<th>Năm sinh</th>
<th>SDT</th>
<th>Email</th>
<th>Địa chỉ</th>
<th>Tiền nợ</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaKH'] ?></td>

<td><?= $row['TenKH'] ?></td>

<td><?= date("d/m/Y", strtotime($row['NamSinh'])) ?></td>

<td><?= $row['SDT'] ?></td>

<td><?= $row['Email'] ?></td>

<td><?= $row['DiaChi'] ?></td>

<td><?= number_format($row['TienNo']) ?></td>

<td>

<a href="sua.php?id=<?= $row['MaKH'] ?>"
class="btn btn-warning btn-sm">

Sửa

</a>

<a href="xoa.php?id=<?= $row['MaKH'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa khách hàng?')">

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