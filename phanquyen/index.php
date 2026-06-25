<?php
session_start();

include("../config/db.php");
include("../config/auth.php");
include("../config/permission.php");

// Kiểm tra quyền truy cập trang phân quyền
if(!checkPermission($conn, 'phanquyen')){
    echo "<script>alert('Bạn không có quyền truy cập'); location='../dashboard/index.php';</script>";
    exit();
}

include("../layout/header.php");
include("../layout/sidebar.php");

/* ==========================================
   1. XỬ LÝ CẤP TÀI KHOẢN MỚI
========================================== */
if(isset($_POST['captaikhoan'])){
    $manv = $_POST['manv_cap'];
    $tendangnhap = trim($_POST['tendangnhap']);
    $matkhau = $_POST['matkhau'];
    $manhom = $_POST['manhom_cap'];

    // Kiểm tra tên đăng nhập đã tồn tại chưa
    $checkUser = mysqli_query($conn, "SELECT * FROM NGUOIDUNG WHERE TenDangNhap='$tendangnhap'");
    if(mysqli_num_rows($checkUser) > 0){
        echo "<script>alert('Tên đăng nhập này đã có người sử dụng!'); location='index.php';</script>";
        exit();
    }

    // Tự động tạo mã Người dùng (ND01, ND02...)
    $getMaxND = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(MaNguoiDung, 3) AS UNSIGNED)) as max_id FROM NGUOIDUNG");
    $rowMaxND = mysqli_fetch_assoc($getMaxND);
    $numND = (int)$rowMaxND['max_id'] + 1;
    $maNguoiDungMoi = "ND" . str_pad($numND, 2, "0", STR_PAD_LEFT);

    // Thêm vào bảng NGUOIDUNG
    $sqlInsertND = "INSERT INTO NGUOIDUNG (MaNguoiDung, MaNhomNguoiDung, MaNV, TenDangNhap, MatKhau)
                    VALUES ('$maNguoiDungMoi', '$manhom', '$manv', '$tendangnhap', '$matkhau')";
    
    if(mysqli_query($conn, $sqlInsertND)){
        echo "<script>alert('Cấp tài khoản thành công!'); location='index.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . mysqli_error($conn) . "');</script>";
    }
}

/* ==========================================
   2. XỬ LÝ LƯU QUYỀN (Hệ thống cũ của bạn)
========================================== */
if(isset($_POST['luuquyen'])){
    $manhom_luu = $_POST['manhom_luu'];
    // Bắt đầu Transaction để tránh lỗi gãy dữ liệu
    mysqli_begin_transaction($conn);
    try {
        // Xóa hết quyền cũ
        mysqli_query($conn, "DELETE FROM PHANQUYEN WHERE MaNhomNguoiDung='$manhom_luu'");
        
        // Thêm lại quyền mới nếu có tick chọn
        if(isset($_POST['chucnang']) && !empty($_POST['chucnang'])){
            foreach($_POST['chucnang'] as $macn){
                mysqli_query($conn, "INSERT INTO PHANQUYEN (MaNhomNguoiDung, MaChucNang) VALUES ('$manhom_luu', '$macn')");
            }
        }
        mysqli_commit($conn);
        echo "<script>alert('Cập nhật phân quyền thành công!'); location='index.php?manhom=$manhom_luu';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Lỗi hệ thống khi lưu quyền!');</script>";
    }
}

/* ==========================================
   3. LẤY DỮ LIỆU HIỂN THỊ LÊN GIAO DIỆN
========================================== */
$nhom = mysqli_query($conn, "SELECT * FROM NHOMNGUOIDUNG");

