<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit();
}

include("../config/db.php");

//THỜI GIAN
$nam = date('Y');
$thang = date('m');

//HEADER CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=baocao_'.$thang.'_'.$nam.'.csv');

$output = fopen("php://output", "w");
fwrite($output, "\xEF\xBB\xBF");

//TỒN KHO
fputcsv($output, ["=== BÁO CÁO TỒN KHO ==="]);

fputcsv($output, ["Mã sách", "Tên sách", "Tồn đầu", "Phát sinh", "Tồn cuối"]);

$sqlTonKho = "
SELECT 
    s.MaSach,
    s.TenSach,

    IFNULL(nhap.Nhap,0) AS Nhap,
    IFNULL(ban.Ban,0) AS Ban,
    IFNULL(tra.Tra,0) AS Tra,

    (IFNULL(nhap.Nhap,0) - IFNULL(ban.Ban,0) + IFNULL(tra.Tra,0)) AS PhatSinh,

    (s.SoLuong - (IFNULL(nhap.Nhap,0) - IFNULL(ban.Ban,0) + IFNULL(tra.Tra,0))) AS TonDau,

    s.SoLuong AS TonCuoi

FROM SACH s

LEFT JOIN (
    SELECT MaSach, SUM(SoLuongNhap) AS Nhap
    FROM CT_PHIEUNHAP pn
    JOIN PHIEUNHAP p ON pn.MaPhieuNhap = p.MaPhieuNhap
    WHERE YEAR(p.NgayNhap) = $nam AND MONTH(p.NgayNhap) = $thang
    GROUP BY MaSach
) nhap ON s.MaSach = nhap.MaSach

LEFT JOIN (
    SELECT MaSach, SUM(SoLuongBan) AS Ban
    FROM CT_HOADON ct
    JOIN HOADON h ON ct.MaHD = h.MaHD
    WHERE YEAR(h.NgayLapHD) = $nam AND MONTH(h.NgayLapHD) = $thang
    GROUP BY MaSach
) ban ON s.MaSach = ban.MaSach

LEFT JOIN (
    SELECT MaSach,
           SUM(CASE WHEN HinhThucXuLy='Trả' THEN SoLuongDoiTra ELSE 0 END) AS Tra
    FROM CT_PHIEUDOITRA ct
    JOIN PHIEUDOITRA p ON ct.MaPhieuDoiTra = p.MaPhieuDoiTra
    WHERE YEAR(p.NgayDoiTra) = $nam AND MONTH(p.NgayDoiTra) = $thang
    GROUP BY MaSach
) tra ON s.MaSach = tra.MaSach
";

$rsTonKho = mysqli_query($conn, $sqlTonKho);

while($row = mysqli_fetch_assoc($rsTonKho)){
    fputcsv($output, [
        $row['MaSach'],
        $row['TenSach'],
        $row['TonDau'],
        $row['PhatSinh'],
        $row['TonCuoi']
    ]);
}

//DÒNG TRỐNG
fputcsv($output, []);
fputcsv($output, ["=== CÔNG NỢ KHÁCH HÀNG ==="]);

//CÔNG NỢ
fputcsv($output, ["Mã KH", "Tên KH", "Tổng mua", "Tổng thu", "Công nợ"]);

$sqlCongNo = "
SELECT 
    kh.MaKH,
    kh.TenKH,

    IFNULL(SUM(hd.TongTien),0) AS TongMua,
    IFNULL(SUM(pt.SoTien),0) AS TongThu,

    (IFNULL(SUM(hd.TongTien),0) - IFNULL(SUM(pt.SoTien),0)) AS CongNo

FROM KHACHHANG kh

LEFT JOIN HOADON hd ON kh.MaKH = hd.MaKH
LEFT JOIN PHIEUTHU pt ON kh.MaKH = pt.MaKH

GROUP BY kh.MaKH, kh.TenKH
ORDER BY CongNo DESC
";

$rsCongNo = mysqli_query($conn, $sqlCongNo);

while($row = mysqli_fetch_assoc($rsCongNo)){
    fputcsv($output, [
        $row['MaKH'],
        $row['TenKH'],
        $row['TongMua'],
        $row['TongThu'],
        $row['CongNo']
    ]);
}

fclose($output);
exit;