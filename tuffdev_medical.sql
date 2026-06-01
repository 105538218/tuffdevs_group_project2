-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 10:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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

INSERT INTO `jobs` (`JobReferenceNum`, `title`, `short_desc`, `salary`, `reporting_to`, `employment_type`, `location`, `responsibilities`, `essential_req`, `preferable_req`) VALUES
('TD001', 'Full Stack Developer', 'Design, develop and maintain both frontend and backend components of our web platform and application systems.', '$110,000 - $120,000 AUD', 'Lead Software Engineer', 'Full-time', 'Melbourne, Australia (Remote work available)', '[\"Build and maintain full stack web applications and sites\",\"Manage database design, optimisation and maintenance.\",\"Design and develop application programming interfaces (APIs).\",\"Stay updated with the latest technological advancements in software development.\"]', '[\"Fluent in English (written and spoken)\",\"Strong communication skills\",\"Experience in full stack web development\",\"Proficiency in several programming languages, such as HTML, CSS, JavaScript, PHP, Python etc\",\"Knowledge of database management systems such as MySQL etc\",\"Empathetic, patient and hardworking mindset\"]', '[\"Knowledge of cloud platforms such as AWS or Azure\",\"Multilingual\",\"Strong technical skills\"]'),
('TD002', 'Customer Service Representative', 'Provide real-time support to users via live chat.', '$55,000 - $65,000 AUD', 'Customer Service Manager', 'Full-time', 'Melbourne, Australia (Remote work available)', '[\"Respond to user enquiries via live chat in a professional and timely manner.\",\"Troubleshoot any errors related to accounts, appointments and site navigation.\",\"Maintain records of customer interactions in the CRM system.\",\"Maintain personal customer satisfaction ratings.\"]', '[\"Fluent in English (written and spoken)\",\"Strong communication skills\",\"Customer service experience\",\"Ability to multitask during chats\",\"Familiarity with CRM systems and helpdesk softwares\",\"Empathetic and patient with users\"]', '[\"Experience in healthcare industry\",\"Multilingual\",\"Strong technical skills\"]'),
('TD003', 'Content Writer', 'Create engaging and informative content for our health websites.', '$90,000 - $100,000 AUD', 'Head of Digital Content', 'Full-time', 'Melbourne, Australia (Remote work available)', '[\"Write clear and engaging content for our websites, blogs, newsletters and social media.\",\"Research and produce user-friendly health articles.\",\"Manage and update existing web content for accessibility.\",\"Proofread and edit content for accuracy and clarity.\"]', '[\"Fluent in English (written and spoken)\",\"Strong communication skills\",\"Experience in a writing or content creation role\",\"Creative and innovative mindset\",\"Knowledge of health and wellness topics\"]', '[\"Experience in the medical field\",\"Multilingual\",\"Strong editorial skills\"]');

-- --------------------------------------------------------

--
-- Table structure for table `members_contributions`
--

CREATE TABLE `members_contributions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `projectpart1_contribution` text DEFAULT NULL,
  `projectpart2_contribution` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members_contributions`
--

INSERT INTO `members_contributions` (`id`, `name`, `role`, `projectpart1_contribution`, `projectpart2_contribution`) VALUES
(1, 'Layan Almalek', 'Member', 'index.html', 'Task1: Create .inc files, convert pages to .php and include these files. Task2: Create settings.php. Task7: Create about table and update about.php.'),
(2, 'Kyla Solomon', 'Member', 'apply.html', 'Task3: Create Expression of Interest table and name it eoi. Task4: Add validated records (process_eoi.php).'),
(3, 'Saw Sheng Yang', 'Team Leader', 'jobs.html', 'Task5: Jobs table and jobs.php. Task6: HR manager queries (manage.php), authentication and create a login page to protect manage.php.'),
(4, 'Sandiv Wijesekera', 'Member', 'about.html', 'Task6: In manage.php page give options to the manager.'),
(5, 'Jermaine Michael', 'Member', 'faq.html', 'Additional tasks');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOINumber`),
  ADD KEY `fk_job_ref` (`JobReferenceNum`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`JobReferenceNum`);

--
-- Indexes for table `members_contributions`
--
ALTER TABLE `members_contributions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOINumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `members_contributions`
--
ALTER TABLE `members_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eoi`
--
ALTER TABLE `eoi`
  ADD CONSTRAINT `fk_job_ref` FOREIGN KEY (`JobReferenceNum`) REFERENCES `jobs` (`JobReferenceNum`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