// Danh sách Nhóm & Nhân viên cho form CẤP TÀI KHOẢN
$listNhom = mysqli_query($conn, "SELECT * FROM NHOMNGUOIDUNG");
// Chỉ lấy những nhân viên CHƯA có tài khoản trong bảng NGUOIDUNG
$listNV_ChuaCoTK = mysqli_query($conn, "
    SELECT * FROM NHANVIEN 
    WHERE MaNV NOT IN (SELECT MaNV FROM NGUOIDUNG)
");

$manhom = "";
$tennhom = "";
$users = [];
$quyen_hientai = [];
$all_chucnang = null;

if(isset($_GET['manhom'])){
    $manhom = $_GET['manhom'];

    // Thông tin nhóm
    $nhom_sql = mysqli_query($conn, "SELECT * FROM NHOMNGUOIDUNG WHERE MaNhomNguoiDung='$manhom'");
    $nhom_data = mysqli_fetch_assoc($nhom_sql);
    $tennhom = $nhom_data['TenNhomNguoiDung'];

    // Danh sách user thuộc nhóm này
    $user_sql = mysqli_query($conn, "
        SELECT nd.*, nv.TenNV, nv.SDT 
        FROM NGUOIDUNG nd 
        JOIN NHANVIEN nv ON nd.MaNV = nv.MaNV 
        WHERE nd.MaNhomNguoiDung='$manhom'
    ");
    while($u = mysqli_fetch_assoc($user_sql)){
        $users[] = $u;
    }

    // Các quyền nhóm đang có
    $quyen_sql = mysqli_query($conn, "SELECT MaChucNang FROM PHANQUYEN WHERE MaNhomNguoiDung='$manhom'");
    while($q = mysqli_fetch_assoc($quyen_sql)){
        $quyen_hientai[] = $q['MaChucNang'];
    }

    // Lấy tất cả chức năng (trừ chức năng cấu hình hệ thống nếu cần)
    $all_chucnang = mysqli_query($conn, "SELECT * FROM CHUCNANG WHERE TenManHinh != 'phanquyen'");
}
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>QUẢN LÝ PHÂN QUYỀN</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#capTaiKhoanModal">
            <i class="bi bi-person-plus-fill"></i> Cấp tài khoản nhân viên
        </button>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group shadow-sm">
                <?php while($row = mysqli_fetch_assoc($nhom)){ ?>
                    <a href="?manhom=<?= $row['MaNhomNguoiDung'] ?>" 
                       class="list-group-item list-group-item-action <?= $manhom == $row['MaNhomNguoiDung'] ? 'active bg-dark border-dark' : '' ?>">
                        <i class="bi bi-people-fill me-2"></i>
                        <?= $row['TenNhomNguoiDung'] ?>
                    </a>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-9">
            <?php if(!empty($manhom)){ ?>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h4 class="mb-3">Danh sách tài khoản nhóm: <span class="text-primary"><?= $tennhom ?></span></h4>
                        
                        <table class="table table-bordered">
                            <tr class="table-dark">
                                <th>Tên đăng nhập</th>
                                <th>Tên nhân viên</th>
                                <th>Số điện thoại</th>
                            </tr>
                            <?php if(count($users) > 0){ 
                                foreach($users as $u){ ?>
                                <tr>
                                    <td><b><?= $u['TenDangNhap'] ?></b></td>
                                    <td><?= $u['TenNV'] ?></td>
                                    <td><?= $u['SDT'] ?></td>
                                </tr>
                            <?php } } else { ?>
                                <tr><td colspan="3" class="text-center text-muted">Chưa có tài khoản nào thuộc nhóm này</td></tr>
                            <?php } ?>
                        </table>

                        <?php if($manhom != "ADMIN"){ ?>
                            <button type="button" class="btn btn-warning mt-2 fw-bold" data-bs-toggle="modal" data-bs-target="#phanquyenModal">
                                <i class="bi bi-shield-lock-fill me-2"></i> Cấu hình quyền hạn
                            </button>
                        <?php } else { ?>
                            <div class="alert alert-danger mt-3 mb-0">
                                <i class="bi bi-exclamation-triangle-fill"></i> Không được phép chỉnh sửa quyền của nhóm quản trị viên tối cao (ADMIN).
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="alert alert-info shadow-sm text-center py-5">
                    <i class="bi bi-hand-index-thumb fs-1 d-block mb-3"></i>
                    Vui lòng chọn một Nhóm người dùng bên trái để xem chi tiết và cấu hình quyền hạn.
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" id="capTaiKhoanModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">CẤP TÀI KHOẢN NHÂN VIÊN</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label class="fw-bold">Chọn nhân viên <span class="text-danger">*</span></label>
                        <select name="manv_cap" class="form-control" required>
                            <option value="">-- Chọn nhân viên chưa có tài khoản --</option>
                            <?php while($nv = mysqli_fetch_assoc($listNV_ChuaCoTK)){ ?>
                                <option value="<?= $nv['MaNV'] ?>">
                                    <?= $nv['MaNV'] ?> - <?= $nv['TenNV'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <small class="text-muted">Chỉ hiển thị nhân viên chưa có tài khoản trên hệ thống.</small>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Tên đăng nhập <span class="text-danger">*</span></label>
                        <input type="text" name="tendangnhap" class="form-control" placeholder="Ví dụ: nva, admin..." required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" name="matkhau" class="form-control" placeholder="Nhập mật khẩu..." required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Chọn nhóm người dùng (Phân quyền) <span class="text-danger">*</span></label>
                        <select name="manhom_cap" class="form-control" required>
                            <option value="">-- Chọn nhóm phân quyền --</option>
                            <?php while($n = mysqli_fetch_assoc($listNhom)){ ?>
                                <option value="<?= $n['MaNhomNguoiDung'] ?>">
                                    <?= $n['TenNhomNguoiDung'] ?> (<?= $n['MaNhomNguoiDung'] ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" name="captaikhoan" class="btn btn-success">Cấp tài khoản</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if(isset($all_chucnang) && $manhom != "ADMIN"){ ?>
<div class="modal fade" id="phanquyenModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Phân quyền: <?= $tennhom ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="manhom_luu" value="<?= $manhom ?>">
                    <div class="row">
                        <?php while($cn = mysqli_fetch_assoc($all_chucnang)){ ?>
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           name="chucnang[]" 
                                           value="<?= $cn['MaChucNang'] ?>"
                                           <?= in_array($cn['MaChucNang'], $quyen_hientai) ? 'checked' : '' ?> >
                                    <label class="form-check-label">
                                        <?= $cn['TenChucNang'] ?>
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" name="luuquyen" class="btn btn-primary">Lưu phân quyền</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>

<?php include("../layout/footer.php"); ?>