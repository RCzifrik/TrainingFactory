-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2023 at 10:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trainingfactory`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230613081343', '2023-06-14 08:37:19', 157),
('DoctrineMigrations\\Version20230614065058', '2023-06-14 08:52:32', 46),
('DoctrineMigrations\\Version20230614065715', '2023-06-14 08:57:43', 39),
('DoctrineMigrations\\Version20230614065951', '2023-06-14 09:00:12', 39),
('DoctrineMigrations\\Version20230614070105', '2023-06-14 09:01:43', 39),
('DoctrineMigrations\\Version20230614070919', '2023-06-14 09:10:03', 563),
('DoctrineMigrations\\Version20230614081357', '2023-06-14 10:14:39', 17),
('DoctrineMigrations\\Version20230619124504', '2023-06-19 14:45:27', 27);

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `max_people` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `training_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `time`, `date`, `location`, `max_people`, `instructor_id`, `training_id`) VALUES
(1, '14:20:00', '2023-10-13', 'Sasboutstreet 54', 12, 2, 1),
(2, '13:00:00', '2023-06-20', 'Sasboutstreet 54', 15, 8, 3),
(3, '15:30:00', '2023-06-20', 'Sasboutstreet 54', 6, 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `payment` decimal(10,2) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `payment`, `member_id`, `lesson_id`) VALUES
(1, '13.99', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id` int(11) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `extra_costs` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`id`, `description`, `duration`, `extra_costs`) VALUES
(1, 'Kickboxing', 90, '9.99'),
(2, 'MMA', 90, '7.99'),
(3, 'Brazilian Jiu-Jitsu', 120, '12.99');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `preprovision` varchar(15) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `dateofbirth` date NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `salary` decimal(12,2) DEFAULT NULL,
  `social_sec_number` int(11) DEFAULT NULL,
  `hiring_date` date DEFAULT NULL,
  `is_trainer` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `firstname`, `preprovision`, `lastname`, `dateofbirth`, `street`, `place`, `salary`, `social_sec_number`, `hiring_date`, `is_trainer`) VALUES
(1, 'member', '[\"ROLE_MEMBER\"]', '$2y$13$vi/5U/0sEU3gF2uHqE7tJuTUBvvfj/865O/AuGPoFcigwaEO18LIq', 'Richard', '', 'Czifrik', '2003-11-13', 'Voorstraat 22', 'Delft', NULL, NULL, NULL, NULL),
(2, 'instructor', '[\"ROLE_INSTRUCTOR\"]', '$2y$13$vi/5U/0sEU3gF2uHqE7tJuTUBvvfj/865O/AuGPoFcigwaEO18LIq', 'Samuel', NULL, 'Rodriguez', '1983-10-01', '', '', '123456789.99', 192837465, '2023-06-13', 1),
(6, 'InferiorGamer', '[\"ROLE_ADMIN\"]', '$2y$13$KaEKMiJ5f6Fw3OOHXxVjV.iiwygvdwfH8ctY4SkHoFtee6Qb0LzmK', 'Michael', 'van', 'Dijk', '2003-04-26', 'Brasserskade 134', 'Delft', NULL, NULL, NULL, NULL),
(7, 'newUser01', '[\"ROLE_MEMBER\"]', '$2y$13$TOkjcH5yOU86ohPrABG9ZOWWIxyUPT7bYbJGU7mFWjNS9GO4Sxdsy', 'New', NULL, 'User', '1990-01-01', 'Roland Holstlaan 979', 'Delft', NULL, NULL, NULL, NULL),
(8, 'Trainer2', '[\"ROLES_INSTRUCTOR\"]', '$2y$13$vi/5U/0sEU3gF2uHqE7tJuTUBvvfj/865O/AuGPoFcigwaEO18LIq', 'Henk', 'de', 'Boom', '1995-04-01', NULL, NULL, '4.99', 102938475, '2022-10-05', 1),
(9, 'Trainer3', '[\"ROLES_INSTRUCTOR\"]', '$2y$13$vi/5U/0sEU3gF2uHqE7tJuTUBvvfj/865O/AuGPoFcigwaEO18LIq', 'Mike', NULL, 'Hawk', '1990-06-06', NULL, NULL, '5.01', 19283746, '2019-05-19', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F87474F38C4FC193` (`instructor_id`),
  ADD KEY `IDX_F87474F3BEFD98D1` (`training_id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_62A8A7A77597D3FE` (`member_id`),
  ADD KEY `IDX_62A8A7A7CDF80196` (`lesson_id`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `FK_F87474F38C4FC193` FOREIGN KEY (`instructor_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F87474F3BEFD98D1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`);

--
-- Constraints for table `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `FK_62A8A7A77597D3FE` FOREIGN KEY (`member_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_62A8A7A7CDF80196` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
