<?php

include("../config/auth.php");
include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

//LẤY THAM SỐ
$getThamSo = mysqli_query($conn, "
SELECT
    SoLuongTonToiThieu,
    KiemTraTienThu
FROM THAMSO
LIMIT 1
");

$ts = mysqli_fetch_assoc($getThamSo);

//THAM SỐ HỆ THỐNG
$TON_TOI_THIEU =
(int) $ts['SoLuongTonToiThieu'];

$KIEM_TRA_TIEN_THU =
(int) $ts['KiemTraTienThu'];

//LẤY DANH SÁCH KHÁCH HÀNG
$kh = mysqli_query($conn, "
SELECT *
FROM KHACHHANG
ORDER BY TenKH
");

//QUERY SÁCH
$sach_query = "
SELECT *
FROM SACH
WHERE SoLuong > $TON_TOI_THIEU
ORDER BY TenSach
";

//TẠO MÃ HÓA ĐƠN
$getID = mysqli_query($conn, "

SELECT
MAX(CAST(SUBSTRING(MaHD, 3) AS UNSIGNED)) AS max_id

FROM HOADON

");

$data = mysqli_fetch_assoc($getID);

$num = (int) $data['max_id'];

$num++;

$newID = "HD" . str_pad($num, 3, "0", STR_PAD_LEFT);

//XỬ LÝ TẠO HÓA ĐƠN
if(isset($_POST['them'])){

    $mahd = $newID;

    $ngaylap = $_POST['ngaylap'];

    $makh = $_POST['makh'];

    $datra = 0;

    $tongtien = 0;

    
    //FIX NULL ARRAY
        $masach = isset($_POST['masach'])
    ? $_POST['masach']
    : [];

    $soluong = isset($_POST['soluong'])
    ? $_POST['soluong']
    : [];

    //CHECK CÓ SÁCH
    if(count($masach) == 0){

        echo "
        <script>

        alert('Vui lòng chọn ít nhất 1 sách');

        window.history.back();

        </script>
        ";

        exit();
    }

    //TÍNH TỔNG TIỀN
    for($i = 0; $i < count($masach); $i++){

        $ms = $masach[$i];

        $sl = (int) $soluong[$i];

        if($ms == "") continue;

        $getSach = mysqli_query($conn, "
        SELECT *
        FROM SACH
        WHERE MaSach='$ms'
        ");

        $s = mysqli_fetch_assoc($getSach);

        if(!$s) continue;

        //CHECK TỒN KHO
        if($sl > $s['SoLuong']){

            echo "
            <script>

            alert('Sách ".$s['TenSach']." không đủ tồn kho');

            window.history.back();

            </script>
            ";

            exit();
        }

        //CHECK TỒN SAU BÁN
        $tonSauBan =
        $s['SoLuong'] - $sl;

        if($tonSauBan < $TON_TOI_THIEU){

            echo "
            <script>

            alert(
            'Không thể bán sách ".$s['TenSach']." vì tồn kho sau bán nhỏ hơn mức tối thiểu (".$TON_TOI_THIEU.")'
            );

            window.history.back();

            </script>
            ";

            exit();
        }

        $thanhtien =
        $sl * $s['DonGiaBan'];

        $tongtien += $thanhtien;
    }

    //KIỂM TRA NỢ TỐI ĐA
    $getNoToiDa = mysqli_query($conn, "
    SELECT SoTienNoToiDa
    FROM THAMSO
    LIMIT 1
    ");

    $tsNo = mysqli_fetch_assoc($getNoToiDa);

    $NO_TOI_DA =
    (int) $tsNo['SoTienNoToiDa'];

    
    //LẤY KHÁCH HÀNG
    $getKH = mysqli_query($conn, "
    SELECT *
    FROM KHACHHANG
    WHERE MaKH='$makh'
    ");

    $khData = mysqli_fetch_assoc($getKH);

    //CÔNG NỢ PHÁT SINH
    $congno = $tongtien - $datra;

    //NỢ SAU KHI MUA
    $noMoi =
    $khData['TienNo'] + $congno;

    //CHECK NỢ TỐI ĐA
    if($noMoi > $NO_TOI_DA){

        echo "
        <script>

        alert(
        'Khách hàng vượt quá số tiền nợ tối đa ("
        .number_format($NO_TOI_DA).
        " VNĐ)'
        );

        window.history.back();

        </script>
        ";

        exit();
    }

    //INSERT HÓA ĐƠN
    $insertHD = mysqli_query($conn, "

    INSERT INTO HOADON(

        MaHD,
        NgayLapHD,
        MaKH,
        TongTien,
        DaTra

    )

    VALUES(

        '$mahd',
        '$ngaylap',
        '$makh',
        '$tongtien',
        '$datra'

    )

    ");

    if(!$insertHD){

        die(mysqli_error($conn));
    }

    //INSERT CHI TIẾT HÓA ĐƠN
    for($i = 0; $i < count($masach); $i++){

        $ms = $masach[$i];

        $sl = (int) $soluong[$i];

        if($ms == "") continue;

        $getSach = mysqli_query($conn, "
        SELECT *
        FROM SACH
        WHERE MaSach='$ms'
        ");

        $s = mysqli_fetch_assoc($getSach);

        if(!$s) continue;

        $thanhtien =
        $sl * $s['DonGiaBan'];

        //INSERT CHI TIẾT HÓA ĐƠN     
        mysqli_query($conn, "

        INSERT INTO CT_HOADON(

            MaHD,
            MaSach,
            SoLuongBan,
            ThanhTien

        )

        VALUES(

            '$mahd',
            '$ms',
            '$sl',
            '$thanhtien'

        )

        ");

        //TRỪ KHO
        mysqli_query($conn, "

        UPDATE SACH

        SET SoLuong = SoLuong - $sl

        WHERE MaSach='$ms'

        ");
    }

    //CẬP NHẬT CÔNG NỢ
    if($congno > 0){

        mysqli_query($conn, "

        UPDATE KHACHHANG

        SET TienNo = TienNo + $congno

        WHERE MaKH='$makh'

        ");
    }
}

?>

<div class="content">

<h2 class="mb-4">
TẠO HÓA ĐƠN
</h2>

<a href="index.php"
class="btn btn-secondary mb-3">

← Quay lại

</a>

<form method="POST">

<div class="card shadow">

<div class="card-body">

<div class="row">

<div class="col-md-6">

<label>Mã hóa đơn</label>

<input
type="text"
class="form-control mb-3"
value="<?= $newID ?>"
readonly>

</div>

<div class="col-md-6">

<label>Ngày lập</label>

<input
type="date"
name="ngaylap"
class="form-control mb-3"
required>

</div>

</div>

<label>Khách hàng</label>

<select
name="makh"
class="form-control mb-3"
required>

<?php while($row = mysqli_fetch_assoc($kh)){ ?>

<option value="<?= $row['MaKH'] ?>">

<?= $row['TenKH'] ?>
- <?= $row['SDT'] ?>

</option>

<?php } ?>

</select>

<h4 class="mb-3">
Danh sách sách
</h4>

<table class="table table-bordered"
id="tableSach">

<thead class="table-dark">

<tr>

<th width="45%">
Sách
</th>

<th width="20%">
Số lượng
</th>

<th width="25%">
Đơn giá
</th>

<th width="10%">
</th>

</tr>

</thead>

<tbody id="tbodySach">

<tr>

<td>

<select
name="masach[]"
class="form-control sach-select"
required>

<option value="">
-- Chọn sách --
</option>

<?php

$tempSach =
mysqli_query($conn, $sach_query);

while($s = mysqli_fetch_assoc($tempSach)){ ?>

<option
value="<?= $s['MaSach'] ?>"
data-gia="<?= $s['DonGiaBan'] ?>">

<?= $s['TenSach'] ?>
(Tồn: <?= $s['SoLuong'] ?>)

</option>

<?php } ?>

</select>

</td>

<td>

<input
type="number"
name="soluong[]"
class="form-control"
min="1"
value="1"
required>

</td>

<td>

<input
type="text"
class="form-control dongia"
readonly>

</td>

<td>

<button
type="button"
class="btn btn-danger xoa">

X

</button>

</td>

</tr>

</tbody>

</table>

<button
type="button"
class="btn btn-primary mb-4"
id="themSach">

+ Thêm sách

</button>

<br>

<div class="d-flex justify-content-between align-items-center mt-3">

    <button
    class="btn btn-success"
    name="them">

    Tạo hóa đơn

    </button>

    <h4 class="mb-0">

        Tổng tiền:
        <span id="tongTienHoaDon">
            0 VNĐ
        </span>

    </h4>

</div>

</div>

</div>

</form>

</div>

<script>

//THÊM DÒNG SÁCH
document
.getElementById("themSach")
.addEventListener("click", function(){

    let tbody =
    document.getElementById("tbodySach");

    let firstRow =
    tbody.querySelector("tr");

    let newRow =
    firstRow.cloneNode(true);

    newRow.querySelector(".sach-select")
    .selectedIndex = 0;

    newRow.querySelector(".dongia")
    .value = "";

    newRow.querySelector(
    "input[name='soluong[]']"
    ).value = 1;

    tbody.appendChild(newRow);

    capNhatTongHoaDon();
});

//HÀM TÍNH THÀNH TIỀN
function capNhatThanhTien(row){

    let select =
    row.querySelector(".sach-select");

    let option =
    select.options[select.selectedIndex];

    let gia =
    parseInt(option.getAttribute("data-gia")) || 0;

    let soluong =
    parseInt(
    row.querySelector("input[name='soluong[]']").value
    ) || 0;

    let thanhtien = gia * soluong;

    if(gia > 0){

        row.querySelector(".dongia").value =
        Number(thanhtien).toLocaleString('vi-VN')
        + " VNĐ";

    }else{

        row.querySelector(".dongia").value = "";
    }
    capNhatTongHoaDon();
}

//TÍNH TỔNG TIỀN HÓA ĐƠN
function capNhatTongHoaDon(){

    let tong = 0;

    document
    .querySelectorAll("#tbodySach tr")
    .forEach(function(row){

        let select =
        row.querySelector(".sach-select");

        let option =
        select.options[select.selectedIndex];

        let gia =
        parseInt(
        option.getAttribute("data-gia")
        ) || 0;

        let soluong =
        parseInt(
        row.querySelector(
        "input[name='soluong[]']"
        ).value
        ) || 0;

        tong += gia * soluong;
    });

    document.getElementById(
    "tongTienHoaDon"
    ).innerText =
    Number(tong).toLocaleString('vi-VN')
    + " VNĐ";
}

//ĐỔI SÁCH
document.addEventListener("change", function(e){

    if(e.target.classList.contains("sach-select")){

        let row =
        e.target.closest("tr");

        capNhatThanhTien(row);
    }
});

//ĐỔI SỐ LƯỢNG
document.addEventListener("input", function(e){

    if(e.target.name == "soluong[]"){

        let row =
        e.target.closest("tr");

        capNhatThanhTien(row);
    }
});

//XÓA DÒNG
document.addEventListener("click", function(e){

    if(e.target.classList.contains("xoa")){

        let rows =
        document.querySelectorAll("#tbodySach tr");

        if(rows.length > 1){

            e.target.closest("tr").remove();

            capNhatTongHoaDon();
        }
    }
});

capNhatTongHoaDon();

</script>

<?php
include("../layout/footer.php");
?>