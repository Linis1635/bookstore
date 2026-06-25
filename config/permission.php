<?php

function checkPermission($conn, $manhinh){

    // lấy user hiện tại
    $user = $_SESSION['user'];

    // nếu là ADMIN => full quyền
    if($user['MaNhomNguoiDung'] == 'ADMIN'){

        return true;
    }

    $manhom = $user['MaNhomNguoiDung'];

    $sql = "

    SELECT *

    FROM PHANQUYEN pq

    JOIN CHUCNANG cn
    ON pq.MaChucNang = cn.MaChucNang

    WHERE pq.MaNhomNguoiDung='$manhom'

    AND cn.TenManHinh='$manhinh'

    ";

    $result = mysqli_query($conn, $sql);

    return mysqli_num_rows($result) > 0;
}
?>