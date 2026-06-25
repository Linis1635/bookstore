<?php

include("config/auth.php");

include("config/db.php");

include("layout/header.php");

include("layout/sidebar.php");

$user = $_SESSION['user'];

?>

<div class="content d-flex justify-content-center align-items-center"
style="min-height:80vh;">

<div class="card shadow"
style="
width:550px;
border-radius:20px;
overflow:hidden;
">

<div class="bg-dark text-white text-center p-4">

<div
style="
width:100px;
height:100px;
border-radius:50%;
background:white;
color:black;
font-size:50px;
display:flex;
align-items:center;
justify-content:center;
margin:auto;
">

<i class="bi bi-person-fill"></i>

</div>

<h3 class="mt-3">
<?= $user['TenNV'] ?>
</h3>

<p>
<?= $user['TenNhomNguoiDung'] ?>
</p>

</div>

<div class="card-body p-4">

<table class="table">

<tr>

<th>Mã nhân viên</th>

<td>
<?= $user['MaNV'] ?>
</td>

</tr>

<tr>

<th>Số điện thoại</th>

<td>
<?= $user['SDT'] ?>
</td>

</tr>

<tr>

<th>Email</th>

<td>
<?= $user['Email'] ?>
</td>

</tr>

<tr>

<th>Địa chỉ</th>

<td>
<?= $user['DiaChi'] ?>
</td>

</tr>

<tr>

<th>Tên đăng nhập</th>

<td>
<?= $user['TenDangNhap'] ?>
</td>

</tr>

<tr>

<th>Nhóm người dùng</th>

<td>
<?= $user['TenNhomNguoiDung'] ?>
</td>

</tr>

</table>

<div class="text-center mt-4">

<a href="dashboard/index.php"
class="btn btn-primary">

Quay về Dashboard

</a>

</div>

</div>

</div>

</div>

<?php
include("layout/footer.php");
?>