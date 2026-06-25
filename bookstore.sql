-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 05, 2026 at 09:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `chucnang`
--

CREATE TABLE `chucnang` (
  `MaChucNang` varchar(20) NOT NULL,
  `TenChucNang` varchar(100) DEFAULT NULL,
  `TenManHinh` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chucnang`
--

INSERT INTO `chucnang` (`MaChucNang`, `TenChucNang`, `TenManHinh`) VALUES
('CN01', 'Quản lý sách', 'sach'),
('CN02', 'Quản lý tác giả', 'tacgia'),
('CN03', 'Quản lý thể loại', 'theloai'),
('CN04', 'Quản lý nhà cung cấp', 'nhacungcap'),
('CN05', 'Quản lý phiếu nhập', 'phieunhap'),
('CN06', 'Quản lý hóa đơn', 'hoadon'),
('CN07', 'Quản lý khách hàng', 'khachhang'),
('CN08', 'Quản lý phiếu thu', 'phieuthu'),
('CN09', 'Xem báo cáo', 'baocao'),
('CN11', 'Quản lý đổi trả', 'phieudoitra'),
('CN12', 'Phan quyen', 'phanquyen'),
('CN13', 'Quản lý tham số', 'thamso');

-- --------------------------------------------------------

--
-- Table structure for table `ct_hoadon`
--

CREATE TABLE `ct_hoadon` (
  `MaHD` varchar(20) NOT NULL,
  `MaSach` varchar(20) NOT NULL,
  `SoLuongBan` int(11) DEFAULT NULL,
  `ThanhTien` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ct_hoadon`
--

INSERT INTO `ct_hoadon` (`MaHD`, `MaSach`, `SoLuongBan`, `ThanhTien`) VALUES
('HD001', 'S074', 1, 525000),
('HD002', 'S002', 1, 65000),
('HD002', 'S101', 1, 52500),
('HD003', 'S220', 1, 30000),
('HD003', 'S221', 1, 30000),
('HD004', 'S032', 1, 210000),
('HD004', 'S103', 1, 84000);

-- --------------------------------------------------------

--
-- Table structure for table `ct_phieudoitra`
--

CREATE TABLE `ct_phieudoitra` (
  `MaPhieuDoiTra` varchar(20) NOT NULL,
  `MaSach` varchar(20) NOT NULL,
  `SoLuongDoiTra` int(11) DEFAULT NULL,
  `HinhThucXuLy` varchar(50) DEFAULT NULL,
  `LyDoDoiTra` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ct_phieudoitra`
--

INSERT INTO `ct_phieudoitra` (`MaPhieuDoiTra`, `MaSach`, `SoLuongDoiTra`, `HinhThucXuLy`, `LyDoDoiTra`) VALUES
('DT001', 'S221', 1, 'Trả', 'mất trang');

-- --------------------------------------------------------

--
-- Table structure for table `ct_phieukiemkho`
--

CREATE TABLE `ct_phieukiemkho` (
  `MaPhieu` varchar(20) NOT NULL,
  `MaSach` varchar(20) NOT NULL,
  `SoLuongThucTe` int(11) DEFAULT NULL,
  `ChenhLech` int(11) DEFAULT NULL,
  `GhiChu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ct_phieukiemkho`
--

INSERT INTO `ct_phieukiemkho` (`MaPhieu`, `MaSach`, `SoLuongThucTe`, `ChenhLech`, `GhiChu`) VALUES
('PKK001', 'S012', 360, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `ct_phieunhap`
--

CREATE TABLE `ct_phieunhap` (
  `MaPhieuNhap` varchar(20) NOT NULL,
  `MaSach` varchar(20) NOT NULL,
  `DonGiaNhap` int(11) DEFAULT NULL,
  `SoLuongNhap` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ct_phieunhap`
--

INSERT INTO `ct_phieunhap` (`MaPhieuNhap`, `MaSach`, `DonGiaNhap`, `SoLuongNhap`) VALUES
('PN002', 'S012', 150000, 150),
('PN003', 'S064', 600, 600),
('PN006', 'S064', 1000, 150),
('PN008', 'S012', 50000, 150),
('PN012', 'S064', 5000, 160),
('PN013', 'S100', 650000, 300),
('PN013', 'S119', 24000, 350),
('PN013', 'S120', 20000, 350),
('PN014', 'S103', 80000, 300),
('PN014', 'S122', 55000, 300),
('PN014', 'S126', 45000, 300),
('PN014', 'S129', 90000, 300),
('PN015', 'S033', 22000, 350),
('PN015', 'S074', 500000, 300),
('PN015', 'S118', 70000, 350),
('PN016', 'S032', 200000, 300),
('PN016', 'S104', 75000, 400),
('PN016', 'S123', 80000, 400),
('PN016', 'S128', 110000, 350),
('PN017', 'S102', 85000, 350),
('PN017', 'S121', 60000, 400),
('PN017', 'S125', 70000, 400),
('PN018', 'S004', 500000, 340),
('PN018', 'S108', 500000, 400),
('PN018', 'S109', 500000, 400),
('PN018', 'S110', 500000, 400),
('PN018', 'S111', 500000, 400),
('PN018', 'S112', 500000, 400),
('PN018', 'S113', 500000, 400);

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `MaHD` varchar(20) NOT NULL,
  `NgayLapHD` datetime DEFAULT NULL,
  `MaKH` varchar(20) DEFAULT NULL,
  `TongTien` int(11) DEFAULT NULL,
  `DaTra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`MaHD`, `NgayLapHD`, `MaKH`, `TongTien`, `DaTra`) VALUES
('HD001', '2026-04-01 00:00:00', 'KH07', 525000, 525000),
('HD002', '2026-06-02 00:00:00', 'KH08', 117500, 0),
('HD003', '2026-06-03 00:00:00', 'KH01', 60000, 60000),
('HD004', '2026-06-04 00:00:00', 'KH04', 294000, 200000);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` varchar(20) NOT NULL,
  `TenKH` varchar(100) DEFAULT NULL,
  `NamSinh` datetime DEFAULT NULL,
  `SDT` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `TienNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `TenKH`, `NamSinh`, `SDT`, `Email`, `DiaChi`, `TienNo`) VALUES
('KH01', 'Nguyễn Văn A', '2000-01-01 00:00:00', '0123456789', 'testa@gmail.com', 'HCM', 0),
('KH02', 'Nguyễn Văn B', '2012-03-31 00:00:00', '0123456789', 'abc@gmail.com', 'HN', 0),
('KH03', 'Tuyết Như', '1998-05-09 00:00:00', '0987999442', 'nhu@gmail.com', 'KTX khu A', 0),
('KH04', 'Yến Nhi', '1994-04-04 00:00:00', '0987999443', 'nhi@gmail.com', 'KTX khu B', 94000),
('KH05', 'Thành Thắng', '1995-05-05 00:00:00', '0987999444', 'thang@gmail.com', 'Đà Nẵng', 0),
('KH06', 'Phúc Thịnh', '1998-01-01 00:00:00', '0987999449', 'thinhpl@gmail.com', 'KTX khu A', 0),
('KH07', 'A', '2000-01-07 00:00:00', '0123345678', 'A@gmail.com', '123 Vĩnh Khánh', 0),
('KH08', 'B', '2000-04-01 00:00:00', '0123345678', 'A@gmail.com', '123 Vĩnh Khánh', 117500);

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MaNguoiDung` varchar(10) NOT NULL,
  `MaNhomNguoiDung` varchar(10) DEFAULT NULL,
  `MaNV` varchar(10) DEFAULT NULL,
  `TenDangNhap` varchar(50) DEFAULT NULL,
  `MatKhau` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`MaNguoiDung`, `MaNhomNguoiDung`, `MaNV`, `TenDangNhap`, `MatKhau`) VALUES
('ND01', 'ADMIN', 'NV01', 'admin', '123'),
('ND02', 'NVBH', 'NV02', 'anbh', '123'),
('ND03', 'NVKHO', 'NV03', 'abckho', '123'),
('ND04', 'NVBH', 'NV04', 'bBH', '123');

-- --------------------------------------------------------

--
-- Table structure for table `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MaNCC` varchar(20) NOT NULL,
  `TenNCC` varchar(100) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhacungcap`
--

INSERT INTO `nhacungcap` (`MaNCC`, `TenNCC`, `DiaChi`) VALUES
('NCC01', 'Nhã Nam', 'Hà Nội'),
('NCC02', 'ABC', 'HCM'),
('NCC03', 'NXB Giáo Dục', 'Hà Nội'),
('NCC04', 'NXB Lao Động', 'Đà Nẵng'),
('NCC05', 'NXB Tổng Hợp', 'Cần Thơ'),
('NCC06', 'Fahasa', 'TP Hồ Chí Minh'),
('NCC07', 'Phương Nam Book', 'TP Hồ Chí Minh'),
('NCC08', 'Alpha Books', 'Hà Nội'),
('NCC09', 'First News', 'TP Hồ Chí Minh'),
('NCC10', 'Nhã Nam', 'Hà Nội'),
('NCC11', 'Tiki Trading', 'TP Hồ Chí Minh'),
('NCC12', 'Vinabook', 'TP Hồ Chí Minh'),
('NCC13', 'MCBooks', 'Hà Nội'),
('NCC14', 'AZ Việt Nam', 'Hà Nội'),
('NCC15', 'Skybooks', 'TP Hồ Chí Minh');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` varchar(20) NOT NULL,
  `TenNV` varchar(100) DEFAULT NULL,
  `NamSinh` datetime DEFAULT NULL,
  `SDT` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `TenNV`, `NamSinh`, `SDT`, `Email`, `DiaChi`) VALUES
