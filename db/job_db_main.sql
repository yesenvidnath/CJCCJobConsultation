-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2023 at 11:48 PM
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
-- Database: `job_db_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `AD_Name` varchar(100) DEFAULT NULL,
  `AD_Email` varchar(255) DEFAULT NULL,
  `AD_Discription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `User_ID`, `AD_Name`, `AD_Email`, `AD_Discription`) VALUES
(1, 1, 'Admin User', 'admin@example.com', 'System administrator responsible for managing the platform.');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `Appli_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Appli_Img` varchar(255) DEFAULT NULL,
  `Appli_First_Name` varchar(100) NOT NULL,
  `Appli_Last_Name` varchar(100) NOT NULL,
  `Appli_Address` varchar(255) DEFAULT NULL,
  `Appli_Skype_ID` varchar(100) DEFAULT NULL,
  `Appli_TP_No` varchar(20) DEFAULT NULL,
  `Appli_DOB` date DEFAULT NULL,
  `Appli_Resume` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`Appli_ID`, `User_ID`, `Appli_Img`, `Appli_First_Name`, `Appli_Last_Name`, `Appli_Address`, `Appli_Skype_ID`, `Appli_TP_No`, `Appli_DOB`, `Appli_Resume`) VALUES
(1, 4, 'assets/appli_imgs/john.jpg', 'John', 'Doe', '123 Main St', 'john.doe.skype', '+123456789', '1990-05-15', 'Resume URL 1'),
(2, 5, 'assets/appli_imgs/jane.jpg', 'Jane', 'Smithson', '456 Elm St', 'jane.smith.skype', '+987654355', '1985-12-30', 'Resume URL 2');

-- --------------------------------------------------------

--
-- Table structure for table `consultant`
--

