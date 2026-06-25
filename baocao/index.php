<?php

session_start();

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit();
}

include("../config/db.php");
include("../layout/header.php");
include("../layout/sidebar.php");

//THỜI ĐIỂM BÁO CÁO
$thang = isset($_GET['thang'])
    ? (int)$_GET['thang']
    : date('m');

$nam = isset($_GET['nam'])
    ? (int)$_GET['nam']
    : date('Y');

//TỒN KHO
$sqlTonKho = "

SELECT
    s.MaSach,
    s.TenSach,

    IFNULL(nhap.Nhap,0) AS Nhap,
    IFNULL(ban.Ban,0) AS Ban,
    IFNULL(tra.Tra,0) AS Tra,

    (
        IFNULL(nhap.Nhap,0)
        - IFNULL(ban.Ban,0)
        + IFNULL(tra.Tra,0)
    ) AS PhatSinh,

    IFNULL(td.TonDau,0) AS TonDau,

    (
        IFNULL(td.TonDau,0)
        +
        (
            IFNULL(nhap.Nhap,0)
            - IFNULL(ban.Ban,0)
            + IFNULL(tra.Tra,0)
        )
    ) AS TonCuoi

FROM SACH s

LEFT JOIN (

    SELECT

        s.MaSach,

        s.SoLuong

        -

        (
            IFNULL(nhap.NhapTruoc,0)
            - IFNULL(ban.BanTruoc,0)
            + IFNULL(tra.TraTruoc,0)
        )

        AS TonDau

    FROM SACH s

    LEFT JOIN (

        SELECT
            ct.MaSach,
            SUM(ct.SoLuongNhap) AS NhapTruoc

        FROM CT_PHIEUNHAP ct

        JOIN PHIEUNHAP p
        ON ct.MaPhieuNhap = p.MaPhieuNhap

        WHERE p.NgayNhap >= DATE('$nam-$thang-01')

        GROUP BY ct.MaSach

    ) nhap ON s.MaSach = nhap.MaSach

    LEFT JOIN (

        SELECT
            ct.MaSach,
            SUM(ct.SoLuongBan) AS BanTruoc

        FROM CT_HOADON ct

        JOIN HOADON h
        ON ct.MaHD = h.MaHD

        WHERE h.NgayLapHD >= DATE('$nam-$thang-01')

        GROUP BY ct.MaSach

    ) ban ON s.MaSach = ban.MaSach

    LEFT JOIN (

        SELECT
            ct.MaSach,

            SUM(
                CASE
                    WHEN ct.HinhThucXuLy='Trả'
                    THEN ct.SoLuongDoiTra
                    ELSE 0
                END
            ) AS TraTruoc

        FROM CT_PHIEUDOITRA ct

        JOIN PHIEUDOITRA p
        ON ct.MaPhieuDoiTra = p.MaPhieuDoiTra

        WHERE p.NgayDoiTra >= DATE('$nam-$thang-01')

        GROUP BY ct.MaSach

    ) tra ON s.MaSach = tra.MaSach

) td ON s.MaSach = td.MaSach


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

ORDER BY s.TenSach

";
$rsTonKho = mysqli_query($conn, $sqlTonKho);

//CÔNG NỢ KHÁCH HÀNG
$sqlCongNo = "

SELECT

    kh.MaKH,
    kh.TenKH,

    IFNULL(nd.NoDau,0) AS NoDau,

    (
        IFNULL(hd.HDTrongThang,0)
        -
        IFNULL(pt.ThuTrongThang,0)
    ) AS PhatSinh,

    (
        IFNULL(nd.NoDau,0)
        +
        (
            IFNULL(hd.HDTrongThang,0)
            -
            IFNULL(pt.ThuTrongThang,0)
        )
    ) AS NoCuoi

FROM KHACHHANG kh

LEFT JOIN (

    SELECT

        hd.MaKH,

        IFNULL(SUM(hd.TongTien),0)
        -
        IFNULL((
            SELECT SUM(pt.SoTien)
            FROM PHIEUTHU pt
            WHERE pt.MaKH = hd.MaKH
            AND pt.NgayThu < DATE('$nam-$thang-01')
        ),0)

        AS NoDau

    FROM HOADON hd

    WHERE hd.NgayLapHD < DATE('$nam-$thang-01')

    GROUP BY hd.MaKH

) nd ON kh.MaKH = nd.MaKH