('NV01', 'Nguyễn Văn A', '1991-07-12 00:00:00', '0123466789', 'nva@gm.com', 'Q7, HCM'),
('NV02', 'Lê an', '2000-11-22 00:00:00', '012349999', 'annn@gm.com', 'Q12, HCM'),
('NV03', 'Trần ABC', '1999-05-01 00:00:00', '0123455555', 'abc@gm.com', 'Bình Thạnh, HCM'),
('NV04', 'Nguyễn Văn B', '1997-09-01 00:00:00', '012341119', 'bbbbbbb@gm.com', 'Thủ Đức, HCM'),
('NV05', 'Linh', '2000-03-04 00:00:00', '0987999448', 'linhnl@gmail.com', 'HCM');

-- --------------------------------------------------------

--
-- Table structure for table `nhomnguoidung`
--

CREATE TABLE `nhomnguoidung` (
  `MaNhomNguoiDung` varchar(20) NOT NULL,
  `TenNhomNguoiDung` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhomnguoidung`
--

INSERT INTO `nhomnguoidung` (`MaNhomNguoiDung`, `TenNhomNguoiDung`) VALUES
('ADMIN', 'Quản trị'),
('NVBH', 'Nhân viên bán hàng'),
('NVKHO', 'Nhân viên kho');

-- --------------------------------------------------------

--
-- Table structure for table `phanquyen`
--

CREATE TABLE `phanquyen` (
  `MaNhomNguoiDung` varchar(20) NOT NULL,
  `MaChucNang` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phanquyen`
--

INSERT INTO `phanquyen` (`MaNhomNguoiDung`, `MaChucNang`) VALUES
('ADMIN', 'CN01'),
('ADMIN', 'CN02'),
('ADMIN', 'CN03'),
('ADMIN', 'CN04'),
('ADMIN', 'CN05'),
('ADMIN', 'CN06'),
('ADMIN', 'CN07'),
('ADMIN', 'CN08'),
('ADMIN', 'CN09'),
('ADMIN', 'CN11'),
('ADMIN', 'CN12'),
('ADMIN', 'CN13'),
('NVBH', 'CN06'),
('NVBH', 'CN07'),
('NVBH', 'CN08'),
('NVBH', 'CN09'),
('NVBH', 'CN11'),
('NVKHO', 'CN01'),
('NVKHO', 'CN04'),
('NVKHO', 'CN05'),
('NVKHO', 'CN09');

-- --------------------------------------------------------

--
-- Table structure for table `phieuchi`
--

CREATE TABLE `phieuchi` (
  `MaPhieuChi` varchar(20) NOT NULL,
  `NgayChi` datetime DEFAULT NULL,
  `MaNV` varchar(20) DEFAULT NULL,
  `SoTien` int(11) DEFAULT NULL,
  `NoiDung` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieudoitra`
--

CREATE TABLE `phieudoitra` (
  `MaPhieuDoiTra` varchar(20) NOT NULL,
  `NgayDoiTra` datetime DEFAULT NULL,
  `MaKH` varchar(20) DEFAULT NULL,
  `TongSoLuong` int(11) DEFAULT NULL,
  `GhiChu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieudoitra`
--

INSERT INTO `phieudoitra` (`MaPhieuDoiTra`, `NgayDoiTra`, `MaKH`, `TongSoLuong`, `GhiChu`) VALUES
('DT001', '2026-06-04 00:00:00', 'KH01', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `phieukiemkho`
--

CREATE TABLE `phieukiemkho` (
  `MaPhieu` varchar(20) NOT NULL,
  `NgayLap` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieukiemkho`
--

INSERT INTO `phieukiemkho` (`MaPhieu`, `NgayLap`) VALUES
('PKK001', '2026-05-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `phieunhap`
--

CREATE TABLE `phieunhap` (
  `MaPhieuNhap` varchar(20) NOT NULL,
  `NgayNhap` datetime DEFAULT NULL,
  `MaNCC` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieunhap`
--

INSERT INTO `phieunhap` (`MaPhieuNhap`, `NgayNhap`, `MaNCC`) VALUES
('PN001', '2026-05-30 00:00:00', 'NCC01'),
('PN002', '2026-05-30 00:00:00', 'NCC01'),
('PN003', '2026-05-30 00:00:00', 'NCC15'),
('PN004', '2026-05-30 00:00:00', 'NCC01'),
('PN005', '2026-06-30 00:00:00', 'NCC01'),
('PN006', '2026-06-30 00:00:00', 'NCC01'),
('PN007', '2026-05-30 00:00:00', 'NCC01'),
('PN008', '2026-05-30 00:00:00', 'NCC01'),
('PN009', '2026-05-31 00:00:00', 'NCC01'),
('PN010', '2026-05-30 00:00:00', 'NCC01'),
('PN011', '2026-05-30 00:00:00', 'NCC01'),
('PN012', '2026-05-30 00:00:00', 'NCC01'),
('PN013', '2026-04-01 00:00:00', 'NCC08'),
('PN014', '2026-06-02 00:00:00', 'NCC09'),
('PN015', '2026-03-12 00:00:00', 'NCC12'),
('PN016', '2026-04-23 00:00:00', 'NCC13'),
('PN017', '2026-02-17 00:00:00', 'NCC15'),
('PN018', '2026-03-23 00:00:00', 'NCC14');

-- --------------------------------------------------------

--
-- Table structure for table `phieuthu`
--

CREATE TABLE `phieuthu` (
  `MaPhieuThu` varchar(20) NOT NULL,
  `NgayThu` datetime DEFAULT NULL,
  `MaHD` varchar(20) DEFAULT NULL,
  `MaKH` varchar(20) DEFAULT NULL,
  `MaNV` varchar(20) DEFAULT NULL,
  `SoTien` int(11) DEFAULT NULL,
  `NoiDung` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieuthu`
--

INSERT INTO `phieuthu` (`MaPhieuThu`, `NgayThu`, `MaHD`, `MaKH`, `MaNV`, `SoTien`, `NoiDung`) VALUES
('PT001', '2026-04-06 00:00:00', 'HD001', 'KH07', 'NV01', 525000, 'Thanh toán hóa đơn'),
('PT002', '2026-06-05 00:00:00', 'HD003', 'KH01', 'NV01', 60000, 'Thanh toán hóa đơn'),
('PT003', '2026-06-04 00:00:00', 'HD004', 'KH04', 'NV01', 200000, 'thanh toán');

-- --------------------------------------------------------

--
-- Table structure for table `sach`
--

CREATE TABLE `sach` (
  `MaSach` varchar(20) NOT NULL,
  `TenSach` varchar(255) DEFAULT NULL,
  `MaTheLoai` varchar(20) DEFAULT NULL,
  `MaTacGia` varchar(20) DEFAULT NULL,
  `SoLuong` int(11) DEFAULT NULL,
  `DonGiaBan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sach`
--

INSERT INTO `sach` (`MaSach`, `TenSach`, `MaTheLoai`, `MaTacGia`, `SoLuong`, `DonGiaBan`) VALUES
('S002', 'Lão Hạc', 'TL07', 'TG33', 154, 65000),
('S003', 'Mắt Biếc', 'TL07', 'TG03', 39, 89000),
('S004', 'Harry Potter và Hòn đá Phù thủy', 'TL08', 'TG04', 400, 525000),
('S005', 'Nhà Giả Kim', 'TL05', 'TG05', 45, 99000),
('S006', 'Mật Mã Da Vinci', 'TL09', 'TG06', 35, 125000),
('S007', 'Đắc Nhân Tâm', 'TL05', 'TG07', 80, 110000),
('S008', 'It', 'TL09', 'TG08', 20, 170000),
('S009', 'Rừng Na Uy', 'TL07', 'TG09', 25, 130000),
('S010', 'Tắt Đèn', 'TL07', 'TG10', 40, 70000),
('S011', 'Những Người Khốn Khổ', 'TL07', 'TG11', 15, 180000),
('S012', '1984', 'TL07', 'TG12', 296, 115000),
('S013', 'Án Mạng Trên Chuyến Tàu', 'TL09', 'TG13', 17, 95000),
('S014', 'Sherlock Holmes', 'TL09', 'TG14', 33, 120000),
('S015', 'Yêu', 'TL06', 'TG15', 28, 85000),
('S016', 'Nhà Lãnh Đạo Không Chức Danh', 'TL05', 'TG16', 18, 105000),
('S017', 'Cà Phê Cùng Tony', 'TL05', 'TG17', 67, 78000),
('S018', 'Sapiens', 'TL10', 'TG18', 55, 160000),
('S019', 'Truyện Kiều', 'TL07', 'TG19', 135, 68000),
('S020', 'Thơ Xuân Diệu', 'TL07', 'TG20', 36, 72000),
('S021', 'Tuổi Trẻ Đáng Giá Bao Nhiêu ?', 'TL05', 'TG67', 45, 88000),
('S022', 'Cho Tôi Xin Một Vé Đi Tuổi Thơ', 'TL04', 'TG03', 60, 92000),
('S023', 'Bí Mật Tư Duy Triệu Phú', 'TL02', 'TG25', 38, 125000),
('S024', 'Muôn Kiếp Nhân Sinh', 'TL06', 'TG48', 50, 135000),
('S025', 'Cha Giàu Cha Nghèo', 'TL02', 'TG30', 61, 118000),
('S026', 'Thinking Fast and Slow', 'TL06', 'TG18', 20, 175000),
('S027', 'Atomic Habits', 'TL05', 'TG23', 55, 145000),
('S028', 'Cây Cam Ngọt Của Tôi', 'TL07', 'TG29', 34, 98000),
('S029', 'Đồi Gió Hú', 'TL07', 'TG70', 22, 132000),
('S030', 'Pride and Prejudice', 'TL07', 'TG57', 18, 126000),
('S031', 'Bắt Trẻ Đồng Xanh', 'TL07', 'TG24', 27, 115000),
('S032', 'Hai Số Phận', 'TL07', 'TG42', 323, 210000),
('S033', 'Doraemon Tập 1', 'TL04', 'TG39', 440, 23100),
('S034', 'One Piece Tập 1', 'TL04', 'TG55', 100, 28000),
('S035', 'Naruto Tập 1', 'TL04', 'TG49', 100, 30000),
('S036', 'Dragon Ball Tập 1', 'TL04', 'TG40', 85, 32000),
('S037', 'Conan Tập 1', 'TL09', 'TG36', 75, 35000),
('S038', 'Tư Duy Ngược', 'TL05', 'TG16', 32, 99000),
('S039', 'Lược Sử Loài Người', 'TL10', 'TG18', 40, 185000),
('S040', 'Homo Deus', 'TL10', 'TG18', 28, 195000),
('S041', 'Đi Tìm Lẽ Sống', 'TL06', 'TG69', 33, 108000),
('S042', 'Đắc Nhân Tâm Cho Tuổi Trẻ', 'TL05', 'TG07', 48, 89000),
('S043', 'Không Gia Đình', 'TL07', 'TG46', 26, 102000),
('S044', 'Hoàng Tử Bé', 'TL04', 'TG44', 44, 76000),
('S045', 'Những Tấm Lòng Cao Cả', 'TL04', 'TG54', 29, 83000),
('S046', 'Bố Già', 'TL07', 'TG28', 37, 140000),
('S047', 'Inferno', 'TL09', 'TG06', 20, 155000),
('S048', 'Thiên Thần Và Ác Quỷ', 'TL09', 'TG06', 25, 148000),
('S049', 'Mãi Mãi Tuổi 20', 'TL07', 'TG47', 19, 72000),
('S050', 'Tôi Thấy Hoa Vàng Trên Cỏ Xanh', 'TL07', 'TG03', 51, 97000),
('S051', 'Người Nam Châm', 'TL05', 'TG50', 36, 86000),
('S052', 'Nhà Đầu Tư Thông Minh', 'TL02', 'TG51', 17, 210000),
('S053', 'Clean Code', 'TL03', 'TG35', 15, 250000),
('S057', 'AI Cho Người Mới Bắt Đầu', 'TL03', 'TG18', 28, 178000),
('S061', 'Tâm Lý Học Đám Đông', 'TL06', 'TG61', 27, 115000),
('S062', 'Sức Mạnh Tiềm Thức', 'TL06', 'TG60', 46, 92000),
('S063', 'Quẳng gánh lo đi và vui sống', 'TL05', 'TG07', 58, 97000),
('S064', '7 Thói Quen Hiệu Quả', 'TL05', 'TG21', 334, 132000),
('S065', 'Trên đường băng', 'TL05', 'TG17', 62, 79000),
('S066', 'Tuổi Trẻ Hoang Dại', 'TL07', 'TG66', 24, 68000),
('S067', 'Số Đỏ', 'TL07', 'TG58', 38, 81000),
('S068', 'Chí Phèo', 'TL07', 'TG33', 33, 73000),
('S069', 'Vợ Nhặt', 'TL07', 'TG68', 29, 69000),
('S070', 'Đời Thừa', 'TL07', 'TG33', 21, 65000),
('S071', 'Fairy Tail Tập 1', 'TL08', 'TG41', 77, 32000),
('S072', 'Bleach Tập 1', 'TL08', 'TG26', 64, 31000),
('S074', 'Demon Slayer', 'TL08', 'TG37', 369, 525000),
('S075', 'Jujutsu Kaisen', 'TL08', 'TG45', 66, 46000),
('S076', 'Spy x Family', 'TL08', 'TG59', 53, 39000),
('S077', 'Blue Lock', 'TL08', 'TG27', 47, 41000),
('S078', 'Chainsaw Man', 'TL08', 'TG31', 39, 43000),
('S080', 'Tokyo Revengers', 'TL08', 'TG65', 51, 47000),
('S085', 'Docker Và Kubernetes', 'TL03', 'TG38', 11, 280000),
('S087', 'Thiết Kế Hệ Thống', 'TL03', 'TG18', 14, 295000),
('S088', 'Thuật Toán Và Cấu Trúc Dữ Liệu', 'TL03', 'TG18', 25, 235000),
('S091', 'Những Cuộc Phiêu Lưu Của Tom Sawyer', 'TL04', 'TG53', 27, 85000),
('S092', 'Alice Ở Xứ Sở Thần Tiên', 'TL04', 'TG22', 35, 79000),
('S093', 'Peter Pan', 'TL04', 'TG56', 22, 74000),
('S094', 'Charlie Và Nhà Máy Chocolate', 'TL04', 'TG32', 31, 88000),
('S095', 'Heidi', 'TL04', 'TG43', 20, 76000),
('S096', 'Nhật Ký Anne Frank', 'TL10', 'TG52', 18, 118000),
('S097', 'Chiến Tranh Và Hòa Bình', 'TL10', 'TG34', 7, 350000),
('S098', 'Tam Quốc Diễn Nghĩa', 'TL10', 'TG62', 16, 220000),
('S099', 'Thủy Hử', 'TL10', 'TG64', 15, 215000),
('S100', 'Tây Du Ký', 'TL10', 'TG63', 321, 682500),
('S101', 'Lều Chõng', 'TL07', 'TG10', 197, 52500),
('S102', 'Kính Vạn Hoa', 'TL07', 'TG03', 350, 89250),
('S103', 'Cô Gái Đến Từ Hôm Qua', 'TL07', 'TG03', 299, 84000),
('S104', 'Hạ Đỏ', 'TL07', 'TG03', 400, 78750),
('S105', 'Lược Sử Thời Gian', 'TL02', 'TG02', 0, 0),
('S106', 'Vũ Trụ Trong Vỏ Hạt Dẻ', 'TL02', 'TG02', 0, 0),
('S107', 'Lỗ Đen', 'TL02', 'TG02', 0, 0),
('S108', 'Harry Potter và Phòng chứa Bí mật', 'TL08', 'TG04', 400, 525000),
('S109', 'Harry Potter và Tên tù nhân ngục Azkaban', 'TL08', 'TG04', 400, 525000),
('S110', 'Harry Potter và Chiếc cốc Lửa', 'TL08', 'TG04', 400, 525000),
('S111', 'Harry Potter và Hội Phượng hoàng', 'TL08', 'TG04', 400, 525000),
('S112', 'Harry Potter và Hoàng tử Lai', 'TL08', 'TG04', 400, 525000),
('S113', 'Harry Potter và Bảo bối Tử thần', 'TL08', 'TG04', 400, 525000),
('S114', 'Những chuyện kể của Beedle người hát rong', 'TL08', 'TG04', 0, 0),
('S115', 'Veronika quyết chết', 'TL07', 'TG05', 0, 0),
('S116', 'Việc làng', 'TL07', 'TG10', 0, 0),
('S117', 'Sống mòn', 'TL07', 'TG33', 0, 0),
('S118', 'Cuốn từ điển kỳ bí', 'TL04', 'TG39', 350, 73500),
('S119', 'Ninja loạn thị', 'TL04', 'TG71', 350, 25200),
('S120', 'Cậu bé quái vật', 'TL04', 'TG71', 350, 21000),
('S121', 'Làng', 'TL07', 'TG68', 400, 63000),
('S122', 'Con chó xấu xí', 'TL07', 'TG68', 300, 57750),
('S123', 'Giông Tố', 'TL07', 'TG58', 400, 84000),
('S124', 'Vỡ Đê', 'TL07', 'TG58', 0, 0),
('S125', 'Làm Đĩ', 'TL07', 'TG58', 400, 73500),
('S126', 'Cơm thầy cơm cô', 'TL11', 'TG58', 300, 47250),
('S127', 'Vẽ nhọ mặt tuồng', 'TL11', 'TG58', 0, 0),
('S128', 'Hành Trình Về Phương Đông', 'TL07', 'TG48', 350, 115500),
('S129', 'Bên Rặng Tuyết Sơn', 'TL07', 'TG48', 300, 94500),
('S130', 'Tôi Là Bêtô', 'TL04', 'TG03', 120, 85000),
('S131', 'Ngồi Khóc Trên Cây', 'TL07', 'TG03', 150, 95000),
('S132', 'Bảy Bước Tới Mùa Hè', 'TL07', 'TG03', 130, 90000),
('S133', 'Chúc Một Ngày Tốt Lành', 'TL04', 'TG03', 140, 88000),
('S134', 'Có Hai Con Mèo Ngồi Bên Cửa Sổ', 'TL04', 'TG03', 110, 82000),
('S135', 'Cảm Ơn Người Lớn', 'TL07', 'TG03', 100, 105000),
('S136', 'Út Quyên Và Tôi', 'TL07', 'TG03', 90, 78000),
('S137', 'Bong Bóng Lên Trời', 'TL07', 'TG03', 95, 86000),
('S138', 'Đi Qua Hoa Cúc', 'TL07', 'TG03', 85, 82000),
('S139', 'Nữ Sinh', 'TL07', 'TG03', 80, 76000),
('S140', 'The Ickabog', 'TL08', 'TG04', 70, 160000),
('S141', 'The Casual Vacancy', 'TL07', 'TG04', 45, 190000),
('S142', 'The Christmas Pig', 'TL04', 'TG04', 60, 175000),
('S143', 'Fantastic Beasts and Where to Find Them', 'TL08', 'TG04', 55, 165000),
('S144', 'Brida', 'TL07', 'TG05', 65, 115000),
('S145', 'Hippie', 'TL07', 'TG05', 50, 125000),
('S146', 'The Pilgrimage', 'TL07', 'TG05', 58, 120000),
('S147', 'The Valkyries', 'TL07', 'TG05', 54, 118000),
('S148', 'The Zahir', 'TL07', 'TG05', 62, 135000),
('S149', 'Eleven Minutes', 'TL07', 'TG05', 57, 132000),
('S150', 'Aleph', 'TL07', 'TG05', 49, 128000),
('S151', 'The Devil and Miss Prym', 'TL07', 'TG05', 52, 118000),
('S152', 'By the River Piedra I Sat Down and Wept', 'TL07', 'TG05', 46, 125000),
('S153', 'The Fifth Mountain', 'TL07', 'TG05', 48, 126000),
('S154', 'Nguồn Cội', 'TL09', 'TG06', 70, 168000),
('S155', 'Biểu Tượng Thất Truyền', 'TL09', 'TG06', 75, 165000),
('S156', 'Pháo Đài Số', 'TL09', 'TG06', 68, 145000),
('S157', 'Điểm Dối Lừa', 'TL09', 'TG06', 66, 150000),
('S158', 'Wild Symphony', 'TL04', 'TG06', 40, 140000),
('S159', 'How to Stop Worrying and Start Living', 'TL05', 'TG07', 95, 115000),
('S160', 'The Quick and Easy Way to Effective Speaking', 'TL05', 'TG07', 55, 108000),
('S161', 'How to Enjoy Your Life and Your Job', 'TL05', 'TG07', 60, 99000),
('S162', 'The Shining', 'TL09', 'TG08', 60, 170000),
('S163', 'Carrie', 'TL09', 'TG08', 55, 135000),
('S164', 'Misery', 'TL09', 'TG08', 50, 150000),
('S165', 'Pet Sematary', 'TL09', 'TG08', 48, 158000),
('S166', 'The Stand', 'TL09', 'TG08', 35, 230000),
('S167', 'The Green Mile', 'TL07', 'TG08', 52, 160000),
('S168', 'Doctor Sleep', 'TL09', 'TG08', 45, 175000),
('S169', 'Salem\'s Lot', 'TL09', 'TG08', 42, 165000),
('S170', 'Cujo', 'TL09', 'TG08', 40, 145000),
('S171', 'Kafka Bên Bờ Biển', 'TL07', 'TG09', 70, 158000),
('S172', 'Biên Niên Ký Chim Vặn Dây Cót', 'TL07', 'TG09', 65, 185000),
('S173', '1Q84', 'TL07', 'TG09', 45, 260000),
('S174', 'Tazaki Tsukuru Không Màu Và Những Năm Tháng Hành Hương', 'TL07', 'TG09', 55, 145000),
('S175', 'Người Tình Sputnik', 'TL07', 'TG09', 58, 125000),
('S176', 'Xứ Sở Diệu Kỳ Tàn Bạo Và Chốn Tận Cùng Thế Giới', 'TL07', 'TG09', 50, 175000),
('S177', 'Phía Nam Biên Giới, Phía Tây Mặt Trời', 'TL07', 'TG09', 56, 132000),
('S178', 'Nhảy Nhảy Nhảy', 'TL07', 'TG09', 48, 150000),
('S179', 'Vụ Án Mạng Ông Roger Ackroyd', 'TL09', 'TG13', 72, 120000),
('S180', 'Án Mạng Trên Sông Nile', 'TL09', 'TG13', 76, 125000),
('S181', 'Và Rồi Chẳng Còn Ai', 'TL09', 'TG13', 65, 118000),
('S182', 'Chuỗi Án Mạng ABC', 'TL09', 'TG13', 68, 116000),
('S183', 'Án Mạng Ở Mesopotamia', 'TL09', 'TG13', 58, 112000),
('S184', 'Tội Ác Dưới Ánh Mặt Trời', 'TL09', 'TG13', 60, 115000),
('S185', 'Ngôi Nhà Quái Dị', 'TL09', 'TG13', 54, 110000),
('S186', 'Bức Màn', 'TL09', 'TG13', 50, 108000),
('S187', 'Năm Chú Heo Con', 'TL09', 'TG13', 52, 112000),
('S188', 'Vụ Án Bí Ẩn Ở Styles', 'TL09', 'TG13', 57, 115000),
('S189', 'Cuộc Điều Tra Màu Đỏ', 'TL09', 'TG14', 45, 105000),
('S190', 'Dấu Bộ Tứ', 'TL09', 'TG14', 48, 110000),
('S191', 'Con Chó Săn Của Dòng Họ Baskerville', 'TL09', 'TG14', 55, 125000),
('S192', 'Thung Lũng Kinh Hoàng', 'TL09', 'TG14', 50, 118000),
('S193', 'Những Cuộc Phiêu Lưu Của Sherlock Holmes', 'TL09', 'TG14', 65, 135000),
('S194', 'Hồi Ức Của Sherlock Holmes', 'TL09', 'TG14', 60, 130000),
('S195', 'Những Câu Chuyện Trở Về Của Sherlock Holmes', 'TL09', 'TG14', 58, 132000),
('S196', 'Cung Đàn Sau Cuối', 'TL09', 'TG14', 42, 115000),
('S197', 'Hồ Sơ Vụ Án Sherlock Holmes', 'TL09', 'TG14', 46, 120000),
('S198', '21 Bài Học Cho Thế Kỷ 21', 'TL10', 'TG18', 80, 190000),
('S199', 'Nexus', 'TL10', 'TG18', 60, 245000),
('S200', 'Unstoppable Us', 'TL10', 'TG18', 55, 175000),
('S201', 'The Sicilian', 'TL07', 'TG28', 40, 155000),
('S202', 'Omerta', 'TL07', 'TG28', 38, 150000),
('S203', 'The Last Don', 'TL07', 'TG28', 36, 160000),
('S204', 'Fools Die', 'TL07', 'TG28', 34, 158000),
('S205', 'Một Bữa No', 'TL07', 'TG33', 60, 58000),
('S206', 'Trăng Sáng', 'TL07', 'TG33', 55, 62000),
('S207', 'Đôi Mắt', 'TL07', 'TG33', 58, 65000),
('S208', 'Mua Nhà', 'TL07', 'TG33', 50, 60000),
('S209', 'Lang Rận', 'TL07', 'TG33', 52, 59000),
('S210', 'Tư Cách Mõ', 'TL07', 'TG33', 48, 58000),
('S211', 'Một Đám Cưới', 'TL07', 'TG33', 46, 60000),
('S212', 'Clean Architecture', 'TL03', 'TG35', 50, 280000),
('S213', 'The Clean Coder', 'TL03', 'TG35', 45, 260000),
('S214', 'Agile Software Development, Principles, Patterns, and Practices', 'TL03', 'TG35', 35, 320000),
('S215', 'Clean Agile', 'TL03', 'TG35', 38, 255000),
('S216', 'Conan Tập 2', 'TL09', 'TG36', 100, 35000),
('S217', 'Conan Tập 3', 'TL09', 'TG36', 100, 35000),
('S218', 'Doraemon Tập 2', 'TL04', 'TG39', 180, 25000),
('S219', 'Doraemon Tập 3', 'TL04', 'TG39', 180, 25000),
('S220', 'One Piece Tập 2', 'TL04', 'TG55', 159, 30000),
('S221', 'One Piece Tập 3', 'TL04', 'TG55', 160, 30000),
('S222', 'Kỹ Nghệ Lấy Tây', 'TL11', 'TG58', 70, 65000),
('S223', 'Dứt Tình', 'TL07', 'TG58', 60, 72000),
('S224', 'Trúng Số Độc Đắc', 'TL07', 'TG58', 65, 70000),
('S225', 'Nên Vợ Nên Chồng', 'TL07', 'TG68', 70, 62000),
('S226', 'Ông Lão Hàng Xóm', 'TL07', 'TG68', 55, 58000),
('S227', 'Tập Án Cái Đình', 'TL11', 'TG10', 50, 62000),
('S228', 'The Prince and the Pauper', 'TL04', 'TG53', 45, 65000),
('S229', 'Matilda', 'TL04', 'TG32', 60, 90000);

-- --------------------------------------------------------

--
-- Table structure for table `tacgia`
--

CREATE TABLE `tacgia` (
  `MaTacGia` varchar(20) NOT NULL,
  `TenTacGia` varchar(100) DEFAULT NULL,
  `NamSinh` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tacgia`
--

INSERT INTO `tacgia` (`MaTacGia`, `TenTacGia`, `NamSinh`) VALUES
('TG02', 'Stephen Hawking', '1942-01-08 00:00:00'),
('TG03', 'Nguyễn Nhật Ánh', NULL),
('TG04', 'J.K Rowling', '1965-07-31 00:00:00'),
('TG05', 'Paulo Coelho', '1947-08-24 00:00:00'),
('TG06', 'Dan Brown', '1964-06-22 00:00:00'),
('TG07', 'Dale Carnegie', '1888-11-24 00:00:00'),
('TG08', 'Stephen King', '1947-09-21 00:00:00'),
('TG09', 'Haruki Murakami', '1949-01-12 00:00:00'),
('TG10', 'Ngô Tất Tố', NULL),
('TG11', 'Victor Hugo', NULL),
('TG12', 'George Orwell', NULL),
('TG13', 'Agatha Christie', '1890-09-15 00:00:00'),
('TG14', 'Arthur Conan Doyle', NULL),
('TG15', 'Osho', NULL),
('TG16', 'Robin Sharma', '1964-06-16 00:00:00'),
('TG17', 'Tony Buổi Sáng', NULL),
('TG18', 'Yuval Noah Harari', '1976-02-24 00:00:00'),
('TG19', 'Nguyễn Du', NULL),
('TG20', 'Xuân Diệu', NULL),
('TG21', 'Stephen R. Covey', '1932-10-24 00:00:00'),
('TG22', 'Lewis Carroll', '1832-01-27 00:00:00'),
('TG23', 'James Clear', '1986-01-22 00:00:00'),
('TG24', 'J. D. Salinger ', '1919-01-01 00:00:00'),
('TG25', 'T. Harv Eker', '1954-06-10 00:00:00'),
('TG26', 'Tite Kubo', '1977-06-26 00:00:00'),
('TG27', 'Kaneshiro Muneyuki', '1987-12-09 00:00:00'),
('TG28', 'Mario Puzo', '1920-10-15 00:00:00'),
('TG29', 'José Mauro de Vasconcelos', '1920-02-26 00:00:00'),
('TG30', 'Robert T. Kiyosaki', '1947-04-08 00:00:00'),
('TG31', 'Fujimoto Tatsuki', '1992-10-10 00:00:00'),
('TG32', 'Roald Dahl', '1916-09-13 00:00:00'),
('TG33', 'Nam Cao', '1917-10-29 00:00:00'),
('TG34', 'Lev Nikolayevich Tolstoy', '1828-09-09 00:00:00'),
('TG35', 'Robert C. Martin', '1952-12-05 00:00:00'),
('TG36', 'Gosho Aoyama', '1963-06-21 00:00:00'),
('TG37', 'Koyoharu Gotōge', '1989-05-05 00:00:00'),
('TG38', 'Solomon Hykes', '1983-01-01 00:00:00'),
('TG39', 'Fujiko F. Fujio', '1933-12-01 00:00:00'),
('TG40', 'Akira Toriyama', '1955-04-05 00:00:00'),
('TG41', 'Hiro Mashima', '1977-05-03 00:00:00'),
('TG42', 'Jeffrey Archer', '1940-04-15 00:00:00'),
('TG43', 'Johanna Spyri', '1827-06-12 00:00:00'),
('TG44', 'Antoine de Saint-Exupéry', '1900-06-29 00:00:00'),
('TG45', 'Gege Akutami', '1992-02-26 00:00:00'),
('TG46', 'Hector Malot', '1830-05-20 00:00:00'),
('TG47', 'Nguyễn Văn Thạc', '1952-10-14 00:00:00'),
('TG48', 'Nguyên Phong', '1950-01-01 00:00:00'),
('TG49', 'Kishimoto Masashi', '1974-11-08 00:00:00'),
('TG50', 'Jack Canfield', '1944-08-19 00:00:00'),
('TG51', 'Benjamin Graham', '1894-05-09 00:00:00'),
('TG52', 'Anne Frank', '1929-06-12 00:00:00'),
('TG53', 'Mark Twain', '1835-11-30 00:00:00'),
('TG54', 'Edmondo De Amicis', '1846-10-21 00:00:00'),
('TG55', 'Eiichiro Oda', '1975-01-01 00:00:00'),
('TG56', 'J. M. Barrie', '1860-05-09 00:00:00'),
('TG57', 'Jane Austen', '1775-12-16 00:00:00'),
('TG58', 'Vũ Trọng Phụng', '1912-10-20 00:00:00'),
('TG59', 'Endo Tatsuya', '1980-07-23 00:00:00'),
('TG60', 'Joseph Murphy', '1898-05-20 00:00:00'),
('TG61', 'Gustave Le Bo', '1841-05-07 00:00:00'),
('TG62', 'La Quán Trung', '1330-01-01 00:00:00'),
('TG63', 'Ngô Thừa Ân', '1500-01-01 00:00:00'),
('TG64', 'Thi Nại Am', '1296-01-01 00:00:00'),
('TG65', 'Ken Wakui', '1979-07-13 00:00:00'),
('TG66', 'Nguyễn Ngọc Thạch', '1987-01-02 00:00:00'),
('TG67', 'Rosie Nguyễn', '1987-01-01 00:00:00'),
('TG68', 'Kim Lân', '1920-08-01 00:00:00'),
('TG69', 'Viktor E. Frankl', '1905-03-26 00:00:00'),
('TG70', 'Emily Brontë', '1818-07-30 00:00:00'),
('TG71', 'Fujiko A. Fujio', '1934-03-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `thamso`
--

CREATE TABLE `thamso` (
  `SoSachTonKhoToiThieu` int(11) DEFAULT NULL,
  `SoSachNhapToiThieu` int(11) DEFAULT NULL,
  `TiLeDonGiaBan` int(11) DEFAULT NULL,
  `SoTienNoToiDa` int(11) DEFAULT NULL,
  `SoLuongTonToiThieu` int(11) DEFAULT NULL,
  `KiemTraTienThu` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thamso`
--

INSERT INTO `thamso` (`SoSachTonKhoToiThieu`, `SoSachNhapToiThieu`, `TiLeDonGiaBan`, `SoTienNoToiDa`, `SoLuongTonToiThieu`, `KiemTraTienThu`) VALUES
(300, 150, 105, 1000000, 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `theloai`
--

CREATE TABLE `theloai` (
  `MaTheLoai` varchar(20) NOT NULL,
  `TenTheLoai` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theloai`
--

INSERT INTO `theloai` (`MaTheLoai`, `TenTheLoai`) VALUES
('TL02', 'Khoa học'),
('TL03', 'Công nghệ'),
('TL04', 'Thiếu nhi'),
('TL05', 'Kỹ năng sống'),
('TL06', 'Tâm lý'),
('TL07', 'Tiểu thuyết'),
('TL08', 'Fantasy'),
('TL09', 'Trinh thám'),
('TL10', 'Lịch sử'),
('TL11', 'Phóng sự');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chucnang`
--
ALTER TABLE `chucnang`
  ADD PRIMARY KEY (`MaChucNang`);

--
-- Indexes for table `ct_hoadon`
--
ALTER TABLE `ct_hoadon`
  ADD PRIMARY KEY (`MaHD`,`MaSach`),
  ADD KEY `MaSach` (`MaSach`);

--
-- Indexes for table `ct_phieudoitra`
--
ALTER TABLE `ct_phieudoitra`
  ADD PRIMARY KEY (`MaPhieuDoiTra`,`MaSach`),
  ADD KEY `MaSach` (`MaSach`);

--
-- Indexes for table `ct_phieukiemkho`
--
ALTER TABLE `ct_phieukiemkho`
  ADD PRIMARY KEY (`MaPhieu`,`MaSach`),
  ADD KEY `MaSach` (`MaSach`);

--
-- Indexes for table `ct_phieunhap`
--
ALTER TABLE `ct_phieunhap`
  ADD PRIMARY KEY (`MaPhieuNhap`,`MaSach`),
  ADD KEY `MaSach` (`MaSach`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHD`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaNguoiDung`),
  ADD KEY `MaNhomNguoiDung` (`MaNhomNguoiDung`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Indexes for table `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`);

--
-- Indexes for table `nhomnguoidung`
--
ALTER TABLE `nhomnguoidung`
  ADD PRIMARY KEY (`MaNhomNguoiDung`);

--
-- Indexes for table `phanquyen`
--
ALTER TABLE `phanquyen`
  ADD PRIMARY KEY (`MaNhomNguoiDung`,`MaChucNang`),
  ADD KEY `MaChucNang` (`MaChucNang`);

--
-- Indexes for table `phieuchi`
--
ALTER TABLE `phieuchi`
  ADD PRIMARY KEY (`MaPhieuChi`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Indexes for table `phieudoitra`
--
ALTER TABLE `phieudoitra`
  ADD PRIMARY KEY (`MaPhieuDoiTra`),
  ADD KEY `MaKH` (`MaKH`);

--
-- Indexes for table `phieukiemkho`
--
ALTER TABLE `phieukiemkho`
  ADD PRIMARY KEY (`MaPhieu`);

--
-- Indexes for table `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`MaPhieuNhap`),
  ADD KEY `MaNCC` (`MaNCC`);

--
-- Indexes for table `phieuthu`
--
ALTER TABLE `phieuthu`
  ADD PRIMARY KEY (`MaPhieuThu`),
  ADD KEY `MaHD` (`MaHD`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Indexes for table `sach`
--
ALTER TABLE `sach`
  ADD PRIMARY KEY (`MaSach`),
  ADD KEY `MaTheLoai` (`MaTheLoai`),
  ADD KEY `MaTacGia` (`MaTacGia`);

--
-- Indexes for table `tacgia`
--
ALTER TABLE `tacgia`
  ADD PRIMARY KEY (`MaTacGia`);

--
-- Indexes for table `theloai`
--
ALTER TABLE `theloai`
  ADD PRIMARY KEY (`MaTheLoai`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ct_hoadon`
--
ALTER TABLE `ct_hoadon`
  ADD CONSTRAINT `ct_hoadon_ibfk_1` FOREIGN KEY (`MaHD`) REFERENCES `hoadon` (`MaHD`),
  ADD CONSTRAINT `ct_hoadon_ibfk_2` FOREIGN KEY (`MaSach`) REFERENCES `sach` (`MaSach`);

--
-- Constraints for table `ct_phieudoitra`
--
ALTER TABLE `ct_phieudoitra`
  ADD CONSTRAINT `ct_phieudoitra_ibfk_1` FOREIGN KEY (`MaPhieuDoiTra`) REFERENCES `phieudoitra` (`MaPhieuDoiTra`),
  ADD CONSTRAINT `ct_phieudoitra_ibfk_2` FOREIGN KEY (`MaSach`) REFERENCES `sach` (`MaSach`);

--
-- Constraints for table `ct_phieukiemkho`
--
ALTER TABLE `ct_phieukiemkho`
  ADD CONSTRAINT `ct_phieukiemkho_ibfk_1` FOREIGN KEY (`MaPhieu`) REFERENCES `phieukiemkho` (`MaPhieu`),
  ADD CONSTRAINT `ct_phieukiemkho_ibfk_2` FOREIGN KEY (`MaSach`) REFERENCES `sach` (`MaSach`);

--
-- Constraints for table `ct_phieunhap`
--
ALTER TABLE `ct_phieunhap`
  ADD CONSTRAINT `ct_phieunhap_ibfk_1` FOREIGN KEY (`MaPhieuNhap`) REFERENCES `phieunhap` (`MaPhieuNhap`),
  ADD CONSTRAINT `ct_phieunhap_ibfk_2` FOREIGN KEY (`MaSach`) REFERENCES `sach` (`MaSach`);

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Constraints for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `nguoidung_ibfk_1` FOREIGN KEY (`MaNhomNguoiDung`) REFERENCES `nhomnguoidung` (`MaNhomNguoiDung`),
  ADD CONSTRAINT `nguoidung_ibfk_2` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Constraints for table `phanquyen`
--
ALTER TABLE `phanquyen`
  ADD CONSTRAINT `phanquyen_ibfk_1` FOREIGN KEY (`MaNhomNguoiDung`) REFERENCES `nhomnguoidung` (`MaNhomNguoiDung`),
  ADD CONSTRAINT `phanquyen_ibfk_2` FOREIGN KEY (`MaChucNang`) REFERENCES `chucnang` (`MaChucNang`);

--
-- Constraints for table `phieuchi`
--
ALTER TABLE `phieuchi`
  ADD CONSTRAINT `phieuchi_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Constraints for table `phieudoitra`
--
ALTER TABLE `phieudoitra`
  ADD CONSTRAINT `phieudoitra_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Constraints for table `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `phieunhap_ibfk_1` FOREIGN KEY (`MaNCC`) REFERENCES `nhacungcap` (`MaNCC`);

--
-- Constraints for table `phieuthu`
--
ALTER TABLE `phieuthu`
  ADD CONSTRAINT `phieuthu_ibfk_1` FOREIGN KEY (`MaHD`) REFERENCES `hoadon` (`MaHD`),
  ADD CONSTRAINT `phieuthu_ibfk_2` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`),
  ADD CONSTRAINT `phieuthu_ibfk_3` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Constraints for table `sach`
--
ALTER TABLE `sach`
  ADD CONSTRAINT `sach_ibfk_1` FOREIGN KEY (`MaTheLoai`) REFERENCES `theloai` (`MaTheLoai`),
  ADD CONSTRAINT `sach_ibfk_2` FOREIGN KEY (`MaTacGia`) REFERENCES `tacgia` (`MaTacGia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
