-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2021 at 10:14 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flashcards`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `nsection` (IN `s` VARCHAR(40), OUT `n` INT)  BEGIN
    SELECT count(id)
    INTO n
    FROM subject
    WHERE username=s;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastEdited` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`id`, `subject_id`, `question`, `answer`, `username`, `dateCreated`, `lastEdited`) VALUES
(18, 3, '1+1', '2', 'test', '2021-11-27 22:07:45', '2021-11-27 22:07:45'),
(19, 3, '1*1', '1', 'test', '2021-11-27 22:07:50', '2021-11-27 22:07:50'),
(20, 3, '9+10', '21', 'test', '2021-11-27 22:07:57', '2021-11-27 22:07:57'),
(21, 3, '2*5', '10', 'test', '2021-11-27 22:08:09', '2021-11-27 22:08:09'),
(22, 4, 'Who is William Shakespear?', 'A poet', 'test', '2021-11-27 22:09:01', '2021-11-27 22:09:01'),
(23, 4, 'Who wrote romeo and juilet', 'William shakespear', 'test', '2021-11-27 22:09:51', '2021-11-27 22:09:51'),
(24, 4, 'what is this symbol ?', 'question mark', 'test', '2021-11-27 22:10:44', '2021-11-27 22:10:44'),
(26, 3, '2*2', '4', 'test', '2021-11-27 22:40:48', '2021-11-27 22:40:48'),
(27, 3, '8+2', '10', 'test', '2021-11-27 22:40:55', '2021-11-27 22:40:55'),
(28, 3, '4+4', '8', 'test', '2021-11-27 22:41:00', '2021-11-27 22:41:00'),
(29, 3, '20+21', '41', 'test', '2021-11-27 22:41:09', '2021-11-27 22:41:09'),
(30, 3, '5*4', '20', 'test', '2021-11-27 22:41:17', '2021-11-27 22:41:17'),
(31, 3, '21-1', '20', 'test', '2021-11-27 22:41:29', '2021-11-27 22:41:29'),
(32, 4, 'What is this symbol .', 'period', 'test', '2021-11-27 22:41:45', '2021-11-27 22:41:45'),
(33, 4, 'What is this symbol !', 'exclamation mark', 'test', '2021-11-27 22:41:57', '2021-11-27 22:41:57'),
(34, 4, 'What is this symbol #', 'hashtag', 'test', '2021-11-27 22:42:06', '2021-11-27 22:42:06'),
(35, 4, 'What is this symbol ;', 'semi colon', 'test', '2021-11-27 22:42:20', '2021-11-27 22:42:20'),
(36, 4, 'What is this symbol :', 'colon', 'test', '2021-11-27 22:42:26', '2021-11-27 22:42:26'),
(37, 6, 'Who invented relitivity?', 'Albert Einstein', 'test', '2021-11-27 22:43:11', '2021-11-27 22:43:11'),
(38, 6, 'Who discovred gravity?', 'Issac Newton', 'test', '2021-11-27 22:43:25', '2021-11-27 22:43:25'),
(39, 6, 'Who invented heliocentric theory', 'Copernicus', 'test', '2021-11-27 22:44:19', '2021-11-27 22:44:19'),
(40, 6, 'Who invented geocentric theory?', 'Ptolmey', 'test', '2021-11-27 22:44:45', '2021-11-27 22:44:45'),
(41, 6, 'How many laws does newton have?', '3', 'test', '2021-11-27 22:45:19', '2021-11-27 22:45:19'),
(42, 6, 'Who is the scientist that has a well known picture of his tounge sticking out?', 'Albert Einstein', 'test', '2021-11-27 22:45:47', '2021-11-27 22:45:47'),
(43, 7, 'What is a int?', 'a number', 'test', '2021-11-27 22:46:00', '2021-11-27 22:46:00'),
(44, 7, 'What is a double?', 'a decimal number', 'test', '2021-11-27 22:46:10', '2021-11-27 22:46:10'),
(45, 7, 'What is a float', 'a decimal number', 'test', '2021-11-27 22:46:19', '2021-11-27 22:46:19'),
(46, 7, 'What is a long?', 'a decimal number', 'test', '2021-11-27 22:46:27', '2021-11-27 22:46:27'),
(47, 7, 'What is a String?', 'a word', 'test', '2021-11-27 22:46:39', '2021-11-27 22:46:39'),
(48, 7, 'What is a char?', 'a letter', 'test', '2021-11-27 22:46:57', '2021-11-27 22:46:57'),
(49, 7, 'What is a boolean?', 'T/F', 'test', '2021-11-27 22:47:11', '2021-11-27 22:47:11'),
(50, 7, 'test change', 'test change', 'test', '2021-11-27 22:48:08', '2021-11-27 22:48:08');

-- --------------------------------------------------------

--
-- Table structure for table `deletedsets`
--