CREATE TABLE `consultant` (
  `Con_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Con_Img` varchar(255) DEFAULT NULL,
  `Con_First_Name` varchar(100) NOT NULL,
  `Con_Last_Name` varchar(100) NOT NULL,
  `Con_Address` varchar(255) DEFAULT NULL,
  `Con_Skype_No` varchar(100) DEFAULT NULL,
  `Con_TP_No` varchar(20) DEFAULT NULL,
  `Con_Avilable_Start_Time` time DEFAULT NULL,
  `Con_Avilable_End_Time` time DEFAULT NULL,
  `Con_Avilability` varchar(100) DEFAULT NULL,
  `Con_Status` varchar(20) DEFAULT NULL,
  `Con_Discription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultant`
--

INSERT INTO `consultant` (`Con_ID`, `User_ID`, `Con_Img`, `Con_First_Name`, `Con_Last_Name`, `Con_Address`, `Con_Skype_No`, `Con_TP_No`, `Con_Avilable_Start_Time`, `Con_Avilable_End_Time`, `Con_Avilability`, `Con_Status`, `Con_Discription`) VALUES
(1, 2, 'assets/con_imgs/michael.jpg', 'Michael', 'Browns', '789 Oak St', 'michael.brown.skype', '+444333222', '09:00:00', '17:00:00', 'Available', 'Available', 'Experienced consultant in IT industry'),
(2, 3, 'assets/con_imgs/emily.jpg', 'Emily', 'Johnson', '101 Pine St', 'emily.johnson.skype', '+111222333', '08:30:00', '16:30:00', 'Monday to Thursday', 'Available', 'Specializes in healthcare sector jobs');

-- --------------------------------------------------------

--
-- Table structure for table `consult_appointment`
--

CREATE TABLE `consult_appointment` (
  `CA_Apt_ID` int(11) NOT NULL,
  `CA_Apt_Date` datetime DEFAULT NULL,
  `CA_status` varchar(50) NOT NULL,
  `Job_ID` int(11) NOT NULL,
  `Con_ID` int(11) NOT NULL,
  `Appli_ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consult_appointment`
--

INSERT INTO `consult_appointment` (`CA_Apt_ID`, `CA_Apt_Date`, `CA_status`, `Job_ID`, `Con_ID`, `Appli_ID`) VALUES
(5, '2023-09-30 13:22:00', 'Active', 1, 1, 2),
(6, '2023-08-20 10:30:00', 'Cancel', 1, 2, 1),
(7, '2023-09-08 18:28:00', 'Active', 2, 1, 2),
(8, '2023-08-27 21:06:00', 'Cancel', 5, 2, 2),
(9, '2023-08-18 21:36:00', 'Active', 2, 1, 2),
(10, '0000-00-00 00:00:00', 'Active', 1, 2, 2),
(11, '2023-08-30 23:52:00', 'Active', 1, 2, 1),
(12, '2023-08-27 16:51:00', 'Active', 1, 1, 1),
(13, '2023-08-28 03:55:00', 'Active', 1, 2, 1),
(14, '2023-08-30 08:00:00', 'Active', 1, 1, 1),
(15, '2023-08-21 05:40:00', 'Active', 1, 2, 1),
(16, '2023-08-27 01:38:00', 'Active', 1, 2, 1),
(17, '2023-09-19 09:19:00', 'Active', 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `Inv_ID` int(11) NOT NULL,
  `Inv_Date` datetime DEFAULT NULL,
  `User_ID` int(11) NOT NULL,
  `CA_Apt_ID` int(11) NOT NULL,
  `Job_ID` int(11) NOT NULL,
  `Con_ID` int(11) NOT NULL,
  `Inv_Amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`Inv_ID`, `Inv_Date`, `User_ID`, `CA_Apt_ID`, `Job_ID`, `Con_ID`, `Inv_Amount`) VALUES
(2, '2023-08-20 12:00:00', 5, 5, 1, 2, 1500.00),
(5, '2023-08-16 22:08:57', 4, 16, 1, 2, 100.00),
(6, '2023-08-16 23:46:04', 4, 17, 2, 1, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `Job_ID` int(11) NOT NULL,
  `Job_Title` varchar(100) DEFAULT NULL,
  `Job_country` varchar(100) DEFAULT NULL,
  `Job_Disc` text DEFAULT NULL,
  `Job_End_Date` date DEFAULT NULL,
  `Job_Image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`Job_ID`, `Job_Title`, `Job_country`, `Job_Disc`, `Job_End_Date`, `Job_Image`) VALUES
(1, 'Software Engineer', 'USA', 'Seeking a skilled software engineer for a tech company.', '2023-08-31', 'assets/job_imgs/2.png'),
(2, 'Software Engineer', 'USA', 'Seeking a skilled software engineer for a tech company.', '2023-08-31', 'assets/job_imgs/software-engineer.png'),
(3, 'Web Developer', 'Canada', 'Looking for a creative web developer to join our team.', '2023-09-15', 'assets/job_imgs/web-developer.png'),
(4, 'Marketing Specialist', 'United Kingdom', 'Seeking a marketing specialist with experience in digital marketing campaigns.', '2023-09-30', 'assets/job_imgs/marketing-specialist.png'),
(5, 'Data Analyst', 'Australia', 'Join our data analytics team as a skilled data analyst.', '2023-10-10', 'assets/job_imgs/data-analyst.png'),
(6, 'Graphic Designer', 'Germany', 'We are hiring a creative graphic designer with a passion for design.', '2023-10-20', 'assets/job_imgs/graphic-designer.png'),
(7, 'Sales Representative', 'France', 'Join our sales team and help us expand our customer base.', '2023-11-05', 'assets/job_imgs/sales-representative.png'),
(8, 'Accountant', 'Singapore', 'We are seeking an experienced accountant to manage financial transactions.', '2023-11-20', 'assets/job_imgs/accountant.png'),
(9, 'Customer Support Specialist', 'India', 'Join our customer support team and assist our valued clients.', '2023-12-10', 'assets/job_imgs/customer-support-specialist.png'),
(10, 'Human Resources Manager', 'Brazil', 'We are hiring an HR manager to oversee personnel matters.', '2023-12-20', 'assets/job_imgs/human-resources-manager.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `User_Type` enum('Admin','Consultant','JobSeeker') NOT NULL,
  `User_Email` varchar(255) NOT NULL,
  `User_Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `User_Type`, `User_Email`, `User_Password`) VALUES
(1, 'Admin', 'admin@example.com', 'admin123'),
(2, 'Consultant', 'consultant1@example.com', 'consultant123'),
(3, 'Consultant', 'consultant2@example.com', 'consultant456'),
(4, 'JobSeeker', 'jobseeker1@example.com', 'seeker123'),
(5, 'JobSeeker', 'jobseeker2@example.com', 'seeker456'),
(6, 'JobSeeker', 'jobseeker3@example.com', 'seeker789'),
(7, 'JobSeeker', 'jobseeker4@example.com', 'seeker101'),
(8, 'JobSeeker', 'jobseeker5@example.com', 'seeker202'),
(10, 'Consultant', 'consultant3@example.com', 'consultant31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`Appli_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `consultant`
--
ALTER TABLE `consultant`
  ADD PRIMARY KEY (`Con_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `consult_appointment`
--
ALTER TABLE `consult_appointment`
  ADD PRIMARY KEY (`CA_Apt_ID`),
  ADD KEY `Job_ID` (`Job_ID`),
  ADD KEY `Con_ID` (`Con_ID`),
  ADD KEY `consult_appointment_ibfk_3` (`Appli_ID`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`Inv_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `CA_Apt_ID` (`CA_Apt_ID`),
  ADD KEY `Job_ID` (`Job_ID`),
  ADD KEY `Con_ID` (`Con_ID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`Job_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `Appli_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `consultant`
--
ALTER TABLE `consultant`
  MODIFY `Con_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `consult_appointment`
--
ALTER TABLE `consult_appointment`
  MODIFY `CA_Apt_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `Inv_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `Job_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `consultant`
--
ALTER TABLE `consultant`
  ADD CONSTRAINT `consultant_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `consult_appointment`
--
ALTER TABLE `consult_appointment`
  ADD CONSTRAINT `consult_appointment_ibfk_1` FOREIGN KEY (`Job_ID`) REFERENCES `jobs` (`Job_ID`),
  ADD CONSTRAINT `consult_appointment_ibfk_2` FOREIGN KEY (`Con_ID`) REFERENCES `consultant` (`Con_ID`),
  ADD CONSTRAINT `consult_appointment_ibfk_3` FOREIGN KEY (`Appli_ID`) REFERENCES `applicants` (`Appli_ID`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`CA_Apt_ID`) REFERENCES `consult_appointment` (`CA_Apt_ID`),
  ADD CONSTRAINT `invoices_ibfk_3` FOREIGN KEY (`Job_ID`) REFERENCES `jobs` (`Job_ID`),
  ADD CONSTRAINT `invoices_ibfk_4` FOREIGN KEY (`Con_ID`) REFERENCES `consultant` (`Con_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
