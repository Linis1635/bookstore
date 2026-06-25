<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>BookStore Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{
    margin:0;
    background:#f4f6f9;
}

.topbar{

    height:60px;

    background:#343a40;

    color:white;

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:0 20px;

    position:fixed;

    top:0;
    left:0;
    right:0;

    z-index:1000;
}

.logo{

    font-size:22px;
    font-weight:bold;
}

.sidebar{

    width:250px;

    background:#212529;

    position:fixed;

    top:40px;
    left:0;
    bottom:0;

    padding-top:20px;

    overflow-y:auto;
}

.sidebar a{

    display:block;

    color:white;

    padding:12px 20px;

    text-decoration:none;
}

.sidebar a:hover{

    background:#495057;
}

.content{

    margin-left:250px;

    margin-top:60px;

    padding:20px;
}

</style>

</head>

<body>

<div class="topbar">

<div class="logo">
📚 QUẢN LÝ NHÀ SÁCH
</div>

<?php if(isset($_SESSION['user'])){ ?>

<div class="dropdown">

<button
class="btn btn-dark dropdown-toggle d-flex align-items-center"
type="button"
data-bs-toggle="dropdown">

<div
style="
width:40px;
height:40px;
border-radius:50%;
background:white;
color:#343a40;
display:flex;
align-items:center;
justify-content:center;
font-weight:bold;
margin-right:10px;
">

<i class="bi bi-person-fill"></i>

</div>

<div class="text-start">

<div>
<?= $_SESSION['user']['TenNV'] ?>
</div>

<small>
<?= $_SESSION['user']['TenNhomNguoiDung'] ?>
</small>

</div>

</button>

<ul class="dropdown-menu dropdown-menu-end">

<li>

<a class="dropdown-item"
href="/bookstore/profile.php">

Thông tin cá nhân

</a>

</li>

<li>

<hr class="dropdown-divider">

</li>

<li>

<a class="dropdown-item text-danger"
href="/bookstore/auth/logout.php">

Đăng xuất

</a>

</li>

</ul>

</div>

<?php } ?>

</div>