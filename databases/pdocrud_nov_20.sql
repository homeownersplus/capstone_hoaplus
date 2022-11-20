-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2022 at 01:32 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pdocrud`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(80) NOT NULL,
  `position` varchar(60) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `fullname`, `email`, `position`, `password`) VALUES
(7, 'Secretary_Vilma', 'Vilma Sotero', 'vilmasotero@gmail.com', 'Secretary', 'HOASecretary00!'),
(8, 'Treasurer_Anna', 'Anna Nga', 'annanga@gmail.com', 'Treasurer', 'HOATreasurer00!'),
(9, 'HOAStaff_Teena', 'Teena Lee', 'teenalee@gmail.com', 'Treasurer', 'HOAStaff00!'),
(11, 'HOAStaff_Veena', 'Veena Leeta', 'sinoko@yandex.com', 'HOA Staff', 'HOAStaff002!'),
(12, 'Pres_Aikka', 'Aikka Sy Bata', 'aikasybata@gmail.com', 'President', 'Preseikka06!!'),
(13, 'Secretary_Malliey', 'Mallie Xiea', 'malliexiea@gmail.com', 'Secretary', 'Secretarymallie'),
(14, 'Secretary_Sunroof', 'Sun Roof', 'tamana@yandex.com', 'Secretary', 'secrekeah00A!'),
(15, 'TataMc', 'Tata McRae', 'sherietionco@gmail.com', 'Treasurer', 'tataMcrae00!!'),
(16, 'ChescaLeel', 'Chesca Lee', 'jhasjaneestacio@gmail.com', 'Treasurer', 'jhasEst2317!!');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `amenity_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '1 = Cancelled, 2 = Pending, 3 = Paid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `member_id`, `amenity_id`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 1, 9, '2022-11-19 13:00:00', '2022-11-19 15:00:00', 2, '2022-11-18 05:42:12'),
(3, 1, 7, '2022-11-19 05:26:00', '2022-11-19 18:27:00', 2, '2022-11-18 08:25:43'),
(4, 1, 6, '2022-11-22 10:00:00', '2022-11-22 14:00:00', 2, '2022-11-18 08:26:28'),
(5, 2, 8, '2022-11-30 08:30:00', '2022-11-30 11:30:00', 2, '2022-11-18 10:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `admin_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `username`, `password`, `admin_name`) VALUES
(1, 'admin', 'admin', 'Andres P. Jario');

-- --------------------------------------------------------

--
-- Table structure for table `tblamenities`
--

CREATE TABLE `tblamenities` (
  `id` int(11) NOT NULL,
  `amename` varchar(150) NOT NULL,
  `amendesc` int(11) NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Photo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblamenities`
--

INSERT INTO `tblamenities` (`id`, `amename`, `amendesc`, `PostingDate`, `Photo`) VALUES
(5, 'Paw Park', 0, '2022-10-24 05:39:48', '166658998853860494463562524a1e4a'),
(6, 'Swimming Pool', 0, '2022-10-24 07:53:25', '1666598005211761023563564475a27b5'),
(7, 'Event\'s Place', 0, '2022-10-24 07:57:35', '16665982557237938546356456f69a5a'),
(8, 'Basketball Court', 0, '2022-10-24 07:59:13', '16665983531776356757635645d1b14d4'),
(9, 'Adult Pool', 0, '2022-11-03 14:25:03', '16674855037689296776363cf3fbe436');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `ptitle` varchar(150) NOT NULL,
  `pcontent` varchar(10000) NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Photo` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `ptitle`, `pcontent`, `PostingDate`, `Photo`, `status`) VALUES
(89, 'Free Badminton Class', '   Para sa lahat ng nais makiisa sa libreng badminton class ay maaring mag fill - out sa form na ito: \r\n\r\nhttps://forms.gle/Kq8gQ8U2CHqHHJJt9\r\n\r\nIto ay bukas sa lahat ng kabataan na ang edad ay walong taong gulang hanggang labing-siyam taong gulang. \r\n\r\n', '2022-11-03 14:20:37', '16666927228774661126357b6726e28e', 0),
(91, 'SSS on Wheelsss 101', '      Lorem Ipsum', '2022-11-03 16:51:19', '16674911373582331546363e5413c514', 0),
(93, 'Garbage Collection', '  lorem ipsum amet dolor', '2022-11-03 14:20:55', '166669261116848479946357b603d790b', 0),
(100, 'Swab Cab ni Leni', ' cgdfgryt', '2022-11-03 17:16:36', '166749579620436768666363f7748ab35', 0),
(102, 'Adult Pool Now Open! G na!', '  frtytyujtyuj', '2022-11-04 15:34:34', '1667576019179019347636530d3b99bd', 0),
(103, 'Free Coffee on World Coffee Day!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Mi sit amet mauris commodo quis imperdiet massa tincidunt nunc. At consectetur lorem donec massa sapien faucibus et molestie. Quis varius quam quisque id diam vel. Lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci. Vel risus commodo viverra maecenas accumsan lacus vel. Placerat duis ultricies lacus sed turpis tincidunt id aliquet risus. ', '2022-11-05 02:14:57', '16675767512035309332636533af12b1d', 0),
(104, 'Poste', 'chambe chambbe', '2022-11-11 04:50:39', '16681317261978518306636dab8eb275d', 1),
(105, 'Valid Post', 'asdsadadadadadad', '2022-11-13 14:03:16', '166834819614135004226370f9242b499', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `phase_lot_block` varchar(500) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `fullname` varchar(250) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `contact_number`, `phase_lot_block`, `barangay`, `fullname`, `avatar`, `created_at`) VALUES
(1, 'user', 'user', 'user@example.com', '87000', 'Phase 1, Block 2, Lot 3', '143', 'Lebron James', '12483690996376317d9f4f66376317d9f4f9.jpg', '2022-11-17 09:39:05'),
(2, 'user2', 'user2', 'user2@example.com', '870002', 'Phase 4, Block 5, Lot 6', '341', 'Hanamichi Sakuragi', NULL, '2022-11-17 09:39:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblamenities`
--
ALTER TABLE `tblamenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblamenities`
--
ALTER TABLE `tblamenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
