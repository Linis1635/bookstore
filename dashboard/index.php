<?php

session_start();

if(!isset($_SESSION['user'])){

    header("Location: ../auth/login.php");

    exit();
}

include("../config/db.php");

include("../layout/header.php");

include("../layout/sidebar.php");

//BỘ LỌC
$nam   = $_GET['nam'] ?? '';
$thang = $_GET['thang'] ?? '';

//DANH SÁCH NĂM CÓ HÓA ĐƠN
$listNam = mysqli_query($conn, "

SELECT DISTINCT
    YEAR(NgayLapHD) AS Nam

FROM HOADON

WHERE NgayLapHD IS NOT NULL

ORDER BY Nam DESC

");

//TỔNG HÓA ĐƠN
$sqlHD = "
SELECT COUNT(*) AS TongHD
FROM HOADON
";

$resultHD = mysqli_query($conn, $sqlHD);

$rowHD = mysqli_fetch_assoc($resultHD);

$tongHoaDon = $rowHD['TongHD'];

//TỔNG DOANH THU
$sqlDT = "
SELECT SUM(TongTien) AS TongDoanhThu
FROM HOADON
";

$resultDT = mysqli_query($conn, $sqlDT);

$rowDT = mysqli_fetch_assoc($resultDT);

$tongDoanhThu = $rowDT['TongDoanhThu'] ?? 0;

//TỔNG SÁCH BÁN
$sqlSach = "
SELECT SUM(SoLuongBan) AS TongSachBan
FROM CT_HOADON
";

$resultSach = mysqli_query($conn, $sqlSach);

$rowSach = mysqli_fetch_assoc($resultSach);

$tongSachBan = $rowSach['TongSachBan'] ?? 0;

//TỔNG PHIẾU THU
$sqlThu = "
SELECT SUM(SoTien) AS TongThu
FROM PHIEUTHU
";

$resultThu = mysqli_query($conn, $sqlThu);

$rowThu = mysqli_fetch_assoc($resultThu);

$tongThu = $rowThu['TongThu'] ?? 0;


$labels = [];
$data = [];

if($nam != '' && $thang != ''){

    $songay =
    cal_days_in_month(
        CAL_GREGORIAN,
        (int)$thang,
        (int)$nam
    );

    for($i=1;$i<=$songay;$i++){

        $labels[] = $i;

        $data[$i] = 0;
    }

    $sqlChart = "

    SELECT

        DAY(NgayLapHD) AS Ngay,
        SUM(TongTien) AS DoanhThu

    FROM HOADON

    WHERE YEAR(NgayLapHD)=".(int)$nam."

    AND MONTH(NgayLapHD)=".(int)$thang."

    GROUP BY DAY(NgayLapHD)

    ";

    $resultChart =
    mysqli_query($conn, $sqlChart);

    while($row = mysqli_fetch_assoc($resultChart)){

        $data[$row['Ngay']] =
        (int)$row['DoanhThu'];
    }

    $data = array_values($data);
}
elseif($nam != ''){

    for($i=1;$i<=12;$i++){

        $labels[] = "T".$i;

        $data[$i] = 0;
    }

    $sqlChart = "

    SELECT

        MONTH(NgayLapHD) AS Thang,
        SUM(TongTien) AS DoanhThu

    FROM HOADON

    WHERE YEAR(NgayLapHD)=".(int)$nam."

    GROUP BY MONTH(NgayLapHD)

    ";

    $resultChart =
    mysqli_query($conn, $sqlChart);

    while($row = mysqli_fetch_assoc($resultChart)){

        $data[$row['Thang']] =
        (int)$row['DoanhThu'];
    }

    $data = array_values($data);
}
else{

    $sqlChart = "

    SELECT

        YEAR(NgayLapHD) AS Nam,
        SUM(TongTien) AS DoanhThu

    FROM HOADON

    GROUP BY YEAR(NgayLapHD)

    ORDER BY YEAR(NgayLapHD)

    ";

    $resultChart =
    mysqli_query($conn, $sqlChart);

    while($row = mysqli_fetch_assoc($resultChart)){

        $labels[] = $row['Nam'];

        $data[] = $row['DoanhThu'];
    }
}

//TOP SÁCH BÁN CHẠY
$sqlTopSach = "

SELECT 
    s.TenSach,
    SUM(ct.SoLuongBan) AS TongBan

FROM CT_HOADON ct

JOIN SACH s
ON ct.MaSach = s.MaSach

GROUP BY ct.MaSach

ORDER BY TongBan DESC

LIMIT 5

";

$resultTopSach = mysqli_query($conn, $sqlTopSach);

?>

<div class="content">

<h2 class="mb-4">
    TRANG CHỦ
</h2>

<div class="row g-3 mb-4">

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-muted">
    Tổng hóa đơn
</h6>

<h2>
    <?= $tongHoaDon ?>
</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-muted">
    Tổng doanh thu
</h6>

<h4>
    <?= number_format($tongDoanhThu) ?> VNĐ
</h4>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-muted">
    Tổng sách bán
</h6>

<h2>
    <?= $tongSachBan ?>
</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-muted">
    Lợi nhuận tạm tính
</h6>

<h4>
    <?= number_format($tongThu) ?> VNĐ
</h4>

</div>

</div>

</div>

</div>

<form id="filterForm" method="GET" class="row mb-4">

<?php
//BỘ LỌC THEO THÁNG
?>
<div class="col-md-3">

<select
id="thang"
name="thang"
class="form-control"
<?= empty($nam) ? 'disabled' : '' ?>>

<?php if(empty($nam)){ ?>

<option value="">
Chọn năm trước
</option>

<?php }else{ ?>

<option value="">
Tất cả các tháng
</option>

<?php } ?>

<?php for($i=1;$i<=12;$i++){ ?>

<option
value="<?= $i ?>"
<?= ($thang == $i) ? 'selected' : '' ?>>

Tháng <?= $i ?>

</option>

<?php } ?>

</select>

</div>

<?php
//BỘ LỌC THEO NĂM
?>
<div class="col-md-3">

<select
id="nam"
name="nam"
class="form-control">

<option value="">
Tất cả các năm
</option>

<?php while($n = mysqli_fetch_assoc($listNam)){ ?>

<option
value="<?= $n['Nam'] ?>"
<?= ($nam == $n['Nam']) ? 'selected' : '' ?>>

Năm <?= $n['Nam'] ?>

</option>

<?php } ?>

</select>

</div>

</form>

<div class="row">

<div class="col-md-8 mb-4">

<div class="card shadow border-0">

<div class="card-body">

<h5 class="mb-4">

<?php if($nam != '' && $thang != ''){ ?>

    Doanh thu tháng
    <?= $thang ?>/<?= $nam ?>

<?php }elseif($nam != ''){ ?>

    Doanh thu năm
    <?= $nam ?>

<?php }else{ ?>

    Doanh thu theo năm

<?php } ?>

</h5>

<canvas id="revenueChart"></canvas>

</div>

</div>

</div>

<div class="col-md-4 mb-4">

<div class="card shadow border-0">

<div class="card-body">

<h5 class="mb-4">
    Top sách bán chạy
</h5>

<table class="table table-hover">

<tr class="table-dark">

<th>Tên sách</th>

<th>Đã bán</th>

</tr>

<?php while($top = mysqli_fetch_assoc($resultTopSach)){ ?>

<tr>

<td>
    <?= $top['TenSach'] ?>
</td>

<td>
    <?= $top['TongBan'] ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</div>

<div class="row">

<div class="col-md-6">

<div class="card shadow border-0">

<div class="card-body">

<h5>
    Tổng phiếu thu
</h5>

<h3>
    <?= number_format($tongThu) ?> VNĐ
</h3>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('revenueChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: <?= json_encode($labels) ?>,

        datasets: [{

            label: 'Doanh thu',

            data: <?= json_encode($data) ?>,

            borderWidth: 1

        }]
    },

    options: {

        responsive: true,

        scales: {

            y: {

                beginAtZero: true
            }
        }
    }
});

//
const form =
document.getElementById("filterForm");

const nam =
document.getElementById("nam");

const thang =
document.getElementById("thang");

//CHỌN NĂM
nam.addEventListener("change", function(){

    if(this.value === ""){

        thang.value = "";

        thang.disabled = true;

    }else{

        thang.disabled = false;
    }

    form.submit();
});

//CHỌN THÁNG
thang.addEventListener("change", function(){

    form.submit();
});

</script>

<?php
include("../layout/footer.php");
?>