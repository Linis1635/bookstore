```php
<?php

session_start();

include("../config/db.php");

include("../layout/header.php");
include("../layout/sidebar.php");

$nv = mysqli_query($conn, "
SELECT *
FROM NHANVIEN
ORDER BY TenNV
");

/*
TẠO MÃ PHIẾU
*/

$sql = "
SELECT MaPhieuChi
FROM PHIEUCHI
ORDER BY MaPhieuChi DESC
LIMIT 1
";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    $lastID = $row['MaPhieuChi'];

    $num = (int) substr($lastID, 2);

    $num++;

    $newID = "PC" . str_pad($num, 3, "0", STR_PAD_LEFT);

}else{

    $newID = "PC001";
}

/*
XỬ LÝ LẬP PHIẾU CHI
*/

if(isset($_POST['them'])){

    $mapc = $newID;

    $ngaychi = $_POST['ngaychi'];

    $manv = $_POST['manv'];

    $sotien = (int)$_POST['sotien'];

    $noidung = trim($_POST['noidung']);

    /*
    VALIDATE
    */

    if($sotien <= 0){

        echo "
        <script>

        alert('Số tiền phải lớn hơn 0');

        </script>
        ";

    }else if(empty($noidung)){

        echo "
        <script>

        alert('Vui lòng nhập nội dung chi');

        </script>
        ";

    }else{

        mysqli_query($conn, "
        INSERT INTO PHIEUCHI
        VALUES(
            '$mapc',
            '$ngaychi',
            '$manv',
            '$sotien',
            '$noidung'
        )
        ");

        echo "
        <script>

        alert('Lập phiếu chi thành công');

        window.location='index.php';

        </script>
        ";
    }
}

?>

<div class="content">

<h2 class="mb-4">
    LẬP PHIẾU CHI
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

<label>Mã phiếu chi</label>

<input
type="text"
class="form-control mb-3"
value="<?= $newID ?>"
readonly>

</div>

<div class="col-md-6">

<label>Ngày chi</label>

<input
type="date"
name="ngaychi"
class="form-control mb-3"
required>

</div>

</div>

<label>Nhân viên</label>

<select
name="manv"
class="form-control mb-3"
required>

<?php while($row = mysqli_fetch_assoc($nv)){ ?>

<option value="<?= $row['MaNV'] ?>">

<?= $row['TenNV'] ?>

</option>

<?php } ?>

</select>

<label>Số tiền chi</label>

<input
type="number"
name="sotien"
class="form-control mb-3"
placeholder="Nhập số tiền chi"
required>

<label>Nội dung chi</label>

<textarea
name="noidung"
class="form-control mb-4"
rows="3"
placeholder="Nhập nội dung chi..."
required></textarea>

<button
class="btn btn-success"
name="them">

Lập phiếu chi

</button>

</div>

</div>

</form>

</div>

<?php
include("../layout/footer.php");
?>
```
