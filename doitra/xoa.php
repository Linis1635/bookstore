<?php

include("../config/db.php");

$id = $_GET['id'];

/*
LẤY CHI TIẾT
*/

$ct = mysqli_query($conn, "
SELECT *
FROM CT_PHIEUDOITRA
WHERE MaPhieuDoiTra='$id'
");

while($row = mysqli_fetch_assoc($ct)){

    $masach = $row['MaSach'];
    $soluong = $row['SoLuongDoiTra'];
    $hinhthuc = $row['HinhThucXuLy'];

    /*
    HOÀN KHO
    */

    if($hinhthuc == 'Đổi'){

        mysqli_query($conn, "
        UPDATE SACH
        SET SoLuong = SoLuong + $soluong
        WHERE MaSach='$masach'
        ");

    }else{

        mysqli_query($conn, "
        UPDATE SACH
        SET SoLuong = SoLuong - $soluong
        WHERE MaSach='$masach'
        ");
    }
}

/*
XÓA CHI TIẾT
*/

mysqli_query($conn, "
DELETE FROM CT_PHIEUDOITRA
WHERE MaPhieuDoiTra='$id'
");

/*
XÓA PHIẾU
*/

mysqli_query($conn, "
DELETE FROM PHIEUDOITRA
WHERE MaPhieuDoiTra='$id'
");

header("Location: index.php");

?>