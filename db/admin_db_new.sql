-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2018 at 02:35 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `admin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `phone_no` bigint(15) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `is_superAdmin` char(1) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `phone_no` (`phone_no`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `title`, `first_name`, `last_name`, `username`, `pwd`, `phone_no`, `email_id`, `start_date`, `is_superAdmin`) VALUES
(1, 'Prabhu', 'Gaurgopal', 'Das', 'ggdas', 'ggdas3', 131, 'ggd@gmail.com', '2017-11-27', 'N'),
(2, 'HG', 'Prashant', 'Prabhu', 'pv', 'pv', 132134, 'pv@gmail.com', '2017-12-27', 'Y'),
(3, 'HG', 'gopal', 'prabhu', 'gp', 'gp', 17564, 'gp@gmail.com', '2017-12-27', 'N'),
(4, 'HG', 'Premswarup', 'Prabhu', 'psp', 'psp', 67453, 'psp@gmail.com', '2017-12-29', 'N'),
(5, 'Prabhu', 'Srinimayi', 'Das', 'psd', 'psd', 1321123, 'psd@gmail.com', '2018-01-03', 'N'),
(6, 'Prabhu', 'Anantbhagwan', 'Das', 'abd', 'abd', 17862, 'abd@gmail.com', '2018-01-06', 'N'),
(7, 'HG', 'SriNitayi', 'Das Pr', 'snd', 'snd', 16123, 'snd@gmail.com', '2018-01-06', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `follow_up`
--

CREATE TABLE IF NOT EXISTS `follow_up` (
  `user_id` int(11) NOT NULL,
  `followup_date` date NOT NULL,
  `followup_remark` text NOT NULL,
  `nxt_followup_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow_up`
--

INSERT INTO `follow_up` (`user_id`, `followup_date`, `followup_remark`, `nxt_followup_date`) VALUES
(55, '2017-12-20', 'call again', '2017-12-27'),
(61, '2018-01-06', 'call again', '2018-01-07'),
(49, '2018-01-06', 'call again', '2018-01-07'),
(55, '2017-12-27', 'call next time', '2018-01-10'),
(55, '2018-01-10', 'no money this time, will donate next time', '2018-01-17'),
(72, '2018-02-01', 'test followup feb', '2018-02-05');

-- --------------------------------------------------------

--
-- Stand-in structure for view `last_btg_sent_view`
--
CREATE TABLE IF NOT EXISTS `last_btg_sent_view` (
`user_id` int(255)
,`last_btg_sent_date` date
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `last_details_view`
--
CREATE TABLE IF NOT EXISTS `last_details_view` (
`user_id` int(255)
,`last_payment_date` date
,`last_btg_sent_date` date
,`last_gift_sent_date` date
,`last_prasadam_sent_date` date
,`last_followup_date` date
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `last_followup_view`
--
CREATE TABLE IF NOT EXISTS `last_followup_view` (
`user_id` int(255)
,`last_followup_date` date
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `last_gift_sent_view`
--
CREATE TABLE IF NOT EXISTS `last_gift_sent_view` (
`user_id` int(255)
,`last_gift_sent_date` date
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `last_payment_view`
--
CREATE TABLE IF NOT EXISTS `last_payment_view` (
`user_id` int(255)
,`last_payment_date` date
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `last_prasadam_sent_view`
--
CREATE TABLE IF NOT EXISTS `last_prasadam_sent_view` (
`user_id` int(255)
,`last_prasadam_sent_date` date
);
-- --------------------------------------------------------

--
-- Table structure for table `scheme`
--

CREATE TABLE IF NOT EXISTS `scheme` (
  `scheme_id` int(255) NOT NULL AUTO_INCREMENT,
  `scheme_name` varchar(50) NOT NULL,
  `scheme_value` int(50) NOT NULL,
  PRIMARY KEY (`scheme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `scheme`
--

