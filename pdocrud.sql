-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2022 at 06:11 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

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
(8, 'Basketball Court', 0, '2022-10-24 07:59:13', '16665983531776356757635645d1b14d4');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `ptitle` varchar(150) NOT NULL,
  `pcontent` varchar(10000) NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Photo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `ptitle`, `pcontent`, `PostingDate`, `Photo`) VALUES
(89, 'Free Badminton Class', '   Para sa lahat ng nais makiisa sa libreng badminton class ay maaring mag fill - out sa form na ito: \r\n\r\nhttps://forms.gle/Kq8gQ8U2CHqHHJJt9\r\n\r\nIto ay bukas sa lahat ng kabataan na ang edad ay walong taong gulang hanggang labing-siyam taong gulang. \r\n\r\n', '2022-10-25 10:12:02', '16666927228774661126357b6726e28e'),
(91, 'SSS on Wheels', ' Lorem Ipsum', '2022-10-25 10:11:05', '166669266511688611376357b6397f8cf'),
(93, 'Garbage Collection', '  lorem ipsum amet dolor', '2022-10-25 10:10:11', '166669261116848479946357b603d790b');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `fullname` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`) VALUES
(1, 'user', 'user', 'Lebron James');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblamenities`
--
ALTER TABLE `tblamenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
