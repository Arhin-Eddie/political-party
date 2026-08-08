-- phpMyAdmin SQL Dump
-- Database: `political_party`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `political_party`
--
CREATE DATABASE IF NOT EXISTS `political_party` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `political_party`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
-- Default password is 'admin123'
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$ww6kY/Uuy.PvO.4ju2NvUeOKl7yMji38QwDK5KyCAtSAZ1StUWHie', '2024-05-15 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Unread','Read','Resolved') NOT NULL DEFAULT 'Unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'John Doe', 'john.doe@example.com', '555-0101', 'Question about membership', 'Hi, I would like to know if there are any fees associated with becoming a member.', 'Unread', '2024-05-14 14:30:00'),
(2, 'Jane Smith', 'jane.smith@example.com', '555-0102', 'Volunteering', 'I am interested in volunteering for the upcoming local election campaigns.', 'Read', '2024-05-13 09:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Upcoming','Completed','Cancelled') NOT NULL DEFAULT 'Upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `event_time`, `location`, `image`, `status`, `created_at`) VALUES
(1, 'Annual Party Convention', 'Join us for our annual convention where we will discuss policy platforms and elect new regional representatives.', '2024-09-15', '09:00:00', 'Grand City Convention Center', NULL, 'Upcoming', '2024-05-15 10:05:00'),
(2, 'Town Hall: Community First', 'A town hall meeting focusing on local infrastructure and community safety initiatives.', '2024-06-20', '18:30:00', 'Community Hall, Downtown', NULL, 'Upcoming', '2024-05-15 10:10:00'),
(3, 'Fundraising Gala', 'Our spring fundraising gala. Dinner, speeches, and networking.', '2024-04-10', '19:00:00', 'The Royal Hotel', NULL, 'Completed', '2024-03-01 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `leadership`
--

DROP TABLE IF EXISTS `leadership`;
CREATE TABLE `leadership` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `biography` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leadership`
--

INSERT INTO `leadership` (`id`, `name`, `position`, `biography`, `image`, `created_at`) VALUES
(1, 'Alice Johnson', 'Party President', 'Alice has been involved in public service for over 20 years, focusing on education and economic reform.', NULL, '2024-05-15 10:15:00'),
(2, 'Bob Williams', 'Vice President', 'Bob brings a wealth of experience from the private sector and champions innovation in government.', NULL, '2024-05-15 10:16:00'),
(3, 'Charlie Davis', 'Secretary General', 'Charlie manages the day-to-day operations of the party and coordinates our grassroots campaigns.', NULL, '2024-05-15 10:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `membership_type` varchar(50) NOT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `region`, `membership_type`, `status`, `created_at`) VALUES
(1, 'Sarah', 'Connor', 'sarah.c@example.com', '555-1234', '123 Main St', 'North', 'Standard', 'Approved', '2024-05-10 09:00:00'),
(2, 'Mike', 'Miller', 'mike.m@example.com', '555-5678', '456 Elm St', 'South', 'Student', 'Pending', '2024-05-14 11:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `published_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `published_at`, `created_at`) VALUES
(1, 'New Policy Initiative Announced', 'Today we are announcing a comprehensive new policy initiative aimed at improving local transit systems...', NULL, '2024-05-15 09:00:00', '2024-05-15 10:20:00'),
(2, 'Successful Campaign Launch', 'Our recent campaign launch in the central district saw record attendance. Thank you to all volunteers...', NULL, '2024-05-10 14:00:00', '2024-05-10 15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'party_name', 'Progressive Citizens Party'),
(2, 'contact_email', 'info@progressivecitizens.org'),
(3, 'contact_phone', '1-800-555-0199'),
(4, 'office_address', '100 Democracy Plaza, Capital City'),
(5, 'hero_title', 'Building a stronger future together.'),
(6, 'hero_subtitle', 'Learn about our vision, upcoming events and how you can become a member.'),
(7, 'hero_button_text', 'Become a Member'),
(8, 'hero_button_link', '/membership.php'),
(9, 'hero_image', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leadership`
--
ALTER TABLE `leadership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leadership`
--
ALTER TABLE `leadership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
