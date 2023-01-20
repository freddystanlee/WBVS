-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2021 at 05:40 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wbvs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL,
  `adminuname` varchar(255) NOT NULL,
  `adminpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `adminuname`, `adminpassword`) VALUES
(1, 'admin', '$2y$10$2wdGtfl/4oj2Jn5kzMCYeeF7mYnipnwksIGZwiTuzfI8RczX7WOka');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `candidateid` int(11) NOT NULL,
  `candidatename` varchar(255) NOT NULL,
  `candidatedesc` longtext NOT NULL,
  `candidateimage` varchar(255) NOT NULL,
  `votes` int(11) NOT NULL,
  `sessionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`candidateid`, `candidatename`, `candidatedesc`, `candidateimage`, `votes`, `sessionid`) VALUES
(49, 'Lionel Messi', 'Argentina', 'Lionel Messi60ef3ddf0dfde.jpg', 1, 38),
(50, 'Ronaldo', 'Portugal', 'Ronaldo60ef3ddf0ebbd.jpg', 0, 38),
(51, 'Neymar', 'Brazil', 'Neymar60ef3ddf0f89b.jpg', 1, 38);

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `participantid` int(11) NOT NULL,
  `votecasted` int(11) NOT NULL,
  `sessionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`participantid`, `votecasted`, `sessionid`, `userid`) VALUES
(17, 1, 38, 20),
(18, 1, 38, 19);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `requestid` int(11) NOT NULL,
  `requestname` varchar(255) NOT NULL,
  `requestdesc` longtext NOT NULL,
  `candidates` longtext NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`requestid`, `requestname`, `requestdesc`, `candidates`, `userid`) VALUES
(3, 'Which one is delicious?', 'There are many kinds of foods in this world', 'fried rice, mie goreng', 19);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `fullname`, `username`, `email`, `password`, `gender`, `avatar`) VALUES
(19, 'Edward Newgate', 'edward', 'freddy@mail.com', '$2y$10$q8IlqlqOTu3ODT24oVyHOeDw3ld3wenz8zHBI.2LZwxjFQ4Mxu0N2', 'Male', '19.jpg'),
(20, 'Katie', 'kate123', 'kate@gmail.com', '$2y$10$eNvL.VpOeneAyCpNixe6guvpyHACIv80c55BEy5ao3eKBhkitpH5i', 'Male', 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `votingsession`
--

CREATE TABLE `votingsession` (
  `sessionid` int(11) NOT NULL,
  `sessionname` varchar(255) NOT NULL,
  `sessiondesc` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `votingsession`
--

INSERT INTO `votingsession` (`sessionid`, `sessionname`, `sessiondesc`) VALUES
(38, 'Who is the best player in the world?', 'These players have played football for more than a decade');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`candidateid`),
  ADD KEY `Link to sessionid` (`sessionid`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`participantid`),
  ADD KEY `sessionid` (`sessionid`),
  ADD KEY `link to userid` (`userid`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`requestid`),
  ADD KEY `request from user` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `votingsession`
--
ALTER TABLE `votingsession`
  ADD PRIMARY KEY (`sessionid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participantid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `requestid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `votingsession`
--
ALTER TABLE `votingsession`
  MODIFY `sessionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `Link to sessionid` FOREIGN KEY (`sessionid`) REFERENCES `votingsession` (`sessionid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `link to userid` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`sessionid`) REFERENCES `votingsession` (`sessionid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request from user` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
