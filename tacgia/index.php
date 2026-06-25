<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$sql = "SELECT * FROM TACGIA";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

<h2 class="mb-4">
    QUẢN LÝ TÁC GIẢ
</h2>

<a href="them.php"
class="btn btn-primary mb-3">

    Thêm tác giả

</a>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Mã tác giả</th>
<th>Tên tác giả</th>
<th>Năm sinh</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= $row['MaTacGia'] ?></td>

<td><?= $row['TenTacGia'] ?></td>

<td>

<?= 
(
    !empty($row['NamSinh']) &&
    $row['NamSinh'] != '0000-00-00'
)
? date("d/m/Y", strtotime($row['NamSinh']))
: "Chưa cập nhật"
?>

</td>

<td>

<a href="sua.php?id=<?= $row['MaTacGia'] ?>"
class="btn btn-warning btn-sm">

Sửa

</a>

<a href="xoa.php?id=<?= $row['MaTacGia'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Xóa tác giả?')">

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