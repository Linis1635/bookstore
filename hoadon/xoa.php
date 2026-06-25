<?php

include("../config/db.php");

$id = $_GET['id'];

//KIỂM TRA PHIẾU THU
$checkPT = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM PHIEUTHU
WHERE MaHD='$id'
");

$pt = mysqli_fetch_assoc($checkPT);

if($pt['total'] > 0){

    echo "
    <script>

    alert('Không thể xóa hóa đơn vì đã phát sinh phiếu thu');

    window.location='index.php';

    </script>
    ";

    exit();
}

//LẤY THÔNG TIN HÓA ĐƠN
$hd = mysqli_query($conn,"
SELECT *
FROM HOADON
WHERE MaHD='$id'
");

$hoadon = mysqli_fetch_assoc($hd);

if(!$hoadon){

    echo "
    <script>

    alert('Hóa đơn không tồn tại');

    window.location='index.php';

    </script>
    ";

    exit();
}

$makh = $hoadon['MaKH'];

$congno =
$hoadon['TongTien'] - $hoadon['DaTra'];

//HOÀN TRẢ TỒN KHO
$ct = mysqli_query($conn,"
SELECT *
FROM CT_HOADON
WHERE MaHD='$id'
");

while($row = mysqli_fetch_assoc($ct)){

    mysqli_query($conn,"
    UPDATE SACH
    SET SoLuong = SoLuong + ".$row['SoLuongBan']."
    WHERE MaSach='".$row['MaSach']."'
    ");
}

//CẬP NHẬT CÔNG NỢ
if($congno > 0){

    mysqli_query($conn,"
    UPDATE KHACHHANG
    SET TienNo = GREATEST(TienNo - $congno,0)
    WHERE MaKH='$makh'
    ");
}

//XÓA CHI TIẾT HÓA ĐƠN
mysqli_query($conn,"
DELETE FROM CT_HOADON
WHERE MaHD='$id'
");

//XÓA HÓA ĐƠN
mysqli_query($conn,"
DELETE FROM HOADON
WHERE MaHD='$id'
");

header("Location: index.php");
exit();

?>