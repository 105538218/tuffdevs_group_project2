-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 29, 2026 at 12:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tuffdev_medical`
--

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOINumber` int(11) NOT NULL,
  `JobReferenceNum` varchar(5) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` enum('Prefer not to say','Non-binary','Male','Female') NOT NULL,
  `StreetAddress` varchar(40) NOT NULL,
  `SuburbTown` varchar(40) NOT NULL,
  `State` enum('VIC','NSW','QLD','NT','WA','SA','TAS','ACT') NOT NULL,
  `PostCode` int(4) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNum` int(10) NOT NULL,
  `SkillList` varchar(255) NOT NULL,
  `OtherSkills` text DEFAULT NULL,
  `CV` mediumblob NOT NULL,
  `CoverLetter` mediumblob NOT NULL,
  `Status` set('New','Current','Final') NOT NULL DEFAULT 'New'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `JobReferenceNum` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `short_desc` text NOT NULL,
  `salary` varchar(50) NOT NULL,
  `reporting_to` varchar(100) NOT NULL,
  `employment_type` varchar(50) NOT NULL,
  `location` varchar(150) NOT NULL,
  `responsibilities` text NOT NULL,
  `essential_req` text NOT NULL,
  `preferable_req` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `JobReferenceNum`, `title`, `short_desc`, `salary`, `reporting_to`, `employment_type`, `location`, `responsibilities`, `essential_req`, `preferable_req`) VALUES
(1, 'TD001', 'Full Stack Developer', 'Design, develop and maintain both frontend and backend components of our web platform and application systems.', '$110,000 - $120,000 AUD', 'Lead Software Engineer', 'Full-time', 'Melbourne, Australia (Remote work available)', '[\"Build and maintain full stack web applications and sites\",\"Manage database design, optimisation and maintenance.\",\"Design and develop application programming interfaces (APIs).\",\"Stay updated with the latest technological advancements in software development.\"]', '[\"Fluent in English (written and spoken)\",\"Strong communication skills\",\"Experience in full stack web development\",\"Proficiency in several programming languages, such as HTML, CSS, JavaScript, PHP, Python etc\",\"Knowledge of database management systems such as MySQL etc\",\"Empathetic, patient and hardworking mindset\"]', '[\"Knowledge of cloud platforms such as AWS or Azure\",\"Multilingual\",\"Strong technical skills\"]'),
(2, 'TD002', 'Customer Service Representative', 'Provide real-time support to users via live chat.', '$55,000 - $65,000 AUD', 'Customer Service Manager', 'Full-time', 'Melbourne, Australia (Remote work available)', '[\"Respond to user enquiries via live chat in a professional and timely manner.\",\"Troubleshoot any errors related to accounts, appointments and site navigation.\",\"Maintain records of customer interactions in the CRM system.\",\"Maintain personal customer satisfaction ratings.\"]', '[\"Fluent in English (written and spoken)\",\"Strong communication skills\",\"Customer service experience\",\"Ability to multitask during chats\",\"Familiarity with CRM systems and helpdesk softwares\",\"Empathetic and patient with users\"]', '[\"Experience in healthcare industry\",\"Multilingual\",\"Strong technical skills\"]'),
(3, 'TD003', 'Content Writer', 'Create engaging and informative content for our health websites.', '$90,000 - $100,000 AUD', 'Head of Digital Content', 'Full-time', 'Melbourne, Australia (Remote work available)', '[\"Write clear and engaging content for our websites, blogs, newsletters and social media.\",\"Research and produce user-friendly health articles.\",\"Manage and update existing web content for accessibility.\",\"Proofread and edit content for accuracy and clarity.\"]', '[\"Fluent in English (written and spoken)\",\"Strong communication skills\",\"Experience in a writing or content creation role\",\"Creative and innovative mindset\",\"Knowledge of health and wellness topics\"]', '[\"Experience in the medical field\",\"Multilingual\",\"Strong editorial skills\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOINumber`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `JobReferenceNum` (`JobReferenceNum`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOINumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
