-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 26, 2024 lúc 03:04 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `student`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `userinformation`
--

CREATE TABLE `userinformation` (
  `ID` int(11) NOT NULL,
  `Ten` varchar(255) NOT NULL,
  `NgaySinh` date DEFAULT NULL,
  `GioiTinh` enum('Nam','Nữ','Khác') DEFAULT NULL,
  `ChieuCao` float DEFAULT NULL,
  `CanNang` float DEFAULT NULL,
  `QueQuan` varchar(255) DEFAULT NULL,
  `DiemThi` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `userinformation`
--

INSERT INTO `userinformation` (`ID`, `Ten`, `NgaySinh`, `GioiTinh`, `ChieuCao`, `CanNang`, `QueQuan`, `DiemThi`) VALUES
(1, 'Nguyen Van A', '2000-01-15', 'Nam', 175.5, 70.2, 'Hanoi', 8.5),
(2, 'Tran Thi B', '1998-03-20', 'Nữ', 160, 55, 'Da Nang', 7.8),
(3, 'Le Van C', '1995-09-10', 'Nam', 180, 80, 'Ho Chi Minh City', 9.2),
(4, 'Pham Thi D', '2002-05-05', 'Nữ', 165, 58.5, 'Hue', 8),
(5, 'Do Van E', '1997-11-28', 'Nam', 170, 68, 'Can Tho', 7),
(6, 'Vo Thi F', '2001-07-12', 'Nữ', 155, 50, 'Vinh', 8.7),
(7, 'Ho Van G', '1994-12-03', 'Nam', 178, 75, 'Nha Trang', 8.9),
(8, 'Nguyen Thi H', '1999-02-18', 'Nữ', 162, 56, 'Quang Ninh', 7.5),
(9, 'Tran Van I', '1996-06-22', 'Nam', 172, 72.5, 'Phu Yen', 8.3),
(10, 'Le Thi K', '2003-08-05', 'Nữ', 158, 53, 'Bac Lieu', 7.2),
(11, 'Tran Vu Phuong Uyen', '2002-01-28', 'Nữ', 150, 55, 'TPHCM', 7.2);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `userinformation`
--
ALTER TABLE `userinformation`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `userinformation`
--
ALTER TABLE `userinformation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