INSERT INTO `scheme` (`scheme_id`, `scheme_name`, `scheme_value`) VALUES
(1, 'Prabhupada Sevak', 501),
(2, 'Jagannath Sevak', 1001),
(3, 'Govind Sevak', 1501);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `first_name` varchar(505) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `phone_no` bigint(50) NOT NULL,
  `whatsapp` bigint(50) NOT NULL,
  `dob` date NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `is_active` varchar(1) NOT NULL,
  `connected_to` varchar(50) NOT NULL,
  `user_lang` varchar(50) NOT NULL,
  `scheme_id` int(11) NOT NULL,
  `scheme_name` varchar(50) NOT NULL,
  `corresponder` varchar(50) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `phone_no` (`phone_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `title`, `first_name`, `last_name`, `address`, `phone_no`, `whatsapp`, `dob`, `company_name`, `email_id`, `start_date`, `is_active`, `connected_to`, `user_lang`, `scheme_id`, `scheme_name`, `corresponder`, `remarks`) VALUES
(46, 'Mr.', 'Kp', 'Singh', 'Behala', 9007208687, 9007208687, '0000-00-00', '', 'kp@gmail.com', '2017-12-14', 'Y', 'Nitai', 'English', 2, 'Jagannath Sevak', 'HG Sevyagovind Pr', 'paid'),
(47, 'Mr.', 'aman', 'pandey', 'new alipore', 7834, 7834, '0000-00-00', '', 'f00@g', '2017-12-15', 'Y', 'Nitai', 'Hindi', 3, 'Govind Sevak', 'prashant', 'paid'),
(48, 'miss', 'dia', 'sen', 'taratola', 54782, 54782, '0000-00-00', '', 'f00@g', '2017-12-15', 'Y', 'BV2', 'Hindi', 2, 'Jagannath Sevak', 'prashant', 'paid'),
(49, 'Mr.', 'Ayan', 'Kumar', 'cvxb', 13425, 13425, '0000-00-00', '', 'f00@g', '2017-12-15', 'Y', 'BV4', 'Bengali', 1, 'Prabhupada Sevak', 'HG Sevyagovind Pr', 'paid'),
(50, 'Miss', 'Anaida', 'Mehta', 'Khidderpore', 4567, 4567, '0000-00-00', '', 'f00@g', '2017-12-15', 'Y', 'Nitai', 'English', 2, 'Jagannath Sevak', 'prashant', 'paid'),
(51, 'Mr.', 'Dinesh', 'Dutta', 'Behala', 15631, 15631, '0000-00-00', '', 'f00@g', '2017-12-15', 'Y', 'BV2', 'Bengali', 3, 'Govind Sevak', 'HG Sevyagovind Pr', 'paid'),
(52, 'Miss', 'Rima', 'Roy', 'Behala', 2313, 2313, '0000-00-00', '', 'f00@g', '2017-11-25', 'Y', 'BV1', 'Hindi', 1, 'Prabhupada Sevak', 'HG Sevyagovind Pr', 'paid'),
(53, 'miss', 'dggd', 'sg', 'asfgdd', 1111, 1111, '0000-00-00', '', 'f00@g', '2017-12-15', 'Y', 'Nitai', 'English', 3, 'Govind Sevak', 'HG Sevyagovind Pr', 'paid'),
(54, 'Mr.', 'Hitesh', 'Mohan', 'Joka', 1441, 1441, '0000-00-00', '', 'vgg@gmail', '2017-11-26', 'Y', 'BV6', 'Hindi', 2, 'Jagannath Sevak', 'prashant', 'done'),
(55, 'Mr.', 'Shivam', 'Singh', 'Kolkata', 12, 12, '0000-00-00', '', 'an@gm', '2017-11-29', 'Y', 'BV7', 'Bengali', 2, 'Jagannath Sevak', 'prashant', 'paid'),
(57, 'Miss', 'Tania', 'Dutta', 'Joka', 2781, 2781, '0000-00-00', '', 'tdutta@gmail.com', '2018-01-03', 'N', 'BV1', 'English', 3, 'Govind Sevak', 'HG Sevyagovind Prabhu', 'due'),
(58, 'Mr', 'Vikas', 'Gourav', 'adhsa', 89899989, 89898989, '0000-00-00', '', 'v@g.com', '2018-01-05', 'Y', 'BV1', 'Hindi', 1, 'Prabhupada Sevak', 'VG', 'remarks'),
(60, 'Mrs', 'Aparna', 'Ganguly', 'Behala', 123451, 123451, '0000-00-00', '', 'apg@gmail.com', '2018-01-06', 'Y', 'Nitai', 'English', 2, 'Jagannath Sevak', 'Devajyoti', 'new'),
(61, 'Mrs', 'Sandhya', 'Ganguly', 'Joka', 141, 141, '0000-00-00', '', 'saga@gmail.com', '2018-01-06', 'Y', 'Nitai', 'Hindi', 2, 'Jagannath Sevak', 'Devajyoti', 'new'),
(62, 'Mr', 'Mohit', 'Jha', 'Ballygunge', 1231451, 1231451, '0000-00-00', '', 'mj@gmail.com', '2018-01-06', 'Y', 'Nitai', 'English', 3, 'Govind Sevak', 'Devajyoti', 'new'),
(63, 'Mr', 'First', 'Last', 'Address', 9899899898, 9898989989, '0000-00-00', '', 'vgv@hj.com', '2030-11-00', 'Y', 'BV1', 'Bengali', 1, 'Prabhupada Sevak', 'SEVYA', 'HK'),
(64, 'Mr', 'Chetan', 'Sen', 'Tollygunge', 13215, 13215, '0000-00-00', '', 'cs@gmail.com', '2018-01-09', 'Y', 'BV3', 'English', 3, 'JAGGANATH', 'Devajyoti', 'paid'),
(67, 'Mr', 'Vik', 'Gourav', 'behala', 9999, 9999, '0000-00-00', '', 'vg@m.com', '1988-07-09', 'Y', 'BV1', 'English', 1, 'Prabhupada Sevak', 'Prashant Pr', 'remarks test'),
(68, 'k', 'k', 'k', 'k', 99, 99, '0000-00-00', '', 'g', '2018-01-19', 'Y', 'BV1', 'English', 2, 'Jagannath Sevak', 'c', 'r'),
(69, 'h', 'h', 'h', 'h', 3, 3, '0000-00-00', '', 'v', '2018-01-19', 'Y', 'BV1', 'English', 1, 'Prabhupada Sevak', 'c', 'r'),
(70, 'j', 'j', 'j', 'j', 66, 66, '0000-00-00', '', 'b', '2018-01-19', 'Y', 'BV1', 'English', 1, 'Prabhupada Sevak', 'b', 'b'),
(71, 'h', 'h', 'h', 'k', 111, 111, '0000-00-00', '', 'b', '2018-01-22', 'Y', 'BV1', 'English', 1, 'Prabhupada Sevak', 'pv', 'r'),
(72, 'Mr', 'h', 'h', 'h', 123, 123, '2018-02-06', 'b', 'b@g.c', '2017-11-01', 'Y', 'BV1', 'English', 2, 'Jagannath Sevak', 'c', 'r');

-- --------------------------------------------------------

--
-- Table structure for table `user_btg`
--

CREATE TABLE IF NOT EXISTS `user_btg` (
  `user_id` bigint(20) NOT NULL,
  `btg_lang` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `is_dispatched` varchar(1) NOT NULL,
  `dispatch_date` date NOT NULL,
  `remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_btg`
--

INSERT INTO `user_btg` (`user_id`, `btg_lang`, `description`, `is_dispatched`, `dispatch_date`, `remarks`) VALUES
(70, 'English', 'Jan 2018', 'Y', '2018-01-10', 'Dispatched through courier'),
(55, 'Bengali', 'Dec 2017', 'Y', '2017-12-10', 'Dispatched through FirstFlight Courier'),
(0, 'English', 'test', 'Y', '2018-01-25', 'test'),
(0, 'English', 'test', 'Y', '2018-01-25', 'test'),
(55, 'English', 'test', 'Y', '2018-01-25', 'test'),
(72, 'English', 'test btg', 'Y', '2018-02-06', 'feb'),
(72, 'English', 'test btg', 'Y', '2018-02-06', 'feb');

-- --------------------------------------------------------

--
-- Table structure for table `user_due`
--

CREATE TABLE IF NOT EXISTS `user_due` (
  `user_id` int(255) NOT NULL,
  `is_due` char(1) NOT NULL,
  `cp` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_due`
--

INSERT INTO `user_due` (`user_id`, `is_due`, `cp`) VALUES
(53, 'N', 'N'),
(55, 'Y', 'N'),
(57, 'Y', 'N'),
(58, 'Y', 'N'),
(60, 'Y', 'N'),
(61, 'Y', 'N'),
(62, 'Y', 'N'),
(63, 'Y', 'N'),
(64, 'Y', 'Y'),
(72, 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `user_gift_prasadam`
--

CREATE TABLE IF NOT EXISTS `user_gift_prasadam` (
  `user_id` int(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `is_dispatched` varchar(1) NOT NULL,
  `dispatch_date` date NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_gift_prasadam`
--

INSERT INTO `user_gift_prasadam` (`user_id`, `type`, `description`, `is_dispatched`, `dispatch_date`, `remarks`) VALUES
(54, 'gift', 'December 2017', 'Y', '2017-12-16', 'sent'),
(55, 'gift', 'fvf', 'Y', '2017-12-13', 'd'),
(55, 'Prasadam', 'mahaprasadam', 'N', '2017-12-13', 'not sent yet'),
(55, 'gift', 'december', 'N', '2017-12-13', 'not sent yet'),
(55, 'gift', 'nov', 'N', '2017-12-13', 'not sent yet'),
(55, 'gift', 'oct', 'N', '2017-12-13', 'not sent yet'),
(61, 'gift', 'Jan 2018', 'Y', '2018-01-06', 'sent'),
(54, 'Prasadam', 'jan', 'Y', '2018-01-06', 'sent'),
(61, 'gift', 'none', 'N', '2017-12-13', 'not sent yet'),
(61, 'gift', 'dec 2017', 'Y', '2017-12-03', 'sent'),
(72, 'prasadam', 'test gift feb', 'Y', '2018-02-06', 'test gift feb'),
(72, 'gift', 'test gift feb', 'Y', '2018-02-06', 'test gift feb'),
(72, 'gift', 'test gift feb', 'Y', '2018-02-06', 'test gift feb');

-- --------------------------------------------------------

--
-- Table structure for table `user_payment`
--

CREATE TABLE IF NOT EXISTS `user_payment` (
  `user_id` int(255) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `amt_paid` int(11) NOT NULL,
  `payment_details` varchar(50) NOT NULL,
  `payment_remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_payment`
--

INSERT INTO `user_payment` (`user_id`, `payment_type`, `payment_date`, `amt_paid`, `payment_details`, `payment_remarks`) VALUES
(51, 'Cheque', '0000-00-00', 1501, '231', 'done'),
(52, 'Cheque', '2017-11-26', 101, '14562', 'due'),
(52, 'Cheque', '2017-12-15', 100, '13241', 'done'),
(54, 'Cash', '2017-12-15', 401, 'NA', 'due'),
(52, 'Cash', '2017-12-15', 50, 'NA', 'due'),
(54, 'Cash', '2017-12-15', 150, 'NA', 'paid 150'),
(55, 'Cash', '2017-11-28', 101, 'NA', 'due'),
(55, 'Cash', '2017-11-29', 200, 'NA', 'paid Rs.200'),
(55, 'Cash', '2017-11-29', 50, 'NA', 'paid 50'),
(70, 'Cash', '2017-12-15', 501, 'NA', 'paid 501'),
(70, 'Cash', '2017-12-15', 100, 'NA', 'paid 100'),
(70, 'Cash', '2017-12-15', 50, 'NA', 'paid 50'),
(70, 'Cash', '2017-12-15', 50, 'NA', 'paid 50 again'),
(70, 'Cash', '2017-12-15', 50, 'NA', 'paid 50 again'),
(70, 'Cash', '2017-11-30', 50, 'NA', 'paid 50'),
(55, 'Cheque', '2017-11-28', 250, '253648', 'by cheque'),
(70, 'Cash', '2017-11-30', 700, 'NA', 'paid'),
(57, 'Cash', '2018-01-03', 501, 'NA', 'paid 501'),
(58, 'Cash', '2018-01-05', 100, 'ref1', 'partially paid'),
(60, 'Cash', '2018-01-06', 201, 'NA', 'partially paid'),
(62, 'Cash', '2018-01-06', 1001, 'NA', 'partially paid'),
(62, 'Cash', '2018-01-06', 100, 'NA', 'partially paid'),
(61, 'Cash', '2018-01-06', 201, 'NA', 'partially paid'),
(61, 'Cash', '2018-01-06', 50, 'NA', 'partially paid'),
(61, 'Cash', '2018-01-06', 50, 'NA', 'partially paid'),
(63, 'Cash', '2018-01-06', 100, 'ref1', 'hk'),
(64, 'Cash', '2018-01-12', 10000, 'NA', 'partially paid'),
(64, 'Cash', '2018-09-14', 3000, 'NA', 'partially paid'),
(64, 'Cash', '2018-09-26', 1000, 'NA', 'partially paid'),
(0, '', '0000-00-00', 0, '', ''),
(72, 'Cash', '2018-02-06', 45, 'r', 'r'),
(72, 'Cash', '2018-02-06', 45, 'r', 'r'),
(72, 'Cash', '2018-02-06', 45, 'r', 'r');

-- --------------------------------------------------------

--
-- Structure for view `last_btg_sent_view`
--
DROP TABLE IF EXISTS `last_btg_sent_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `last_btg_sent_view` AS select `u`.`user_id` AS `user_id`,max(`ubtg`.`dispatch_date`) AS `last_btg_sent_date` from (`users` `u` join `user_btg` `ubtg`) where (`u`.`user_id` = `ubtg`.`user_id`) group by `u`.`user_id`;

-- --------------------------------------------------------

--
-- Structure for view `last_details_view`
--
DROP TABLE IF EXISTS `last_details_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `last_details_view` AS select `u`.`user_id` AS `user_id`,`pv`.`last_payment_date` AS `last_payment_date`,`btgv`.`last_btg_sent_date` AS `last_btg_sent_date`,`gv`.`last_gift_sent_date` AS `last_gift_sent_date`,`prv`.`last_prasadam_sent_date` AS `last_prasadam_sent_date`,`folv`.`last_followup_date` AS `last_followup_date` from (((((`users` `u` left join `last_payment_view` `pv` on((`u`.`user_id` = `pv`.`user_id`))) left join `last_btg_sent_view` `btgv` on((`u`.`user_id` = `btgv`.`user_id`))) left join `last_gift_sent_view` `gv` on((`u`.`user_id` = `gv`.`user_id`))) left join `last_prasadam_sent_view` `prv` on((`u`.`user_id` = `prv`.`user_id`))) left join `last_followup_view` `folv` on((`u`.`user_id` = `folv`.`user_id`))) order by `u`.`user_id`;

-- --------------------------------------------------------

--
-- Structure for view `last_followup_view`
--
DROP TABLE IF EXISTS `last_followup_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `last_followup_view` AS select `u`.`user_id` AS `user_id`,max(`fol`.`followup_date`) AS `last_followup_date` from (`users` `u` join `follow_up` `fol`) where (`u`.`user_id` = `fol`.`user_id`) group by `u`.`user_id`;

-- --------------------------------------------------------

--
-- Structure for view `last_gift_sent_view`
--
DROP TABLE IF EXISTS `last_gift_sent_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `last_gift_sent_view` AS select `u`.`user_id` AS `user_id`,max(`ugp`.`dispatch_date`) AS `last_gift_sent_date` from (`users` `u` join `user_gift_prasadam` `ugp`) where ((`u`.`user_id` = `ugp`.`user_id`) and (`ugp`.`type` = 'Gift')) group by `u`.`user_id`;

-- --------------------------------------------------------

--
-- Structure for view `last_payment_view`
--
DROP TABLE IF EXISTS `last_payment_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `last_payment_view` AS select `u`.`user_id` AS `user_id`,max(`up`.`payment_date`) AS `last_payment_date` from (`users` `u` join `user_payment` `up`) where (`u`.`user_id` = `up`.`user_id`) group by `u`.`user_id`;

-- --------------------------------------------------------

--
-- Structure for view `last_prasadam_sent_view`
--
DROP TABLE IF EXISTS `last_prasadam_sent_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `last_prasadam_sent_view` AS select `u`.`user_id` AS `user_id`,max(`ugp`.`dispatch_date`) AS `last_prasadam_sent_date` from (`users` `u` join `user_gift_prasadam` `ugp`) where ((`u`.`user_id` = `ugp`.`user_id`) and (`ugp`.`type` = 'Prasadam')) group by `u`.`user_id`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
