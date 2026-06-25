<?php

include_once(__DIR__ . "/../config/db.php");
include_once(__DIR__ . "/../config/permission.php");

?>

<div class="sidebar">

    <a href="/bookstore/dashboard/">
        <i class="bi bi-speedometer2"></i>
        Trang chủ
    </a>

    <?php if(checkPermission($conn, 'baocao')){ ?>
        <a href="/bookstore/baocao/">
        <i class="bi bi-table"></i>
        Báo cáo
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'sach')){ ?>
        <a href="/bookstore/sach/">
        <i class="bi bi-book"></i>
            Quản lý sách
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'theloai')){ ?>
        <a href="/bookstore/theloai/">
        <i class="bi bi-tags"></i>
            Thể loại
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'tacgia')){ ?>
        <a href="/bookstore/tacgia/">
        <i class="bi bi-pen"></i>
        Tác giả
        </a>
    <?php } ?>
    
    <?php if(checkPermission($conn, 'nhacungcap')){ ?>
        <a href="/bookstore/nhacungcap/">
        <i class="bi bi-building"></i>
        Nhà cung cấp
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'khachhang')){ ?>
        <a href="/bookstore/khachhang/">
        <i class="bi bi-people"></i>
        Khách hàng
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'nhanvien')){ ?>
        <a href="/bookstore/nhanvien/">
        <i class="bi bi-person-badge"></i>
        Nhân viên
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'hoadon')){ ?>
        <a href="/bookstore/hoadon/">
        <i class="bi bi-receipt"></i>
        Hóa đơn
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'phieunhap')){ ?>
        <a href="/bookstore/phieunhap/">
        <i class="bi bi-box-arrow-in-down"></i>
        Phiếu nhập
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'phieuthu')){ ?>
        <a href="/bookstore/phieuthu/">
        <i class="bi bi-cash"></i>
        Phiếu thu
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'doitra')){ ?>
        <a href="/bookstore/doitra/">
        <i class="bi bi-arrow-repeat"></i>
        Đổi trả
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'phanquyen')){ ?>
        <a href="/bookstore/phanquyen/">
        <i class="bi bi-shield-lock-fill"></i>
        Phân quyền
        </a>
    <?php } ?>

    <?php if(checkPermission($conn, 'thamso')){ ?>
        <a href="/bookstore/thamso/">
        <i class="bi bi-gear"></i>
        Tham số
        </a>
    <?php } ?>

    <a href="/bookstore/auth/logout.php">
        <i class="bi bi-box-arrow-right"></i>
        Đăng xuất
    </a>

</div>