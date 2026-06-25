<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "SELECT * FROM THELOAI";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ THỂ LOẠI
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Thêm thể loại

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã thể loại</th>
<th>Tên thể loại</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaTheLoai'] ?></td>

<td><?= $row['TenTheLoai'] ?></td>

<td>

<a href="sua.php?id=<?= $row['MaTheLoai'] ?>"
class="btn btn-warning btn-sm">

Sửa

</a>

<a href="xoa.php?id=<?= $row['MaTheLoai'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa thể loại?')">

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