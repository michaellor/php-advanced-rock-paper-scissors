-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost:8080
-- Generation Time: Mar 08, 2016 at 03:13 PM
-- Server version: 5.7.10
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rps`
--
CREATE DATABASE IF NOT EXISTS `rps` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `rps`;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player_one_id` int(11) DEFAULT NULL,
  `player_one_score` int(11) DEFAULT NULL,
  `player_two_id` int(11) DEFAULT NULL,
  `player_two_score` int(11) DEFAULT NULL,
  `winner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`id`, `player_one_id`, `player_one_score`, `player_two_id`, `player_two_score`, `winner_id`) VALUES
(1, 3, 0, 2, 0, 0),
(2, 2, 0, 4, 0, 0),
(3, 3, 0, 2, 0, 0),
(4, 2, 0, 1, 0, 0),
(5, 3, 0, 2, 0, 0),
(6, 4, 0, 2, 0, 0),
(7, 3, 0, 1, 0, 0),
(8, 1, 0, 3, 0, 0),
(9, 1, 0, 3, 0, 0),
(10, 1, 0, 3, 0, 0),
(11, 3, 0, 2, 0, 0),
(12, 3, 0, 2, 0, 0),
(13, 1, 0, 2, 0, 0),
(14, 2, 0, 4, 0, 0),
(15, 2, 0, 2, 0, 0),
(16, 4, 0, 2, 0, 0),
(17, 2, 0, 4, 0, 0),
(18, 1, 0, 2, 0, 0),
(19, 2, 0, 1, 0, 0),
(20, 3, 0, 2, 0, 0),
(21, 1, 1, 2, 0, 1),
(22, 3, 2, 2, 2, 3),
(23, 1, 0, -1, 1, 1),
(24, 1, 0, 2, 0, 0),
(25, 1, 1, 2, 2, 1),
(26, 1, 5, 4, 4, 4),
(27, 1, 0, -1, 0, 0),
(28, 1, 0, -1, 0, 0),
(29, 1, 2, 2, 0, 1),
(30, 1, 0, 3, 0, 0),
(31, 1, 2, 3, 4, 1),
(32, 1, 0, 2, 3, 2),
(33, 1, 0, 3, 2, 3),
(34, 1, 0, 2, 0, 0),
(35, 1, 2, 2, 0, 1),
(36, 1, 0, 2, 0, 0),
(37, 1, 0, -1, 0, 0),
(38, 1, 0, -1, 0, 0),
(39, 1, 0, -1, 0, 0),
(40, 1, 2, -1, 3, -1),
(41, 1, 0, 3, 0, 0),
(42, 1, 0, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `name`, `password`) VALUES
(1, 'Nic', 'supersecret'),
(2, 'The Rock', ''),
(3, 'Aundra', ''),
(4, 'Tanklin', 'beast');

-- --------------------------------------------------------

--
-- Table structure for table `rounds`
--

CREATE TABLE `rounds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player_one_id` int(11) DEFAULT NULL,
  `player_one_choice` varchar(255) DEFAULT NULL,
  `player_two_id` int(11) DEFAULT NULL,
  `player_two_choice` varchar(255) DEFAULT NULL,
  `winner_id` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rounds`
--

