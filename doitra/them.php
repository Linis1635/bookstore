<?php

include("../config/auth.php");
include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$SO_NGAY_DOI_TRA = 7;

$makh_filter = $_GET['makh'] ?? '';

//KHÁCH HÀNG
$kh = mysqli_query($conn, "
SELECT *
FROM KHACHHANG
ORDER BY TenKH
");

//SÁCH KHÁCH ĐÃ MUA

if(!empty($makh_filter)){

    $sach_query = "

    SELECT
        s.MaSach,
        s.TenSach,
        s.SoLuong,

        SUM(ct.SoLuongBan) AS DaMua

    FROM SACH s

    JOIN CT_HOADON ct
    ON s.MaSach = ct.MaSach

    JOIN HOADON hd
    ON ct.MaHD = hd.MaHD

    WHERE hd.MaKH='$makh_filter'

    GROUP BY
        s.MaSach,
        s.TenSach,
        s.SoLuong

    ORDER BY s.TenSach

    ";

}else{

    $sach_query = "

    SELECT *
    FROM SACH
    WHERE 1=0

    ";
}

//TẠO MÃ PHIẾU
$getID = mysqli_query($conn, "

SELECT
MAX(CAST(SUBSTRING(MaPhieuDoiTra, 3) AS UNSIGNED)) AS max_id

FROM PHIEUDOITRA

");

$data = mysqli_fetch_assoc($getID);

$num = (int) $data['max_id'];

$num++;

$newID = "DT" . str_pad($num, 3, "0", STR_PAD_LEFT);

//TẠO PHIẾU
if(isset($_POST['them'])){

    $maphieu = $newID;

    $ngaylap = $_POST['ngaylap'];

    $makh = $_POST['makh'];

    $ghichu = trim($_POST['ghichu']);

    $tongsoluong = 0;

    //ARRAY
    $masach = isset($_POST['masach'])
    ? $_POST['masach']
    : [];

    $soluong = isset($_POST['soluong'])
    ? $_POST['soluong']
    : [];

    $hinhthuc = isset($_POST['hinhthuc'])
    ? $_POST['hinhthuc']
    : [];

    $lydo = isset($_POST['lydo'])
    ? $_POST['lydo']
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

    //VALIDATE
    for($i = 0; $i < count($masach); $i++){

        $ms = $masach[$i];

        $sl = (int) $soluong[$i];

        $ht = $hinhthuc[$i];

        //KIỂM TRA SỐ LƯỢNG ĐƯỢC ĐỔI/TRẢ
        $getDaMua = mysqli_query($conn, "

        SELECT
        IFNULL(SUM(ct.SoLuongBan),0) AS DaMua

        FROM CT_HOADON ct

        JOIN HOADON hd
        ON ct.MaHD = hd.MaHD

        WHERE hd.MaKH='$makh'
        AND ct.MaSach='$ms'

        ");

        $mua = mysqli_fetch_assoc($getDaMua);

        $getDaDoiTra = mysqli_query($conn, "

        SELECT
        IFNULL(SUM(ct.SoLuongDoiTra),0) AS DaDoiTra

        FROM CT_PHIEUDOITRA ct

        JOIN PHIEUDOITRA p
        ON ct.MaPhieuDoiTra = p.MaPhieuDoiTra

        WHERE p.MaKH='$makh'
        AND ct.MaSach='$ms'

        ");

        $dt = mysqli_fetch_assoc($getDaDoiTra);

        $conLai =
        (int)$mua['DaMua']
        -
        (int)$dt['DaDoiTra'];

        if($sl > $conLai){

            echo "
            <script>

            alert(
            'Khách chỉ còn được đổi/trả tối đa ".$conLai." cuốn sách này'
            );

            window.history.back();

            </script>
            ";

            exit();
        }

        if($ms == "") continue;

        //CHECK KHÁCH ĐÃ MUA
        $checkMua = mysqli_query($conn, "

        SELECT
        hd.NgayLapHD

        FROM CT_HOADON ct

        JOIN HOADON hd
        ON ct.MaHD = hd.MaHD

        WHERE hd.MaKH = '$makh'
        AND ct.MaSach = '$ms'

        ORDER BY hd.NgayLapHD DESC

        LIMIT 1

        ");

        if(mysqli_num_rows($checkMua) <= 0){

            echo "
            <script>

            alert('Khách hàng chưa mua sách này');

            window.history.back();

            </script>
            ";

            exit();
        }

        $hd = mysqli_fetch_assoc($checkMua);

        //CHECK THỜI HẠN
        $ngayMua = strtotime($hd['NgayLapHD']);

        $ngayDoi = strtotime($ngaylap);

        $soNgay = ($ngayDoi - $ngayMua) / (60 * 60 * 24);

        if($soNgay < 0){

            echo "
            <script>

            alert('Ngày đổi trả không hợp lệ');

            window.history.back();

            </script>
            ";

            exit();
        }

        if($soNgay > $SO_NGAY_DOI_TRA){

            echo "
            <script>

            alert('Đã quá thời hạn đổi/trả');

            window.history.back();

            </script>
            ";

            exit();
        }

        //CHECK TỒN KHO KHI ĐỔI
        if($ht == "Đổi"){

            $getSach = mysqli_query($conn, "
            SELECT *
            FROM SACH
            WHERE MaSach='$ms'
            ");

            $s = mysqli_fetch_assoc($getSach);

            if($sl > $s['SoLuong']){

                echo "
                <script>

                alert('Sách ".$s['TenSach']." không đủ tồn kho');

                window.history.back();

                </script>
                ";

                exit();
            }
        }

        $tongsoluong += $sl;
    }

    //INSERT PHIẾU
    mysqli_query($conn, "

    INSERT INTO PHIEUDOITRA(

        MaPhieuDoiTra,
        NgayDoiTra,
        MaKH,
        TongSoLuong,
        GhiChu

    )

    VALUES(

        '$maphieu',
        '$ngaylap',
        '$makh',
        '$tongsoluong',
        '$ghichu'

    )

    ");

    //INSERT CHI TIẾT
    for($i = 0; $i < count($masach); $i++){

        $ms = $masach[$i];

        $sl = (int) $soluong[$i];

        $ht = $hinhthuc[$i];

        $ld = trim($lydo[$i]);

        if($ms == "") continue;

        //INSERT CHI TIẾT
        mysqli_query($conn, "

        INSERT INTO CT_PHIEUDOITRA(

            MaPhieuDoiTra,
            MaSach,
            SoLuongDoiTra,
            HinhThucXuLy,
            LyDoDoiTra

        )

        VALUES(

            '$maphieu',
            '$ms',
            '$sl',
            '$ht',
            '$ld'

        )

        ");

        //UPDATE KHO
        if($ht == "Đổi"){

            mysqli_query($conn, "

            UPDATE SACH

            SET SoLuong = SoLuong - $sl

            WHERE MaSach='$ms'

            ");

        }else{

            mysqli_query($conn, "

            UPDATE SACH

            SET SoLuong = SoLuong + $sl

            WHERE MaSach='$ms'

            ");
        }
    }

    echo "
    <script>

    alert('Tạo phiếu đổi trả thành công');

    location='index.php';

    </script>
    ";
}

?>

<div class="content">

<h2 class="mb-4">
TẠO PHIẾU ĐỔI TRẢ
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

<label>Ngày đổi trả</label>

<input
type="date"
name="ngaylap"
class="form-control mb-3"
required>

</div>

</div>

<label>Khách hàng</label>

<select
id="makh"
name="makh"
class="form-control mb-4"
required>

<option value="">
    -- Chọn khách hàng --
</option>

<?php while($row = mysqli_fetch_assoc($kh)){ ?>

<option
value="<?= $row['MaKH'] ?>"
<?= ($makh_filter == $row['MaKH']) ? 'selected' : '' ?>>

<?= $row['TenKH'] ?>
- <?= $row['SDT'] ?>

</option>

<?php } ?>

</select>

<h4 class="mb-3">
Danh sách sách đổi/trả
</h4>

<table class="table table-bordered" id="tableSach">

<thead class="table-dark">

<tr>

<th width="30%">
Sách
</th>

<th width="15%">
Số lượng
</th>

<th width="15%">
Hình thức
</th>

<th width="30%">
Lý do
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
class="form-control"
required>

<option value="">
-- Chọn sách khách đã mua --
</option>

<?php

$tempSach = mysqli_query($conn, $sach_query);

while($s = mysqli_fetch_assoc($tempSach)){ ?>

<option value="<?= $s['MaSach'] ?>">

<?= $s['TenSach'] ?>
(Mua: <?= $s['DaMua'] ?> |
Tồn: <?= $s['SoLuong'] ?>)

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

<select
name="hinhthuc[]"
class="form-control">

<option value="Đổi">
Đổi
</option>

<option value="Trả">
Trả
</option>

</select>

</td>

<td>

<input
type="text"
name="lydo[]"
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

<input
type="text"
name="ghichu"
class="form-control mb-4"
placeholder="Ghi chú">

<button
class="btn btn-success"
name="them">

Tạo phiếu

</button>

</div>

</div>

</form>

</div>

<script>

document
.getElementById("themSach")
.addEventListener("click", function(){

    let tbody =
    document.getElementById("tbodySach");

    let firstRow =
    tbody.querySelector("tr");

    let newRow =
    firstRow.cloneNode(true);

    newRow.querySelector("select").selectedIndex = 0;

    newRow.querySelector("input[name='soluong[]']").value = 1;

    newRow.querySelector("input[name='lydo[]']").value = "";

    tbody.appendChild(newRow);
});

document.addEventListener("click", function(e){

    if(e.target.classList.contains("xoa")){

        let rows =
        document.querySelectorAll("#tbodySach tr");

        if(rows.length > 1){

            e.target.closest("tr").remove();
        }
    }
});

//ĐỔI KHÁCH HÀNG

document
.getElementById("makh")
.addEventListener("change", function(){

    let makh = this.value;

    window.location =
    "them.php?makh=" + makh;

});

</script>

<?php
include("../layout/footer.php");
?>