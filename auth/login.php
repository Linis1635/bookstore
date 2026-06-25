<?php

session_start();

include("../config/db.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "

        SELECT nd.*, nv.*, nn.*

        FROM NGUOIDUNG nd

        JOIN NHANVIEN nv
        ON nd.MaNV = nv.MaNV

        JOIN NHOMNGUOIDUNG nn
        ON nd.MaNhomNguoiDung = nn.MaNhomNguoiDung

        WHERE nd.TenDangNhap='$username'
        AND nd.MatKhau='$password'

        ";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user'] = $user;

        header("Location: ../dashboard/index.php");
        exit();

    }else{

        echo "<script>alert('Sai tài khoản hoặc mật khẩu')</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Đăng nhập</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-5" style="max-width:500px;">

<h2 class="mb-4">ĐĂNG NHẬP HỆ THỐNG</h2>

<form method="POST">

<input type="text"
name="username"
class="form-control mb-3"
placeholder="Tên đăng nhập">

<input type="password"
name="password"
class="form-control mb-3"
placeholder="Mật khẩu">

<button class="btn btn-primary w-100"
name="login">

Đăng nhập

</button>

</form>

</div>

</body>
</html>