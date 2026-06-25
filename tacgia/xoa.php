<?php

include("../config/db.php");

$id = $_GET['id'];

//KIỂM TRA CÒN SÁCH SỬ DỤNG KHÔNG
$check = mysqli_query($conn, "

SELECT COUNT(*) AS total

FROM SACH

WHERE MaTacGia='$id'

");

$data = mysqli_fetch_assoc($check);

if($data['total'] > 0){

    echo "
    <script>

    alert('Không thể xóa tác giả vì đang có sách thuộc tác giả này');

    location='index.php';

    </script>
    ";

    exit();
}

//XÓA TÁC GIẢ
mysqli_query($conn, "

DELETE FROM TACGIA

WHERE MaTacGia='$id'

");

echo "
<script>

alert('Xóa tác giả thành công');

location='index.php';

</script>
";

?>