```php
<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

//LẤY THAM SỐ
$getThamSo = mysqli_query($conn, "
SELECT
    SoSachTonKhoToiThieu,
    SoSachNhapToiThieu,
    TiLeDonGiaBan
FROM THAMSO
LIMIT 1
");

$ts = mysqli_fetch_assoc($getThamSo);

$TON_TOI_THIEU =
(int) $ts['SoSachTonKhoToiThieu'];

$NHAP_TOI_THIEU =
(int) $ts['SoSachNhapToiThieu'];

$TI_LE_DON_GIA_BAN =
(float) $ts['TiLeDonGiaBan'];

//LẤY NHÀ CUNG CẤP, SÁCH, PHIẾU NHẬP MỚI NHẤT
$ncc = mysqli_query($conn, "
SELECT * FROM NHACUNGCAP
");

$sach = mysqli_query($conn, "
SELECT * FROM SACH
ORDER BY TenSach
");

$sql = "
SELECT MaPhieuNhap
FROM PHIEUNHAP
ORDER BY MaPhieuNhap DESC
LIMIT 1
";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    $lastID = $row['MaPhieuNhap'];

    $num = (int) substr($lastID, 2);

    $num++;

    $newID = "PN" . str_pad($num, 3, "0", STR_PAD_LEFT);

}else{

    $newID = "PN001";
}

//XỬ LÝ TẠO PHIẾU
if(isset($_POST['luu'])){

    $mapn = $newID;

    $ngaynhap = $_POST['ngaynhap'];

    $mancc = $_POST['mancc'];

    $masach = $_POST['masach'] ?? [];

    $dongia = $_POST['dongia'] ?? [];

    $soluong = $_POST['soluong'] ?? [];

    //THÊM PHIẾU NHẬP
    mysqli_query($conn, "
    INSERT INTO PHIEUNHAP
    VALUES(
        '$mapn',
        '$ngaynhap',
        '$mancc'
    )
    ");

    //THÊM CHI TIẾT
    for($i = 0; $i < count($masach); $i++){

        $ms = $masach[$i];

        $dg = (int)$dongia[$i];

        $sl = (int)$soluong[$i];

        if(empty($ms) || $dg <= 0 || $sl <= 0){

            continue;
        }
        //LẤY THÔNG TIN SÁCH
        $book = mysqli_query($conn, "
        SELECT *
        FROM SACH
        WHERE MaSach='$ms'
        ");

        $b = mysqli_fetch_assoc($book);

        $tonkho = $b['SoLuong'];
        //CHỈ NHẬP SÁCH CÓ TỒN < TON_TOI_THIEU
        if($tonkho >= $TON_TOI_THIEU){

            echo "
            <script>

            alert('Chỉ được nhập sách có tồn kho dưới " . $TON_TOI_THIEU . "');

            window.history.back();

            </script>
            ";

            exit();
        }

        //NHẬP ÍT NHẤT NHAP_TOI_THIEU
        if($sl < $NHAP_TOI_THIEU){

            echo "
            <script>

            alert('Số lượng nhập ít nhất là " . $NHAP_TOI_THIEU . "');

            window.history.back();

            </script>
            ";

            exit();
        }

        //KIỂM TRA SÁCH ĐÃ CÓ TRONG PHIẾU CHƯA
        $check = mysqli_query($conn, "
        SELECT *
        FROM CT_PHIEUNHAP
        WHERE MaPhieuNhap='$mapn'
        AND MaSach='$ms'
        ");

        if(mysqli_num_rows($check) > 0){

            mysqli_query($conn, "
            UPDATE CT_PHIEUNHAP
            SET
                SoLuongNhap = SoLuongNhap + $sl,
                DonGiaNhap = $dg
            WHERE MaPhieuNhap='$mapn'
            AND MaSach='$ms'
            ");

        }else{

            mysqli_query($conn, "
            INSERT INTO CT_PHIEUNHAP
            VALUES(
                '$mapn',
                '$ms',
                '$dg',
                '$sl'
            )
            ");
        }

        //CẬP NHẬT
        $donGiaBanMoi =
        round($dg * $TI_LE_DON_GIA_BAN / 100);

        mysqli_query($conn, "
        UPDATE SACH
        SET
            SoLuong = SoLuong + $sl,
            DonGiaBan = $donGiaBanMoi
        WHERE MaSach='$ms'
        ");
    }

    echo "
    <script>

    alert('Tạo phiếu nhập thành công');

    window.location='index.php';

    </script>
    ";
}

?>

<div class="content">

<h2 class="mb-4">
    TẠO PHIẾU NHẬP
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

<label>Mã phiếu</label>

<input
type="text"
class="form-control mb-3"
value="<?= $newID ?>"
readonly>

</div>

<div class="col-md-6">

<label>Ngày nhập</label>

<input
type="date"
name="ngaynhap"
class="form-control mb-3"
required>

</div>

</div>

<label>Nhà cung cấp</label>

<select
name="mancc"
class="form-control mb-4"
required>

<?php while($row = mysqli_fetch_assoc($ncc)){ ?>

<option value="<?= $row['MaNCC'] ?>">

<?= $row['TenNCC'] ?>

</option>

<?php } ?>

</select>

<h4 class="mb-3">
Danh sách sách nhập
</h4>

<table class="table table-bordered" id="tableSach">

<thead class="table-dark">

<tr>

<th width="45%">
Sách
</th>

<th width="20%">
Đơn giá nhập
</th>

<th width="20%">
Số lượng
</th>

<th width="15%">
</th>

</tr>

</thead>

<tbody>

<tr>

<td>

<select
name="masach[]"
class="form-control"
required>

<option value="">
-- Chọn sách --
</option>

<?php

mysqli_data_seek($sach, 0);

while($s = mysqli_fetch_assoc($sach)){ ?>

<option value="<?= $s['MaSach'] ?>">

<?= $s['TenSach'] ?>
(Tồn: <?= $s['SoLuong'] ?>)

</option>

<?php } ?>

</select>

</td>

<td>

<input
type="number"
name="dongia[]"
class="form-control"
required>

</td>

<td>

<input
type="number"
name="soluong[]"
class="form-control"
required>

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

<button
class="btn btn-success"
name="luu">

Lưu phiếu nhập

</button>

</div>

</div>

</form>

</div>

<script>

document.getElementById("themSach").onclick = function(){

    let table = document.querySelector("#tableSach tbody");

    let row = table.rows[0].cloneNode(true);

    row.querySelector("select").selectedIndex = 0;

    row.querySelector("input[name='dongia[]']").value = "";

    row.querySelector("input[name='soluong[]']").value = "";

    table.appendChild(row);
};


document.addEventListener("click", function(e){

    if(e.target.classList.contains("xoa")){

        let rows =
        document.querySelectorAll("#tableSach tbody tr");

        if(rows.length > 1){

            e.target.closest("tr").remove();
        }
    }
});

</script>

<?php
include("../layout/footer.php");
?>
```