INSERT INTO `rounds` (`id`, `player_one_id`, `player_one_choice`, `player_two_id`, `player_two_choice`, `winner_id`, `match_id`) VALUES
(1, 1, 'rock', -1, 'scissors', 1, NULL),
(2, 1, 'rock', 2, 'rock', 0, NULL),
(3, 1, 'rock', 2, 'sponge', 1, NULL),
(4, 1, 'scissors', 2, 'rock', 2, NULL),
(5, 2, 'fire', 1, 'water', 1, NULL),
(6, 1, 'rock', -1, 'paper', -1, NULL),
(7, 1, 'fire', 2, 'rock', 2, NULL),
(8, 1, 'rock', -1, 'fire', 1, NULL),
(9, 3, 'water', 1, 'sponge', 1, NULL),
(10, 1, 'rock', -1, 'sponge', 1, NULL),
(11, 1, 'scissors', 2, 'fire', 2, NULL),
(12, 1, 'water', -1, 'fire', 1, NULL),
(13, 1, 'fire', -1, 'air', -1, NULL),
(14, 3, 'paper', 2, 'rock', 3, NULL),
(15, 4, 'paper', 2, 'rock', 4, NULL),
(16, 1, 'scissors', 4, 'paper', 1, NULL),
(17, 1, 'scissors', 2, 'air', 1, NULL),
(18, 1, 'rock', 2, 'scissors', 1, NULL),
(19, 1, 'scissors', 2, 'rock', 2, NULL),
(20, 3, 'sponge', 1, 'scissors', 1, NULL),
(21, 1, 'rock', -1, 'paper', -1, NULL),
(22, 1, 'rock', -1, 'scissors', 1, NULL),
(23, 1, 'sponge', -1, 'sponge', 0, NULL),
(24, 1, 'fire', 2, 'air', 2, NULL),
(25, 1, 'sponge', 2, 'water', 1, NULL),
(26, 1, 'scissors', 2, 'fire', 2, NULL),
(27, 1, 'air', 2, 'fire', 1, NULL),
(28, 1, 'paper', 2, 'air', 1, NULL),
(29, 3, 'scissors', 4, 'sponge', 3, NULL),
(30, 3, 'scissors', 4, 'sponge', 3, NULL),
(31, 3, 'scissors', 4, 'sponge', 3, NULL),
(32, 1, 'rock', 2, 'paper', 2, NULL),
(33, 1, 'sponge', 2, 'water', 1, NULL),
(34, 1, 'scissors', 2, 'rock', 2, NULL),
(35, 2, 'rock', 1, 'fire', 2, NULL),
(36, 2, 'rock', 1, 'fire', 2, NULL),
(37, 2, 'rock', 1, 'sponge', 2, NULL),
(38, 2, 'rock', 1, 'rock', 0, NULL),
(39, 2, 'rock', 4, 'fire', 2, NULL),
(40, 2, 'paper', 4, 'air', 2, NULL),
(41, 2, 'rock', 4, 'scissors', 2, NULL),
(42, 2, 'scissors', 4, 'rock', 4, NULL),
(43, 2, 'scissors', 4, 'rock', 4, NULL),
(44, 2, 'scissors', 4, 'rock', 4, NULL),
(45, 2, 'scissors', 4, 'rock', 4, NULL),
(46, 2, 'scissors', 4, 'rock', 4, NULL),
(47, 2, 'scissors', 4, 'rock', 4, NULL),
(48, 1, 'rock', 2, 'fire', 1, NULL),
(49, 1, 'rock', 2, 'scissors', 1, NULL),
(50, 1, 'rock', 2, 'fire', 1, NULL),
(51, 1, 'scissors', 2, 'rock', 2, NULL),
(52, 1, 'rock', 2, 'fire', 1, NULL),
(53, 2, 'sponge', 3, 'scissors', 3, NULL),
(54, 2, 'paper', 3, 'rock', 2, NULL),
(55, 2, 'rock', 3, 'paper', 3, NULL),
(56, 1, 'rock', -1, 'rock', 0, NULL),
(57, 1, 'scissors', -1, 'sponge', 1, NULL),
(58, 1, 'sponge', -1, 'sponge', 0, NULL),
(59, 1, 'sponge', -1, 'paper', 1, NULL),
(60, 1, 'air', -1, 'fire', 1, NULL),
(61, 1, 'water', -1, 'scissors', 1, NULL),
(62, 1, 'rock', -1, 'scissors', 1, NULL),
(63, 1, 'rock', -1, 'rock', 0, NULL),
(64, 1, 'rock', -1, 'air', -1, NULL),
(65, 1, 'rock', -1, 'water', -1, NULL),
(66, 1, 'rock', -1, 'water', -1, NULL),
(67, 1, 'rock', -1, 'water', -1, NULL),
(68, 1, 'rock', -1, 'air', -1, NULL),
(69, 1, 'rock', -1, 'water', -1, NULL),
(70, 1, 'rock', -1, 'scissors', 1, NULL),
(71, 1, 'rock', -1, 'rock', 0, NULL),
(72, 1, 'rock', -1, 'paper', -1, NULL),
(73, 1, 'rock', -1, 'sponge', 1, NULL),
(74, 1, 'rock', -1, 'air', -1, NULL),
(75, 1, 'rock', -1, 'fire', 1, NULL),
(76, 1, 'rock', -1, 'scissors', 1, NULL),
(77, 1, 'rock', -1, 'sponge', 1, NULL),
(78, 1, 'rock', -1, 'paper', -1, NULL),
(79, 1, 'rock', -1, 'rock', 0, NULL),
(80, 1, 'rock', -1, 'paper', -1, NULL),
(81, 1, 'rock', -1, 'scissors', 1, NULL),
(82, 1, 'rock', -1, 'water', -1, NULL),
(83, 1, 'rock', -1, 'water', -1, NULL),
(84, 1, 'rock', -1, 'rock', 0, NULL),
(85, 1, 'rock', -1, 'rock', 0, NULL),
(86, 1, 'rock', -1, 'fire', 1, NULL),
(87, 1, 'scissors', 2, 'paper', 1, 0),
(88, 1, 'rock', 2, 'water', 2, 0),
(89, 1, 'sponge', 2, 'rock', 2, 0),
(90, 3, 'rock', 2, 'rock', 0, 0),
(91, 3, 'water', 2, 'rock', 3, 0),
(92, 3, 'rock', 2, 'scissors', 3, 0),
(93, 3, 'scissors', 2, 'water', 2, 0),
(94, 2, 'fire', 4, 'water', 4, 0),
(95, 2, 'water', 1, 'rock', 2, 0),
(96, 3, 'rock', 2, 'rock', 0, 0),
(97, 4, 'rock', 2, 'rock', 0, 0),
(98, 3, 'rock', 1, 'rock', 0, 0),
(99, 1, 'rock', 3, 'rock', 0, 0),
(100, 1, 'rock', 3, 'rock', 0, 0),
(101, 1, 'sponge', 3, 'paper', 1, 0),
(102, 1, 'sponge', 3, 'scissors', 3, 0),
(103, 1, 'paper', 3, 'fire', 3, 0),
(104, 1, 'paper', 3, 'scissors', 3, 0),
(105, 1, 'fire', 3, 'scissors', 1, 0),
(106, 1, 'scissors', 3, 'scissors', 0, 0),
(107, 1, 'rock', 3, 'rock', 0, 0),
(108, 1, 'sponge', 3, 'paper', 1, 0),
(109, 1, 'rock', 3, 'rock', 0, 10),
(110, 1, 'rock', 3, 'scissors', 1, 10),
(111, 1, 'scissors', 3, 'air', 1, 10),
(112, 1, 'scissors', 3, 'scissors', 0, 10),
(113, 1, 'fire', 3, 'air', 3, 10),
(114, 1, 'rock', 3, 'sponge', 1, 10),
(115, 1, 'paper', 3, 'rock', 1, 10),
(116, 1, 'rock', 3, 'sponge', 1, 10),
(117, 1, 'scissors', 3, 'rock', 3, 10),
(118, 1, 'scissors', 3, 'rock', 3, 10),
(119, 2, 'fire', 4, 'rock', 4, 14),
(120, 2, 'fire', 4, 'rock', 4, 14),
(121, 2, 'rock', 4, 'scissors', 2, 14),
(122, 2, 'rock', 4, 'scissors', 2, 14),
(123, 4, 'rock', 2, 'scissors', 4, 16),
(124, 4, 'rock', 2, 'scissors', 4, 16),
(125, 4, 'rock', 2, 'scissors', 4, 16),
(126, 4, 'scissors', 2, 'rock', 2, 16),
(127, 4, 'fire', 2, 'rock', 2, 16),
(128, 4, 'rock', 2, 'scissors', 4, 16),
(129, 4, 'fire', 2, 'rock', 2, 16),
(130, 1, 'scissors', 2, 'rock', 2, 18),
(131, 2, 'fire', 1, 'rock', 1, 19),
(132, 2, 'fire', 1, 'rock', 1, 19),
(133, 3, 'scissors', 2, 'rock', 2, 20),
(134, 3, 'rock', 2, 'sponge', 3, 20),
(135, 3, 'fire', 2, 'rock', 2, 20),
(136, 3, 'scissors', 2, 'rock', 2, 20),
(137, 1, 'rock', 2, 'fire', 1, 21),
(138, 3, 'sponge', 2, 'paper', 3, 22),
(139, 3, 'scissors', 2, 'rock', 2, 22),
(140, 3, 'sponge', 2, 'paper', 3, 22),
(141, 3, 'scissors', 2, 'rock', 2, 22),
(142, 1, 'rock', -1, 'water', -1, 23),
(143, 1, 'rock', -1, 'fire', 1, 23),
(144, 1, 'rock', -1, 'paper', -1, 23),
(145, 1, 'rock', -1, 'rock', 0, 23),
(146, 1, 'rock', -1, 'water', -1, 23),
(147, 1, 'rock', -1, 'fire', 1, 23),
(148, 1, 'rock', -1, 'air', -1, 23),
(149, 1, 'rock', -1, 'paper', -1, 23),
(150, 1, 'rock', -1, 'rock', 0, 23),
(151, 1, 'rock', -1, 'water', -1, 23),
(152, 1, 'rock', -1, 'fire', 1, 23),
(153, 1, 'rock', -1, 'sponge', 1, 23),
(154, 1, 'rock', -1, 'fire', 1, 23),
(155, 1, 'rock', -1, 'paper', -1, 23),
(156, 1, 'rock', -1, 'paper', -1, 23),
(157, 1, 'rock', -1, 'fire', 1, 23),
(158, 1, 'rock', -1, 'scissors', 1, 23),
(159, 1, 'rock', -1, 'scissors', 1, 23),
(160, 1, 'rock', -1, 'air', -1, 23),
(161, 1, 'rock', -1, 'fire', 1, 23),
(162, 1, 'rock', -1, 'air', -1, 23),
(163, 1, 'rock', -1, 'paper', -1, 23),
(164, 1, 'rock', -1, 'sponge', 1, 23),
(165, 1, 'rock', -1, 'scissors', 1, 23),
(166, 1, 'scissors', 2, 'sponge', 1, 24),
(167, 1, 'rock', 2, 'scissors', 1, 24),
(168, 1, 'scissors', 2, 'rock', 2, 24),
(169, 2, 'air', 4, 'rock', 2, 0),
(170, 1, 'rock', 2, 'scissors', 1, 0),
(171, 1, 'rock', 2, 'air', 2, 0),
(172, 1, 'scissors', 2, 'rock', 2, 0),
(173, 1, 'rock', 2, 'water', 2, 0),
(174, 1, 'fire', 2, 'rock', 2, 0),
(175, 1, 'rock', 4, 'sponge', 1, 0),
(176, 1, 'fire', 2, 'rock', 2, 0),
(177, 1, 'fire', 2, 'rock', 2, 0),
(178, 1, 'sponge', 2, 'rock', 2, 0),
(179, 4, 'fire', 2, 'scissors', 4, 0),
(180, 1, 'rock', 2, 'scissors', 1, 0),
(181, 1, 'scissors', 2, 'rock', 2, 0),
(182, 1, 'sponge', 2, 'sponge', 0, 25),
(183, 1, 'fire', 2, 'rock', 2, 25),
(184, 1, 'rock', 2, 'rock', 0, 25),
(185, 1, 'rock', 2, 'scissors', 1, 25),
(186, 1, 'scissors', 2, 'rock', 2, 25),
(187, 1, 'rock', 4, 'scissors', 1, 26),
(188, 1, 'rock', 4, 'scissors', 1, 26),
(189, 1, 'rock', 4, 'rock', 0, 26),
(190, 1, 'rock', 4, 'paper', 4, 26),
(191, 1, 'fire', 4, 'rock', 4, 26),
(192, 1, 'rock', 4, 'fire', 1, 26),
(193, 1, 'rock', 4, 'fire', 1, 26),
(194, 1, 'rock', 4, 'rock', 0, 26),
(195, 1, 'rock', 4, 'fire', 1, 26),
(196, 1, 'scissors', 4, 'rock', 4, 26),
(197, 1, 'scissors', 4, 'rock', 4, 26),
(198, 1, 'paper', 2, 'rock', 1, 29),
(199, 1, 'paper', 2, 'rock', 1, 29),
(200, 1, 'paper', 2, 'rock', 1, 29),
(201, 1, 'paper', 2, 'rock', 1, 29),
(202, 1, 'paper', 2, 'rock', 1, 29),
(203, 1, 'rock', 3, 'paper', 3, 31),
(204, 1, 'rock', 3, 'paper', 3, 31),
(205, 1, 'rock', 3, 'paper', 3, 31),
(206, 1, 'rock', 3, 'paper', 3, 31),
(207, 1, 'paper', 3, 'rock', 1, 31),
(208, 1, 'paper', 3, 'rock', 1, 31),
(209, 1, 'rock', 2, 'paper', 2, 32),
(210, 1, 'rock', 2, 'paper', 2, 32),
(211, 1, 'rock', 2, 'paper', 2, 32),
(212, 1, 'rock', 3, 'paper', 3, 33),
(213, 1, 'rock', 3, 'paper', 3, 33),
(214, 1, 'rock', 2, 'fire', 1, 35),
(215, 1, 'rock', 2, 'fire', 1, 35),
(216, 1, 'rock', -1, 'paper', -1, 40),
(217, 1, 'rock', -1, 'fire', 1, 40),
(218, 1, 'rock', -1, 'rock', 0, 40),
(219, 1, 'rock', -1, 'scissors', 1, 40),
(220, 1, 'rock', -1, 'water', -1, 40),
(221, 1, 'rock', -1, 'air', -1, 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `rounds`
--
ALTER TABLE `rounds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rounds`
--
ALTER TABLE `rounds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