LEFT JOIN (

    SELECT

        MaKH,
        SUM(TongTien) AS HDTrongThang

    FROM HOADON

    WHERE YEAR(NgayLapHD) = $nam
    AND MONTH(NgayLapHD) = $thang

    GROUP BY MaKH

) hd ON kh.MaKH = hd.MaKH

LEFT JOIN (

    SELECT

        MaKH,
        SUM(SoTien) AS ThuTrongThang

    FROM PHIEUTHU

    WHERE YEAR(NgayThu) = $nam
    AND MONTH(NgayThu) = $thang

    GROUP BY MaKH

) pt ON kh.MaKH = pt.MaKH

ORDER BY NoCuoi DESC

";

$rsCongNo = mysqli_query($conn, $sqlCongNo);

?>

<div class="content">

<h2 class="mb-4">
    BÁO CÁO THÁNG <?= $thang ?>/<?= $nam ?>
</h2>

<form method="GET" class="row mb-4">

<div class="col-md-2">

<input
type="number"
name="thang"
min="1"
max="12"
value="<?= $thang ?>"
class="form-control">

</div>

<div class="col-md-2">

<input
type="number"
name="nam"
value="<?= $nam ?>"
class="form-control">

</div>

<div class="col-md-2">

<button class="btn btn-primary">
    Xem báo cáo
</button>

</div>

</form>

<!-- EXPORT -->
<a href="export.php" class="btn btn-success mb-3">
    Xuất CSV
</a>

<ul class="nav nav-tabs mb-3" id="reportTab" role="tablist">

  <li class="nav-item" role="presentation">
    <button class="nav-link active"
            id="tonkho-tab"
            data-bs-toggle="tab"
            data-bs-target="#tonkho"
            type="button">
        Tồn kho
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button class="nav-link"
            id="congno-tab"
            data-bs-toggle="tab"
            data-bs-target="#congno"
            type="button">
        Công nợ
    </button>
  </li>

</ul>

<div class="tab-content">

<!-- TAB TỒN KHO -->
<div class="tab-pane fade show active" id="tonkho">

<div class="card shadow">
<div class="card-body">

<h5 class="mb-3">
Báo cáo tồn kho tháng <?= $thang ?>/<?= $nam ?>
</h5>

<table class="table table-bordered">
<tr class="table-dark">
    <th>Mã sách</th>
    <th>Tên sách</th>
    <th>Tồn đầu</th>
    <th>Phát sinh</th>
    <th>Tồn cuối</th>
</tr>

<?php while($row = mysqli_fetch_assoc($rsTonKho)){ ?>
<tr>
    <td><?= $row['MaSach'] ?></td>
    <td><?= $row['TenSach'] ?></td>
    <td><?= $row['TonDau'] ?></td>
    <td><?= $row['PhatSinh'] ?></td>
    <td><?= $row['TonCuoi'] ?></td>
</tr>
<?php } ?>

</table>

</div>
</div>

</div>

<!-- TAB CÔNG NỢ -->
<div class="tab-pane fade" id="congno">

<div class="card shadow">
<div class="card-body">

<h5 class="mb-3">Công nợ khách hàng</h5>

<table class="table table-bordered">
<tr class="table-dark">
    <th>Mã KH</th>
    <th>Tên khách</th>
    <th>Nợ đầu</th>
    <th>Phát sinh</th>
    <th>Nợ cuối</th>
</tr>

<?php while($row = mysqli_fetch_assoc($rsCongNo)){ ?>
<tr>
    <td><?= $row['MaKH'] ?></td>
    <td><?= $row['TenKH'] ?></td>
    <td><?= number_format($row['NoDau']) ?></td>
    <td><?= number_format($row['PhatSinh']) ?></td>
    <td><?= number_format($row['NoCuoi']) ?></td>
</tr>
<?php } ?>

</table>

</div>
</div>

</div>

</div>

</div>

<?php include("../layout/footer.php"); ?>