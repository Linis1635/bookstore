<?php

include("../config/auth.php");
include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

//LẤY THAM SỐ
$getTS = mysqli_query($conn, "
SELECT KiemTraTienThu
FROM THAMSO
LIMIT 1
");

$ts = mysqli_fetch_assoc($getTS);

$KIEM_TRA_TIEN_THU =
(int) $ts['KiemTraTienThu'];

$kh = mysqli_query($conn, "
SELECT *
FROM KHACHHANG
WHERE TienNo > 0
ORDER BY TienNo DESC
");

$nv = mysqli_query($conn, "
SELECT *
FROM NHANVIEN
");

$makh_selected = isset($_GET['makh']) ? $_GET['makh'] : '';

if($makh_selected != ''){

    $hd = mysqli_query($conn, "
    SELECT
        HOADON.*,
        KHACHHANG.TenKH
    FROM HOADON
    JOIN KHACHHANG ON HOADON.MaKH = KHACHHANG.MaKH
    WHERE HOADON.MaKH = '$makh_selected'
    AND (HOADON.TongTien - HOADON.DaTra) > 0
    ");

} else {

    $hd = mysqli_query($conn, "
    SELECT HOADON.*, KHACHHANG.TenKH
    FROM HOADON
    JOIN KHACHHANG ON HOADON.MaKH = KHACHHANG.MaKH
    WHERE 1=0
    ");
}

$sql = "
SELECT MaPhieuThu
FROM PHIEUTHU
ORDER BY MaPhieuThu DESC
LIMIT 1
";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    $lastID = $row['MaPhieuThu'];

    $num = (int) substr($lastID, 2);

    $num++;

    $newID = "PT" . str_pad($num, 3, "0", STR_PAD_LEFT);

}else{

    $newID = "PT001";
}

if(isset($_POST['them'])){

    $mapt = $newID;

    $ngaythu = $_POST['ngaythu'];

    $makh = $_POST['makh'];

    $mahd = $_POST['mahd'];

    $manv = $_SESSION['user']['MaNV'];

    $sotien = (int) $_POST['sotien'];

    $noidung = $_POST['noidung'];

    // lấy thông tin hóa đơn
    $getHD = mysqli_query($conn, "
    SELECT *
    FROM HOADON
    WHERE MaHD='$mahd'
    ");

    $hoadon = mysqli_fetch_assoc($getHD);

    // kiểm tra hóa đơn tồn tại
    if(!$hoadon){

        echo "
        <script>
        alert('Không tìm thấy hóa đơn');
        window.location='them.php';
        </script>
        ";

        exit();
    }

    $conno = $hoadon['TongTien'] - $hoadon['DaTra'];

    // hóa đơn đã thanh toán đủ
    if($conno <= 0){

        echo "
        <script>
        alert('Hóa đơn đã thanh toán đủ');
        window.location='them.php';
        </script>
        ";

        exit();
    }

    //KIỂM TRA TIỀN THU
    if($KIEM_TRA_TIEN_THU == 1){

        if($sotien <= 0){

            echo "
            <script>

            alert('Số tiền thu phải lớn hơn 0');

            window.history.back();

            </script>
            ";

            exit();
        }

        if($sotien > $conno){

            echo "
            <script>

            alert(
            'Số tiền thu không được vượt quá số tiền khách còn nợ'
            );

            window.location='them.php';

            </script>
            ";

            exit();
        }
    }

    //SỐ TIỀN THỰC TẾ
    $sotien_thucte = $sotien;

    // thêm phiếu thu
    $insert = mysqli_query($conn, "

    INSERT INTO PHIEUTHU(

        MaPhieuThu,
        NgayThu,
        MaKH,
        MaHD,
        MaNV,
        SoTien,
        NoiDung

    )

    VALUES(

        '$mapt',
        '$ngaythu',
        '$makh',
        '$mahd',
        '$manv',
        '$sotien_thucte',
        '$noidung'

    )

    ");

    // debug lỗi sql
    if(!$insert){

        die("Lỗi thêm phiếu thu: " . mysqli_error($conn));
    }

    // cập nhật tiền nợ khách hàng
    $updateKH = mysqli_query($conn, "

    UPDATE KHACHHANG

    SET TienNo = TienNo - $sotien_thucte

    WHERE MaKH='$makh'

    ");

    if(!$updateKH){

        die("Lỗi cập nhật công nợ: " . mysqli_error($conn));
    }

    //Cập nhật đã trả cho hóa đơn
    $updateHD = mysqli_query($conn, "

    UPDATE HOADON

    SET DaTra = DaTra + $sotien_thucte

    WHERE MaHD='$mahd'

    ");

    if(!$updateHD){

        die("Lỗi cập nhật hóa đơn: " . mysqli_error($conn));
    }

    echo "
    <script>

    alert('Lập phiếu thu thành công');

    window.location='index.php';

    </script>
    ";
}

?>

<div class="content">

<h2 class="mb-4">
    LẬP PHIẾU THU
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Quay lại
</a>

<form method="POST">

<label>Mã phiếu thu</label>

<input
type="text"
class="form-control mb-3"
value="<?= $newID ?>"
readonly>

<label>Ngày thu</label>

<input
type="date"
name="ngaythu"
class="form-control mb-3"
required>

<label>Khách hàng</label>

<select
name="makh"
class="form-control mb-3"
onchange="location.href='them.php?makh=' + this.value"
required>

<option value="">- Chọn khách hàng -</option>

<?php while($row = mysqli_fetch_assoc($kh)){ ?>

<option value="<?= $row['MaKH'] ?>"
<?= ($row['MaKH'] == $makh_selected ? 'selected' : '') ?> >

<?= $row['TenKH'] ?>
- Nợ: <?= number_format($row['TienNo']) ?> VNĐ

</option>

<?php } ?>

</select>

<label>Hóa đơn</label>

<select
name="mahd"
class="form-control mb-3"
required>

<?php while($row = mysqli_fetch_assoc($hd)){ ?>

<option value="<?= $row['MaHD'] ?>">

<?= $row['MaHD'] ?>
- <?= $row['TenKH'] ?>
- Tổng: <?= number_format($row['TongTien']) ?>
- Đã trả: <?= number_format($row['DaTra']) ?>

</option>

<?php } ?>

</select>

<label>Nhân viên thu</label>

<input
type="text"
class="form-control mb-3"
value="<?= $_SESSION['user']['TenNV'] ?>"
readonly>

<label>Số tiền thu</label>

<input
type="number"
name="sotien"
class="form-control mb-3"
placeholder="Nhập số tiền thu"
required>

<label>Nội dung</label>

<input
type="text"
name="noidung"
class="form-control mb-3"
placeholder="Ví dụ: Thanh toán hóa đơn"
required>

<button
class="btn btn-success"
name="them">

Lập phiếu thu

</button>

</form>

</div>

<?php
include("../layout/footer.php");
?>