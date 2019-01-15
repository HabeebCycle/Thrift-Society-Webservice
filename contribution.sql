-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2018 at 10:13 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `contribution`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE IF NOT EXISTS `access` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `paid` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`id`, `user`, `paid`) VALUES
(1, 1, '#01-2018#02-2018#03-2018'),
(2, 2, '#01-2018#02-2018#03-2018');

-- --------------------------------------------------------

--
-- Table structure for table `agm`
--

CREATE TABLE IF NOT EXISTS `agm` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `agm`
--

INSERT INTO `agm` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 2, 1522147851, '1200.00', '0.00', 'cxs  (Credit transaction created by Okunade Habeeb of &#8358;1200.00 on Tue 27.03.2018 12:50:51 PM)', 1),
(2, 2, 1522147921, '0.00', '1050.00', '  (Debit transaction created by Okunade Habeeb of &#8358;1050 on Tue 27.03.2018 12:52:01 PM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE IF NOT EXISTS `building` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 2, 1522136434, '1200.00', '0.00', '  (Credit transaction created by Okunade Habeeb of â‚¦1000 on Tue 27.03.2018 09:40:34 AM)<br/>  (Credit transaction edited by Okunade Habeeb of &#8358;1200.00 on Tue 27.03.2018 09:40:55 AM)', 1),
(2, 2, 1522136477, '0.00', '550.25', '  (Debit transaction created by Okunade Habeeb of &#8358;550.25 on Tue 27.03.2018 09:41:17 AM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE IF NOT EXISTS `business` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 2, 1522135438, '7400.00', '0.00', '  (Credit transaction created by Okunade Habeeb of â‚¦7000 on Tue 27.03.2018 09:23:58 AM)<br/>  (Credit transaction edited by Okunade Habeeb of &#8358;7400.00 on Tue 27.03.2018 09:24:26 AM)', 1),
(2, 2, 1522135492, '0.00', '3250.50', '  (Debit transaction created by Okunade Habeeb of &#8358;3250.50 on Tue 27.03.2018 09:24:52 AM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `development`
--

CREATE TABLE IF NOT EXISTS `development` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `emergency`
--

CREATE TABLE IF NOT EXISTS `emergency` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `emergency`
--

INSERT INTO `emergency` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 2, 1522134849, '400.00', '0.00', '  (Credit transaction created by Okunade Habeeb of â‚¦200 on Tue 27.03.2018 09:14:09 AM)<br/>  (Credit transaction edited by Okunade Habeeb of &#8358;400.00 on Tue 27.03.2018 09:14:25 AM)', 1),
(2, 2, 1522134880, '0.00', '150.00', '  (Debit transaction created by Okunade Habeeb of â‚¦120 on Tue 27.03.2018 09:14:40 AM)<br/>  (Debit transaction edited by Okunade Habeeb of &#8358;150.00 on Tue 27.03.2018 09:14:53 AM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `investment`
--

CREATE TABLE IF NOT EXISTS `investment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `investment`
--

INSERT INTO `investment` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(3, 2, 1522086981, '2200.00', '0.00', 'New Investment  (Credit transaction created by Okunade Habeeb of â‚¦2500 on Mon 26.03.2018 07:56:21 PM)<br/>  (Credit transaction edited by Okunade Habeeb of &#8358;2200.00 on Mon 26.03.2018 07:57:49 PM)', 1),
(4, 2, 1522087099, '0.00', '1000.00', '  (Debit transaction created by Okunade Habeeb of &#8358;1000 on Mon 26.03.2018 07:58:19 PM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountpay` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`id`, `user`, `date`, `amountcr`, `amountdr`, `amountpay`, `details`, `admin`) VALUES
(3, 2, 1522164072, '0.00', '2000.00', '2050.00', 'Collect Loan\r\nGuarantors : Habeeb, Mutiu  (Debit (Loan give out)transaction created by Okunade Habeeb of &#8358;2000.00 on Tue 27.03.2018 05:21:12 PM)', 1),
(4, 2, 1522164151, '100.00', '0.00', '0.00', '  (Credit (Repayment)transaction created by Okunade Habeeb of &#8358;100 on Tue 27.03.2018 05:22:31 PM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE IF NOT EXISTS `loans` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `savings` decimal(14,2) NOT NULL,
  `amount1` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amount2` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amount3` decimal(14,2) NOT NULL DEFAULT '0.00',
  `guarantor1` int(11) NOT NULL DEFAULT '0',
  `guarantor2` int(11) NOT NULL DEFAULT '0',
  `complete` int(11) NOT NULL DEFAULT '0',
  `date1` int(11) NOT NULL,
  `date2` int(11) NOT NULL,
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `user`, `savings`, `amount1`, `amount2`, `amount3`, `guarantor1`, `guarantor2`, `complete`, `date1`, `date2`, `details`, `admin`) VALUES
(1, 2, '1000.00', '2000.00', '2050.00', '100.00', 0, 0, 0, 1522164072, 0, 'Collect Loan\r\nGuarantors : Habeeb, Mutiu  (Debit (Loan give out)transaction created by Okunade Habeeb of &#8358;2000.00 on Tue 27.03.2018 05:21:12 PM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE IF NOT EXISTS `meetings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `minutes` longtext NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `date`, `minutes`, `admin`) VALUES
(1, 1522188000, 'We had a meeting and our agenda are as follows', 1),
(2, 1522274400, 'Chance to live and work in one of the most ranked cities that is liveable in the world. Easy access to information and services from the State Government to settle and looking for job in SA. Ability to receive 5 points to complete the needed 60 points for a 190-Skilled Nominated visa. Availability of the occupation in SA occupation list. Fast and high priority visa processing time with the Department of Home Affairs. Ability to further one''s career in the state.\r\n\r\nDiagnosing and correcting machine errors through digital human-machine interface.  Assembling machine parts and components and installing hydraulic and pneumatic systems for the required production system.  Dismantling faulty equipment and repairing or replacing defective parts by checking accuracy and quality of the machine parts during preventive maintenance. Maintaining workshop toolbox by sharpening and replacing worn tools with adherence to quality assurance procedures and processes.', 1),
(4, 1522101600, 'Dear Sir or Madam,\r\nI am one of the nominated candidates for visa sub class 190.\r\n\r\nI just want to know how to proceed for the application.\r\n\r\nI will be happy if my request is granted.\r\n\r\nThanks.\r\n\r\nOjuolape Mariyam\r\n10392239', 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mtype` int(11) NOT NULL DEFAULT '0',
  `sender` int(11) NOT NULL,
  `receipt` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` longtext NOT NULL,
  `readr` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `mtype`, `sender`, `receipt`, `date`, `title`, `message`, `readr`) VALUES
(1, 1, 1, 2, 1522424482, 'Pay your due', 'Chance to live and work in one of the most ranked cities that is liveable in the world. Easy access to information and services from the State Government to settle and looking for job in SA. Ability to receive 5 points to complete the needed 60 points for a 190-Skilled Nominated visa. Availability of the occupation in SA occupation list. Fast and high priority visa processing time with the Department of Home Affairs. Ability to further one''s career in the state.\r\n\r\nDiagnosing and correcting machine errors through digital human-machine interface.  Assembling machine parts and components and installing hydraulic and pneumatic systems for the required production system.  Dismantling faulty equipment and repairing or replacing defective parts by checking accuracy and quality of the machine parts during preventive maintenance. Maintaining workshop toolbox by sharpening and replacing worn tools with adherence to quality assurance procedures and processes.', 1),
(2, 0, 2, 0, 1522425585, 'Happy Salah', 'Diagnosing and correcting machine errors through digital human-machine interface. Assembling machine parts and components and installing hydraulic and pneumatic systems for the required production system. Dismantling faulty equipment and repairing or replacing defective parts by checking accuracy and quality of the machine parts during preventive maintenance. Maintaining workshop toolbox by sharpening and replacing worn tools with adherence to quality assurance procedures and processes.', 0),
(3, 0, 1, 0, 1522426256, 'Welcome to our app', 'select * from messages where mtype=0 order by id desc limit 10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `others`
--

CREATE TABLE IF NOT EXISTS `others` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `others`
--

INSERT INTO `others` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 2, 1522150043, '7200.50', '0.00', 'sss  (Credit transaction created by Okunade Habeeb of â‚¦7000 on Tue 27.03.2018 01:27:23 PM)<br/>  (Credit transaction edited by Okunade Habeeb of &#8358;7200.50 on Tue 27.03.2018 01:27:44 PM)', 1),
(2, 2, 1522150086, '0.00', '6000.50', '  (Debit transaction created by Okunade Habeeb of â‚¦5000.50 on Tue 27.03.2018 01:28:06 PM)<br/>  (Debit transaction edited by Okunade Habeeb of &#8358;6000.50 on Tue 27.03.2018 01:28:29 PM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `actype` int(11) NOT NULL DEFAULT '0',
  `acid` int(11) NOT NULL DEFAULT '0',
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `actype`, `acid`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 0, 0, 2, 1522341600, '1550.00', '0.00', 'Testing  (Pay-in transaction created by Okunade Habeeb of &#8358;1550 on Thu 29.03.2018 06:40:00 PM)', 1),
(2, 0, 0, 1, 1522341863, '2500.00', '0.00', 'Bicycle  (Pay-in transaction created by Okunade Habeeb of â‚¦2300 on Thu 29.03.2018 06:44:23 PM)<br/>  (Pay-in transaction edited by Okunade Habeeb of &#8358;2500.00 on Thu 29.03.2018 06:48:50 PM)', 1),
(3, 0, 0, 1, 1522341970, '0.00', '2000.00', 'Recharge cards  (Pay-out transaction created by Okunade Habeeb of &#8358;2000.00 on Thu 29.03.2018 06:46:10 PM)', 1),
(4, 3, 3, 2, 1522342830, '250.00', '0.00', 'Savings  (Credit transaction created by Okunade Habeeb of &#8358;250.00 on Thu 29.03.2018 07:00:30 PM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE IF NOT EXISTS `savings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 2, 1522097331, '5000.00', '0.00', 'Savings  (Credit transaction created by Okunade Habeeb of â‚¦2000 on Mon 26.03.2018 10:48:51 PM)<br/>Add  (Credit transaction edited by Okunade Habeeb of &#8358;5000.00 on Mon 26.03.2018 10:50:46 PM)', 1),
(2, 2, 1522097495, '0.00', '4000.00', '  (Debit transaction created by Okunade Habeeb of &#8358;4000 on Mon 26.03.2018 10:51:35 PM)', 1),
(3, 2, 1522342830, '250.00', '0.00', 'Savings  (Credit transaction created by Okunade Habeeb of &#8358;250.00 on Thu 29.03.2018 07:00:30 PM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `value` decimal(12,2) NOT NULL,
  `details` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `details`) VALUES
(1, 'interest', '5.00', '5% interest rate');

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE IF NOT EXISTS `shares` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `shares`
--

INSERT INTO `shares` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 2, 1521996939, '1000.00', '0.00', 'First Shares\nTransaction created by Okunade Habeeb of Credit on Sun 25.03.2018 06:55:39 PM', 1),
(2, 2, 1521997994, '1200.00', '0.00', 'Upkeep  (Transaction created by Okunade Habeeb of Credit on Sun 25.03.2018 07:13:14 PM)', 1),
(3, 2, 1522003034, '1500.00', '0.00', 'Aniversary  (Transaction created by Okunade Habeeb of Credit on Sun 25.03.2018 08:37:14 PM)', 1),
(4, 2, 1522008399, '0.00', '1300.00', 'Remove  (Transaction created by Okunade Habeeb of Debit on Sun 25.03.2018 10:06:39 PM)<br/>Edited  (Debit transaction edited by Okunade Habeeb of &#8358;1300.00 on Mon 26.03.2018 07:16:45 PM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `social`
--

CREATE TABLE IF NOT EXISTS `social` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `social`
--

INSERT INTO `social` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 2, 1522148577, '1100.00', '0.00', 'social  (Credit transaction created by Okunade Habeeb of â‚¦1000 on Tue 27.03.2018 01:02:57 PM)<br/>  (Credit transaction edited by Okunade Habeeb of &#8358;1100.00 on Tue 27.03.2018 01:03:23 PM)', 1),
(2, 2, 1522148640, '0.00', '800.00', '  (Debit transaction created by Okunade Habeeb of &#8358;800 on Tue 27.03.2018 01:04:00 PM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

CREATE TABLE IF NOT EXISTS `target` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `date` int(11) NOT NULL,
  `amountcr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `amountdr` decimal(14,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `target`
--

INSERT INTO `target` (`id`, `user`, `date`, `amountcr`, `amountdr`, `details`, `admin`) VALUES
(1, 2, 1522098214, '2650.00', '0.00', 'Target  (Credit transaction created by Okunade Habeeb of â‚¦ 2400 on Mon 26.03.2018 11:03:34 PM)<br/>  (Credit transaction edited by Okunade Habeeb of &#8358;2650.00 on Mon 26.03.2018 11:03:47 PM)', 1),
(2, 2, 1522098264, '0.00', '2650.00', 'Debit  (Debit transaction created by Okunade Habeeb of â‚¦2000 on Mon 26.03.2018 11:04:24 PM)<br/>  (Debit transaction edited by Okunade Habeeb of â‚¦2100.00 on Mon 26.03.2018 11:10:59 PM)<br/>  (Debit transaction edited by Okunade Habeeb of â‚¦2100.00 on Mon 26.03.2018 11:11:17 PM)<br/>  (Debit transaction edited by Okunade Habeeb of â‚¦2100.00 on Mon 26.03.2018 11:14:04 PM)<br/>  (Debit transaction edited by Okunade Habeeb of â‚¦2200.00 on Tue 27.03.2018 08:37:11 AM)<br/>  (Debit transaction edited by Okunade Habeeb of â‚¦2200.00 on Tue 27.03.2018 08:37:34 AM)<br/>  (Debit transaction edited by Okunade Habeeb of â‚¦2200.00 on Tue 27.03.2018 08:38:35 AM)<br/>  (Debit transaction edited by Okunade Habeeb of &#8358;2650.00 on Tue 27.03.2018 08:44:36 AM)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `org` int(11) NOT NULL DEFAULT '1',
  `name` varchar(200) NOT NULL,
  `regno` varchar(50) NOT NULL,
  `pin` int(11) NOT NULL,
  `utype` int(11) NOT NULL DEFAULT '3',
  `sex` int(11) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `doj` varchar(20) NOT NULL,
  `intro` int(11) NOT NULL DEFAULT '0',
  `address` text NOT NULL,
  `phone` varchar(50) NOT NULL,
  `occ` varchar(200) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `ban` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `org`, `name`, `regno`, `pin`, `utype`, `sex`, `dob`, `doj`, `intro`, `address`, `phone`, `occ`, `active`, `ban`, `deleted`) VALUES
(1, 0, 'Okunade Habeeb', '0100', 1234, 2, 1, '23-04-1978', '12-01-2017', 1, '2, Akorede Street, Badia, Lagos Nigeria', '09012345673', 'Business Trader', 1, 0, 0),
(2, 1, 'Hashim Mutiullahi', '0102', 1234, 3, 2, '12-12-1997', '13-12-2015', 0, '3, Lagos Road, Ibadan, Nigeria', '08038350070', 'Business Trader', 1, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
