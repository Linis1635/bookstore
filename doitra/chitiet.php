<?php

include("../config/auth.php");
include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$id = $_GET['id'];

/*
THÔNG TIN PHIẾU
*/

$phieu = mysqli_query($conn, "
SELECT
    PHIEUDOITRA.*,
    KHACHHANG.TenKH,
    KHACHHANG.SDT

FROM PHIEUDOITRA

JOIN KHACHHANG
ON PHIEUDOITRA.MaKH = KHACHHANG.MaKH

WHERE MaPhieuDoiTra='$id'
");

$p = mysqli_fetch_assoc($phieu);

/*
CHI TIẾT
*/

$ct = mysqli_query($conn, "
SELECT
    CT_PHIEUDOITRA.*,
    SACH.TenSach

FROM CT_PHIEUDOITRA

JOIN SACH
ON CT_PHIEUDOITRA.MaSach = SACH.MaSach

WHERE MaPhieuDoiTra='$id'
");

?>

<div class="content">

<h2 class="mb-4">
    CHI TIẾT PHIẾU ĐỔI TRẢ
</h2>

<a href="index.php"
class="btn btn-secondary mb-3">

← Quay lại

</a>

<div class="card shadow mb-4">

<div class="card-body">

<div class="row">

<div class="col-md-6">

<p>
<b>Mã phiếu:</b>
<?= $p['MaPhieuDoiTra'] ?>
</p>

<p>
<b>Khách hàng:</b>
<?= $p['TenKH'] ?>
- <?= $p['SDT'] ?>
</p>

</div>

<div class="col-md-6">

<p>
<b>Ngày đổi trả:</b>
<?= date("d/m/Y", strtotime($p['NgayDoiTra'])) ?>
</p>

<p>
<b>Tổng số lượng:</b>
<?= $p['TongSoLuong'] ?>
</p>

</div>

</div>

<p>
<b>Ghi chú:</b>
<?= $p['GhiChu'] ?>
</p>

</div>

</div>

<div class="card shadow">

<div class="card-body">

<h4 class="mb-3">
Danh sách sách đổi/trả
</h4>

<table class="table table-bordered table-hover">

<tr class="table-dark">

<th>Sách</th>
<th>Số lượng</th>
<th>Hình thức</th>
<th>Lý do</th>

</tr>

<?php while($row = mysqli_fetch_assoc($ct)){ ?>

<tr>

<td><?= $row['TenSach'] ?></td>

<td><?= $row['SoLuongDoiTra'] ?></td>

<td>

<?php

if($row['HinhThucXuLy'] == 'Đổi'){

    echo "
    <span class='badge bg-warning'>
        Đổi
    </span>
    ";

}else{

    echo "
    <span class='badge bg-success'>
        Trả
    </span>
    ";
}

?>

</td>

<td><?= $row['LyDoDoiTra'] ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

<?php
include("../layout/footer.php");
?>
