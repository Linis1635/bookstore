<?php

include("../config/db.php");

$id = $_GET['id'];

//KIỂM TRA CÒN SÁCH SỬ DỤNG KHÔNG
$check = mysqli_query($conn, "

SELECT COUNT(*) AS total

FROM SACH

WHERE MaTheLoai='$id'

");

$data = mysqli_fetch_assoc($check);

if($data['total'] > 0){

    echo "
    <script>

    alert('Không thể xóa thể loại vì đang có sách sử dụng');

    location='index.php';

    </script>
    ";

    exit();
}

//XÓA THỂ LOẠI
mysqli_query($conn, "

DELETE FROM THELOAI

WHERE MaTheLoai='$id'

");

echo "
<script>

alert('Xóa thể loại thành công');

location='index.php';

</script>
";

?>