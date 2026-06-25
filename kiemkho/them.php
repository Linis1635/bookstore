<?php

include("../config/auth.php");
include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

/*
LẤY DANH SÁCH SÁCH
*/

$sach = mysqli_query($conn, "
SELECT *
FROM SACH
ORDER BY TenSach
");

/*
TẠO MÃ PHIẾU
*/

$sql = "
SELECT MaPhieu
FROM PHIEUKIEMKHO
ORDER BY MaPhieu DESC
LIMIT 1
";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    $lastID = $row['MaPhieu'];

    $num = (int) substr($lastID, 3);

    $num++;

    $newID = "PKK" . str_pad($num, 3, "0", STR_PAD_LEFT);

}else{

    $newID = "PKK001";
}

/*
XỬ LÝ TẠO PHIẾU
*/

if(isset($_POST['them'])){

    $maphieu = $newID;

    $ngaylap = $_POST['ngaylap'];

    $masach = $_POST['masach'] ?? [];

    $thucte = $_POST['thucte'] ?? [];

    $ghichu = $_POST['ghichu'] ?? [];

    /*
    THÊM PHIẾU
    */

    mysqli_query($conn, "
    INSERT INTO PHIEUKIEMKHO
    VALUES(
        '$maphieu',
        '$ngaylap'
    )
    ");

    /*
    THÊM CHI TIẾT
    */

    for($i = 0; $i < count($masach); $i++){

        $ms = $masach[$i];

        $sl_thucte = (int)$thucte[$i];

        $note = $ghichu[$i];

        /*
        LẤY TỒN HỆ THỐNG
        */

        $book = mysqli_query($conn, "
        SELECT *
        FROM SACH
        WHERE MaSach='$ms'
        ");

        $b = mysqli_fetch_assoc($book);

        $tonhethong = $b['SoLuong'];

        $chenhlech = $sl_thucte - $tonhethong;

        /*
        INSERT CHI TIẾT
        */

        mysqli_query($conn, "
        INSERT INTO CT_PHIEUKIEMKHO
        VALUES(
            '$maphieu',
            '$ms',
            '$sl_thucte',
            '$chenhlech',
            '$note'
        )
        ");

        /*
        CẬP NHẬT TỒN KHO
        */

        mysqli_query($conn, "
        UPDATE SACH
        SET SoLuong='$sl_thucte'
        WHERE MaSach='$ms'
        ");
    }

    echo "
    <script>

    alert('Tạo phiếu kiểm kho thành công');

    window.location='index.php';

    </script>
    ";
}

?>

<div class="content">

<h2 class="mb-4">
TẠO PHIẾU KIỂM KHO
</h2>

<a href="index.php" class="btn btn-secondary mb-3">
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

<label>Ngày lập</label>

<input
type="date"
name="ngaylap"
class="form-control mb-3"
required>

</div>

</div>

<h4 class="mb-3">
Danh sách kiểm kho
</h4>

<table class="table table-bordered" id="tableSach">

<thead class="table-dark">

<tr>

<th width="35%">
Sách
</th>

<th width="20%">
Tồn hệ thống
</th>

<th width="20%">
Thực tế
</th>

<th width="15%">
Ghi chú
</th>

<th width="10%">
</th>

</tr>

</thead>

<tbody>

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

mysqli_data_seek($sach, 0);

while($s = mysqli_fetch_assoc($sach)){ ?>

<option
value="<?= $s['MaSach'] ?>"
data-ton="<?= $s['SoLuong'] ?>">

<?= $s['TenSach'] ?>

</option>

<?php } ?>

</select>

</td>

<td>

<input
type="text"
class="form-control ton"
readonly>

</td>

<td>

<input
type="number"
name="thucte[]"
class="form-control"
required>

</td>

<td>

<input
type="text"
name="ghichu[]"
class="form-control">

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
name="them">

Lưu phiếu kiểm kho

</button>

</div>

</div>

</form>

</div>

<script>

document.getElementById("themSach").onclick = function(){

    let table = document.querySelector("#tableSach tbody");

    let row = table.rows[0].cloneNode(true);

    row.querySelector(".sach-select").selectedIndex = 0;

    row.querySelector(".ton").value = "";

    row.querySelector("input[name='thucte[]']").value = "";

    row.querySelector("input[name='ghichu[]']").value = "";

    table.appendChild(row);
};

/*
HIỂN THỊ TỒN KHO
*/

document.addEventListener("change", function(e){

    if(e.target.classList.contains("sach-select")){

        let option = e.target.options[e.target.selectedIndex];

        let ton = option.getAttribute("data-ton");

        let row = e.target.closest("tr");

        row.querySelector(".ton").value = ton;
    }
});

/*
XÓA DÒNG
*/

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