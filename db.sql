-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2018 at 10:04 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `account`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `date` int(20) NOT NULL,
  `mtype` int(11) NOT NULL DEFAULT '0',
  `sender` bigint(20) NOT NULL,
  `receipt` bigint(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` longtext NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `date`, `mtype`, `sender`, `receipt`, `title`, `message`, `status`) VALUES
(1, 1532442612, 1, 1, 3, 'Sent 250,000 to Oluyole Branch', 'Hello Admin,\r\nTwo Hundred and Fifty Thousand Naira has been sent to Oluyole branch.\r\nFollow up with the confirmation.\r\nThanks.\r\n\r\nHabeeb', 1),
(2, 1532442612, 0, 1, -1, 'Sent 250,000 to Oluyole Branch', 'Hello Admin,\r\nTwo Hundred and Fifty Thousand Naira has been sent to Oluyole branch.\r\nFollow up with the confirmation.\r\nThanks.\r\n\r\nHabeeb\n\nSent to: ALL Admins', 0),
(3, 1532637423, 1, 4, 2, 'Please approve 60,000', 'There is a transaction that is pending approval.\r\nThanks', 1),
(4, 1532637423, 0, 4, -1, 'Please approve 60,000', 'There is a transaction that is pending approval.\r\nThanks\n\nSent to: Manager', 0);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(300) NOT NULL,
  `super` int(11) NOT NULL DEFAULT '0',
  `credit` decimal(65,2) NOT NULL DEFAULT '0.00',
  `debit` decimal(65,2) NOT NULL DEFAULT '0.00',
  `details` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `name`, `phone`, `address`, `super`, `credit`, `debit`, `details`) VALUES
(1, 'Oluyole', '08056530172', '3, Oluyole industrial Estate, Bodija, Ibadan', 2, '311500.00', '50000.00', 'Credit with 60000 and 1000 naira as charges\nAdded &#8358;60000 (charges: &#8358;1000.00) by T04731 - (Olonade Abidemi) on Thu, 26.07.2018 09:34:54 PM\n____________\n\rGive 40,000 to customer with 400 naira charges\nDeducted &#8358;40000 (charges: &#8358;400.00) by T04731 - (Olonade Abidemi) on Thu, 26.07.2018 09:31:53 PM\n____________\n\nGive customer 10,000 with 100 naira as charges\nDeducted &#8358;10000 (charges: &#8358;100.00) by T02456 - (Bamitale Hafiz) on Thu, 26.07.2018 08:28:04 PM\n____________\n\nAdd &#8358;250000 on Tue, 24.07.2018 12:02:19 PM\n____________\n\n');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `date` int(20) NOT NULL,
  `ref` varchar(50) NOT NULL,
  `user` bigint(20) NOT NULL,
  `school` int(11) NOT NULL DEFAULT '0',
  `ttype` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(65,2) NOT NULL DEFAULT '0.00',
  `charges` decimal(65,2) NOT NULL DEFAULT '0.00',
  `details` longtext NOT NULL,
  `approval` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `date`, `ref`, `user`, `school`, `ttype`, `amount`, `charges`, `details`, `approval`) VALUES
(1, 1532430139, '11532430139', 1, 1, 3, '250000.00', '0.00', '\nAdd &#8358;250000 on Tue, 24.07.2018 12:02:19 PM', 1),
(2, 1532633284, '11532633284', 2, 1, 2, '10000.00', '100.00', 'Give customer 10,000 with 100 naira as charges\nDeducted &#8358;10000 (charges: &#8358;100.00) by T02456 - (Bamitale Hafiz) on Thu, 26.07.2018 08:28:04 PM', 2),
(3, 1532637113, '11532637113', 4, 1, 2, '40000.00', '400.00', 'Give 40,000 to customer with 400 naira charges\nDeducted &#8358;40000 (charges: &#8358;400.00) by T04731 - (Olonade Abidemi) on Thu, 26.07.2018 09:31:53 PM', 4),
(4, 1532637294, '11532637294', 4, 1, 1, '60000.00', '1000.00', 'Credit with 60000 and 1000 naira as charges\nAdded &#8358;60000 (charges: &#8358;1000.00) by T04731 - (Olonade Abidemi) on Thu, 26.07.2018 09:34:54 PM', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `utype` int(11) NOT NULL DEFAULT '2',
  `school` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `credit` decimal(65,2) NOT NULL DEFAULT '0.00',
  `debit` decimal(65,2) NOT NULL DEFAULT '0.00',
  `super` int(11) NOT NULL DEFAULT '0',
  `ban` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `utype`, `school`, `username`, `password`, `name`, `phone`, `credit`, `debit`, `super`, `ban`) VALUES
(1, 0, 0, 'admin', 'admin', 'Administrator', '09012345678', '0.00', '0.00', 0, 0),
(2, 1, 1, 'T02456', 'super1', 'Bamitale Hafiz', '08022222268', '0.00', '0.00', 1, 0),
(3, 3, 0, 'T03221', 'admin1', 'Admin Habeeb', '09012345673', '0.00', '0.00', 1, 0),
(4, 2, 1, 'T04731', 'staff1', 'Olonade Abidemi', '09012345672', '0.00', '0.00', 2, 0);