CREATE TABLE `deletedsets` (
  `delSetID` int(10) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateDeleted` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deletedsets`
--

INSERT INTO `deletedsets` (`delSetID`, `dateCreated`, `dateDeleted`, `username`) VALUES
(5, '2021-11-27 22:07:17', '2021-11-27 22:42:34', 'test'),
(8, '2021-11-27 23:04:24', '2021-11-27 23:04:31', 'test123'),
(9, '2021-11-27 23:04:36', '2021-11-27 23:05:23', 'test123'),
(10, '2021-11-27 23:05:36', '2021-11-27 23:06:10', 'test123'),
(11, '2021-11-29 13:49:59', '2021-11-29 13:50:52', 'test'),
(13, '2021-12-01 18:52:31', '2021-12-01 18:52:48', 'test'),
(14, '2021-12-01 19:03:21', '2021-12-01 19:14:18', 'test'),
(15, '2021-12-01 19:11:48', '2021-12-01 19:11:53', 'test'),
(16, '2021-12-01 19:11:59', '2021-12-01 19:13:01', 'test'),
(17, '2021-12-01 19:12:06', '2021-12-01 19:12:57', 'test'),
(18, '2021-12-01 19:12:10', '2021-12-01 19:12:49', 'test'),
(19, '2021-12-01 19:13:09', '2021-12-01 19:14:18', 'test'),
(20, '2021-12-01 19:13:12', '2021-12-01 19:14:18', 'test'),
(21, '2021-12-01 19:13:20', '2021-12-01 19:14:18', 'test'),
(22, '2021-12-01 19:13:43', '2021-12-01 19:14:18', 'test'),
(23, '2021-12-01 19:13:45', '2021-12-01 19:14:18', 'test'),
(24, '2021-12-01 19:13:47', '2021-12-01 19:14:18', 'test'),
(25, '2021-12-01 19:13:47', '2021-12-01 19:14:18', 'test'),
(26, '2021-12-01 19:13:48', '2021-12-01 19:14:18', 'test'),
(27, '2021-12-01 19:13:48', '2021-12-01 19:14:18', 'test'),
(28, '2021-12-01 19:13:49', '2021-12-01 19:14:18', 'test'),
(29, '2021-12-01 19:13:50', '2021-12-01 19:14:18', 'test'),
(30, '2021-12-01 19:14:31', '2021-12-01 19:15:43', 'test'),
(31, '2021-12-01 19:14:38', '2021-12-01 19:14:49', 'test'),
(32, '2021-12-01 19:14:40', '2021-12-01 19:15:01', 'test'),
(33, '2021-12-01 19:14:41', '2021-12-01 19:15:01', 'test'),
(34, '2021-12-01 19:14:42', '2021-12-01 19:15:01', 'test'),
(35, '2021-12-01 19:15:32', '2021-12-01 19:15:43', 'test'),
(36, '2021-12-01 19:15:34', '2021-12-01 19:15:43', 'test'),
(37, '2021-12-01 19:15:35', '2021-12-01 19:15:43', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(32) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastUpdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subject_name`, `dateCreated`, `lastUpdate`, `username`) VALUES
(3, 'math', '2021-11-27 22:07:11', '2021-11-27 22:07:11', 'test'),
(4, 'english', '2021-11-27 22:07:14', '2021-11-27 22:07:14', 'test'),
(6, 'science', '2021-11-27 22:07:20', '2021-11-27 22:07:20', 'test'),
(7, 'programming', '2021-11-27 22:07:23', '2021-11-27 22:07:23', 'test'),
(38, 'test', '2021-12-01 21:13:32', '2021-12-01 21:13:32', 'test');

--
-- Triggers `subject`
--
DELIMITER $$
CREATE TRIGGER `delSetsTrig` AFTER DELETE ON `subject` FOR EACH ROW BEGIN
    INSERT INTO deletedSets(delSetID, dateCreated, username) VALUES(old.id, old.dateCreated, old.username);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `loginNum` int(100) NOT NULL,
  `latestLog` datetime DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `loginNum`, `latestLog`, `isAdmin`) VALUES
(4, 'test123', '$2y$10$.YlIrIkrnvg22Ad93AeFteB0LzemT093uHZTWMvhOxU5QKkFvqCaa', '2021-11-27 17:05:17', 1, '2021-11-27 18:03:56', 0),
(5, 'test', '$2y$10$XySbBVwsasCDzVyZgAFGDuZrnLzxP3KdJ4sLC848MRaUmjTTLGR8O', '2021-11-27 17:05:26', 8, '2021-12-01 16:11:26', 0),
(6, 'admin', '$2y$10$t5LmJljl5k05v8bwpZUPrOYiqDOFzrL9UPpIHowJHzUbsMPXhXMZC', '2021-11-27 17:05:38', 3, '2021-12-01 12:58:20', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_card_subject_id__subject_subject_id` (`subject_id`),
  ADD KEY `cardid` (`id`),
  ADD KEY `cardbyuser` (`username`);

--
-- Indexes for table `deletedsets`
--
ALTER TABLE `deletedsets`
  ADD PRIMARY KEY (`delSetID`),
  ADD KEY `delset` (`delSetID`),
  ADD KEY `delsetbyuser` (`username`),
  ADD KEY `username` (`username`) USING BTREE;

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniquename` (`subject_name`),
  ADD KEY `subjectid` (`id`),
  ADD KEY `usersubject` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id` (`id`),
  ADD KEY `isadmin` (`isAdmin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `fk_card_subject_id__subject_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deletedsets`
--
ALTER TABLE `deletedsets`
  ADD CONSTRAINT `fkusername` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `usersubject` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
