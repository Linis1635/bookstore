<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

/*
====================================
KIỂM TRA ĐĂNG NHẬP
====================================
*/

if(!isset($_SESSION['user'])){

    echo "
    <div class='content'>
        <div class='alert alert-danger'>
            Bạn chưa đăng nhập
        </div>
    </div>
    ";

    include("../layout/footer.php");

    exit;
}

$user = $_SESSION['user'];

$maNguoiDung = $user['MaNguoiDung'];

$maNhom = $user['MaNhomNguoiDung'];

/*
====================================
KIỂM TRA PHÂN QUYỀN
====================================
*/

$getQuyen = mysqli_query($conn, "
SELECT *
FROM PHANQUYEN
WHERE MaNhomNguoiDung = '$maNhom'
AND MaChucNang = 'CN13'
");

if(!$getQuyen){

    die("Lỗi truy vấn PHANQUYEN: " . mysqli_error($conn));
}

if(mysqli_num_rows($getQuyen) <= 0){

    echo "
    <div class='content'>
        <div class='alert alert-danger'>
            Bạn không có quyền truy cập chức năng này
        </div>
    </div>
    ";

    include("../layout/footer.php");

    exit;
}

if(mysqli_num_rows($getQuyen) <= 0){

    echo "
    <div class='content'>
        <div class='alert alert-danger'>
            Bạn không có quyền truy cập chức năng này
        </div>
    </div>
    ";

    include("../layout/footer.php");

    exit;
}

/*
====================================
CẬP NHẬT THAM SỐ
====================================
*/

if(isset($_POST['capnhat'])){

    $SoSachTonKhoToiThieu = $_POST['SoSachTonKhoToiThieu'];

    $SoSachNhapToiThieu = $_POST['SoSachNhapToiThieu'];

    $TiLeDonGiaBan = $_POST['TiLeDonGiaBan'];

    $SoTienNoToiDa = $_POST['SoTienNoToiDa'];

    $SoLuongTonToiThieu = $_POST['SoLuongTonToiThieu'];

    $KiemTraTienThu = isset($_POST['KiemTraTienThu']) ? 1 : 0;

    $update = mysqli_query($conn, "
    UPDATE THAMSO
    SET
        SoSachTonKhoToiThieu = '$SoSachTonKhoToiThieu',
        SoSachNhapToiThieu = '$SoSachNhapToiThieu',
        TiLeDonGiaBan = '$TiLeDonGiaBan',
        SoTienNoToiDa = '$SoTienNoToiDa',
        SoLuongTonToiThieu = '$SoLuongTonToiThieu',
        KiemTraTienThu = '$KiemTraTienThu'
    ");

    if($update){

        echo "
        <div class='content'>
            <div class='alert alert-success'>
                Cập nhật tham số thành công
            </div>
        </div>
        ";

    }else{

        echo "
        <div class='content'>
            <div class='alert alert-danger'>
                Cập nhật thất bại:
                ".mysqli_error($conn)."
            </div>
        </div>
        ";
    }
}

/*
====================================
LẤY THÔNG TIN THAM SỐ
====================================
*/

$getThamSo = mysqli_query($conn, "
SELECT *
FROM THAMSO
LIMIT 1
");

if(!$getThamSo){

    die("Lỗi truy vấn THAMSO: " . mysqli_error($conn));
}

$ts = mysqli_fetch_assoc($getThamSo);

?>

<div class="content">

<h2 class="mb-4">
    THAY ĐỔI THAM SỐ
</h2>

<form method="POST">

<div class="card">

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">

<label>
    Số sách tồn kho tối thiểu
</label>

<input
type="number"
name="SoSachTonKhoToiThieu"
class="form-control"
value="<?= $ts['SoSachTonKhoToiThieu'] ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>
    Số sách nhập tối thiểu
</label>

<input
type="number"
name="SoSachNhapToiThieu"
class="form-control"
value="<?= $ts['SoSachNhapToiThieu'] ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>
    Tỉ lệ đơn giá bán (%)
</label>

<input
type="number"
name="TiLeDonGiaBan"
class="form-control"
value="<?= $ts['TiLeDonGiaBan'] ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>
    Số tiền nợ tối đa
</label>

<input
type="number"
name="SoTienNoToiDa"
class="form-control"
value="<?= $ts['SoTienNoToiDa'] ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>
    Số lượng tồn tối thiểu
</label>

<input
type="number"
name="SoLuongTonToiThieu"
class="form-control"
value="<?= $ts['SoLuongTonToiThieu'] ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="d-block">
    Kiểm tra tiền thu
</label>

<div class="form-check mt-2">

<input
type="checkbox"
name="KiemTraTienThu"
class="form-check-input"
id="kiemtra"
<?= $ts['KiemTraTienThu'] ? "checked" : "" ?>

>

<label
class="form-check-label"
for="kiemtra">

    Cho phép kiểm tra tiền thu

</label>

</div>

</div>

</div>

<button
type="submit"
name="capnhat"
class="btn btn-primary">

    Cập nhật tham số

</button>

</div>

</div>

</form>

</div>

<?php
include("../layout/footer.php");
?>