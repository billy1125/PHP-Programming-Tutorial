-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-06-10 05:22:55
-- 伺服器版本： 10.4.24-MariaDB
-- PHP 版本： 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `shopping`
--

-- --------------------------------------------------------

--
-- 資料表結構 `items`
--

CREATE TABLE `items` (
  `id` int(5) NOT NULL COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT '商品名稱',
  `price` int(10) NOT NULL COMMENT '價格',
  `detail` varchar(200) NOT NULL COMMENT '商品說明',
  `image` varchar(20) NOT NULL COMMENT '圖片檔名稱',
  `kind` int(5) NOT NULL COMMENT '類別',
  `del` int(1) NOT NULL COMMENT '是否刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `detail`, `image`, `kind`, `del`) VALUES
(1, '14吋AMD薄邊框電競筆電Zephyrus GA401QM-0032E5900HS 日蝕灰(有燈版)', 50000, '▃▅★ROG Zephyrus G14。強勢來襲★▅▃\r\n★全新顯卡視覺享受 RTX3060獨顯6G效能\r\n★超屌效能 搭載2021新世代 AMD Ryzen 9-5900HS 處理器\r\n★超狂容量 1TB M.2 NVMe™ PCIe® 3.0 SSD\r\n★14吋WQHD 120Hz IPS大屏佔比\r\n★Pantone®專業色彩認證 / PD3.0充電技術\r\n★輕薄美型 / 上蓋ROG動態編成L', 'nb_1.jpg', 1, 0),
(2, '《Win11 必買機種》高顏質+高擴充+高性價比 DELL Inspiron 15-3511-R16', 60000, '《Win11 必買機種》高顏質+高擴充+高性價比\r\nDELL Inspiron 15-3511-R1608STW11 銀河星跡\r\n11代 CPU ∥ 支援SSD+HDD ∥ 微邊框 ∥ 輕薄1.73kg\r\n11代i5★快速512G★高擴充比　新機上市\r\n\r\n《絕佳性能》\r\n👉第11代Intel® Core™ i5-1135G7\r\n👉Intel® Iris® Xe 顯卡\r\n👉512GB M.2 PC', 'nb_2.jpg', 1, 0),
(3, 'MacBook Pro13 灰色 256GB / 8GB 統一記憶體 / Apple M1 晶片 /', 55000, 'MacBook Pro13 灰色\r\n256GB / 8GB 統一記憶體 / Apple M1 晶片 / 8 核心 CPU / 8 核心 GPU / 16 核心神經網路\r\n\r\n商品規格\r\n• Apple M1 晶片配備 8 核心 CPU、8 核心 GPU\r\n• 16 核心神經網路引擎\r\n• 8GB 統一記憶體\r\n• 256GB SSD 儲存裝置\r\n• 具備原彩顯示的 13 吋 Retina 顯示器\r', 'nb_3.webp', 1, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL COMMENT '資料表users的主鍵id',
  `name` varchar(20) NOT NULL COMMENT '下單人姓名',
  `telephone` varchar(20) NOT NULL COMMENT '下單人電話',
  `email` varchar(50) NOT NULL COMMENT '下單人電子郵件',
  `address` varchar(100) NOT NULL COMMENT '下單人地址',
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '訂單日期時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `telephone`, `email`, `address`, `datetime`) VALUES
(4, 1, '車太炫', 'd', 'd', 'd', '2022-05-26 12:08:01'),
(5, 1, '車太炫', 'd', 'd', 'd', '2022-05-26 12:08:43'),
(6, 1, '車太炫', 'er', 'er', 'ee', '2022-05-26 12:13:09'),
(7, 6, '陳時鐘', 'tes', 'dds', 'dsdsd', '2022-06-10 03:04:55');

-- --------------------------------------------------------

--
-- 資料表結構 `orders_detail`
--

CREATE TABLE `orders_detail` (
  `id` int(5) NOT NULL,
  `order_id` int(5) NOT NULL COMMENT 'orders的主鍵id',
  `item_id` int(5) NOT NULL COMMENT 'items的主鍵id',
  `numbers` int(2) NOT NULL COMMENT '訂單的商品數量',
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '建立的日期時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `orders_detail`
--

INSERT INTO `orders_detail` (`id`, `order_id`, `item_id`, `numbers`, `datetime`) VALUES
(2, 4, 1, 1, '2022-05-26 12:08:01'),
(3, 5, 2, 30, '2022-06-10 03:02:13'),
(4, 6, 3, 3, '2022-06-10 03:02:39'),
(5, 6, 2, 2, '2022-06-10 03:02:39'),
(6, 7, 1, 3, '2022-06-10 03:04:55');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `account` varchar(10) NOT NULL COMMENT '帳號',
  `password` varchar(10) NOT NULL COMMENT '密碼',
  `name` varchar(50) NOT NULL COMMENT '會員姓名',
  `admin` varchar(1) NOT NULL COMMENT '是不是管理員'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `account`, `password`, `name`, `admin`) VALUES
(1, 'abc', '123', '車太炫', 'Y'),
(6, 'def', '456', '陳時鐘', ''),
(7, 'asd', 'asd', 'test', '');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `items`
--
ALTER TABLE `items`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
