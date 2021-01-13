-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2019 at 06:24 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rdip`
--
CREATE DATABASE IF NOT EXISTS `db_rdip` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_rdip`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `Delete_Project_Credentials`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_Project_Credentials` (IN `ID` INT)  BEGIN
	DELETE FROM `prog_proj_status` WHERE `prog_proj_ID`=ID;
    DELETE FROM `project_chapter` WHERE `prog_proj_ID`=ID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--
-- Creation: Apr 15, 2019 at 05:21 AM
--

DROP TABLE IF EXISTS `agency`;
CREATE TABLE `agency` (
  `AgencyID` int(11) NOT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `Description` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `agency`:
--

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`AgencyID`, `Name`, `Description`) VALUES
(1, 'DILG', 'Department of Interior and Local Government'),
(2, 'CHED', 'Commission on Higher Education'),
(3, 'NEDA', 'National Economic Development Authority'),
(4, 'DOT', 'Department of Tourism'),
(29, 'DepEd', 'Department of Education'),
(30, 'DOH', 'Department of Health'),
(32, 'DOLE', 'Department of Labor and Employment'),
(33, 'LGU - Cagayan', 'Local Government Unit of Cagayan'),
(34, 'DFA', 'Department of Foreign Affairs'),
(35, 'COA', 'Commission on Audit'),
(36, 'CSU', 'Cagayan State University'),
(37, 'CSC', 'Civil Service Commission'),
(38, 'BJMP', 'Bureau of Jail Management and Penology'),
(39, 'DOJ', 'Department of Justice'),
(40, 'SC', 'Supreme Court'),
(41, 'LGU - Nueva Vizcaya', 'Local Government Unit of Nueva Vizcaya'),
(42, 'ISU', 'Isabela State University'),
(43, 'QSU', 'Quirino State University'),
(44, 'DA', 'Department of Agriculture'),
(45, 'BFAR', 'Bureau of Fisheries and Aquatic Resources'),
(46, 'DTI', 'Department of Trade and Industry'),
(47, 'DSWD', 'Department of Social Welfare and Development'),
(48, 'Phil Health', 'Phil Health'),
(49, 'DAR', 'Department of Agrarian Reform'),
(50, 'LGU - Isabela', 'Local Government Unit of Isabela'),
(51, 'LGU - Quirino', 'Local Government Unit of Quirino'),
(53, 'LGU - Tuguegarao', 'Local Government Unit of Tuguegarao'),
(54, 'DPWH', 'Department of Public Works and Highways');

-- --------------------------------------------------------

--
-- Table structure for table `funding_src`
--
-- Creation: Apr 15, 2019 at 05:23 AM
--

DROP TABLE IF EXISTS `funding_src`;
CREATE TABLE `funding_src` (
  `FSID` int(11) NOT NULL,
  `Name` varchar(256) DEFAULT NULL,
  `Description` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `funding_src`:
--

--
-- Dumping data for table `funding_src`
--

INSERT INTO `funding_src` (`FSID`, `Name`, `Description`) VALUES
(1, 'GAA', 'General Appropriations Act'),
(10, 'LGU Fund', 'Local Government Unit Fund'),
(11, 'NEP', 'National Expenditures Program'),
(12, 'ODA', 'Official Development Assistance'),
(17, 'Others', 'Other sources of funds'),
(18, 'Corporate Funds', 'Corporate Funds');

-- --------------------------------------------------------

--
-- Table structure for table `prog_proj`
--
-- Creation: May 21, 2019 at 02:50 AM
--

DROP TABLE IF EXISTS `prog_proj`;
CREATE TABLE `prog_proj` (
  `ID` int(11) NOT NULL,
  `Title` varchar(128) NOT NULL,
  `Prog_Proj_Brief` varchar(1024) NOT NULL,
  `AgencyID` int(11) DEFAULT NULL,
  `Spatial_Coverage` varchar(32) DEFAULT NULL,
  `FSID` int(11) DEFAULT NULL,
  `Year_1` decimal(8,3) DEFAULT NULL,
  `Year_2` decimal(8,3) DEFAULT NULL,
  `Year_3` decimal(8,3) DEFAULT NULL,
  `Year_4` decimal(8,3) DEFAULT NULL,
  `Year_5` decimal(8,3) DEFAULT NULL,
  `Year_6` decimal(8,3) DEFAULT NULL,
  `Total_Inv_Cost` decimal(8,3) DEFAULT NULL,
  `Latitude` varchar(1024) DEFAULT NULL,
  `Longitude` varchar(1024) DEFAULT NULL,
  `Prio_No` varchar(1) DEFAULT NULL,
  `Status` varchar(1) DEFAULT NULL,
  `Remarks` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `prog_proj`:
--   `AgencyID`
--       `agency` -> `AgencyID`
--   `FSID`
--       `funding_src` -> `FSID`
--

--
-- Dumping data for table `prog_proj`
--

INSERT INTO `prog_proj` (`ID`, `Title`, `Prog_Proj_Brief`, `AgencyID`, `Spatial_Coverage`, `FSID`, `Year_1`, `Year_2`, `Year_3`, `Year_4`, `Year_5`, `Year_6`, `Total_Inv_Cost`, `Latitude`, `Longitude`, `Prio_No`, `Status`, `Remarks`) VALUES
(18, 'Assistance to Disadvantaged Municipalities (ADM)', 'Provision of Portable Water Supply, Evacuation Facilities, Local Access Roads and Small Water Impounding Projects', 1, '6', 1, '13.730', '13.730', '13.730', '13.730', '13.730', '13.730', '82.390', '18.4520', '122.1710', '1', 'O', 'null'),
(19, 'Assistance to Municipalities Empowerment Fund', 'Expected Outputs: 1. All Local Development Council are fully functional 2. Local Development Investment Plan(LDIP) approved by the SB and submitted to the DILG 3. 100% of ADM projects with third party monitors 4. Establishment of open ADM portal 5. CSOs capacitated on ADM', 1, '6', 1, '10.040', '10.040', '10.040', '10.040', '10.040', '10.040', '60.210', '18.0493', '121.5724', '1', 'C', 'null'),
(21, 'Improve LGU Competitiveness and Ease of Doing Business', 'Component 1: Public-Private Partnership for the People Initiative for Local Governments (LGU P4) 1) Oriented and advocated LGUs on LGU P4 2) List of LGUs in LGU P4', 1, '6', 1, '0.501', '0.597', '0.600', '0.600', '0.600', '0.600', '3.500', '17.8995', '121.9623', '0', 'O', NULL),
(22, 'Improvement, Rehabilitation, Repair and Maintenance of BJMP Jail Facilities', 'Improvement, Rehabilitation, Repair and Maintenance of Santiago City District Jail, Tuguegarao City District Jail, Cauayan City District Jail, Regional Office 02, Ballesteros District Jail, Aparri District Jail, Cabarroguis District Jail, San Mateo Municipal Jail, Sta. Teresita District Jail, Lal-lo Municipal Jail, Solano District Jail, Gattaran Municipal Jail, Tuao District Jail, Maddela Municipal Jail, Santiago City District Jail Female Dormitory', 38, '6', 1, '26.000', '30.000', '46.000', '52.000', '20.000', '20.000', '194.000', '7.5447', '125.4600', '0', 'O', NULL),
(23, 'Construction of New Jail Building and Facilities', 'Construction of New Jail Building and Facilities of Cabagan District Jail, Tuguegarao City District Jail, Roxas District Jail, Ilagan District Jail', 38, '2', 1, '0.000', '200.000', '0.000', '0.000', '0.000', '0.000', '200.000', '15.5623', '120.9780', '0', 'O', NULL),
(24, 'Construction of the Office of the Regional Prosecutor Building', 'This building shall house three (3) offices (ORP, OPP Cagayan, OCP Tuguegarao City). Aside from the services usually served by these offices, attached programs to DOJ such as the BOC, WPP & IACAT shall be housed in the same building.', 39, '6', 1, '0.000', '41.300', '0.000', '0.000', '0.000', '0.000', '41.300', '13.6369', '123.1845', '0', 'O', 'null'),
(25, 'Construction of the Office of the Regional Prosecutor Building', 'Including furnitures, fixtures and air-conditioners ', 39, '6', 1, '0.000', '10.000', '0.000', '0.000', '0.000', '0.000', '10.000', '16.8047', '121.5494', '0', 'O', NULL),
(26, 'Establishment of Local Culture and Arts (R02) Center', 'Major Components: 1) Building Structures, Mechanism (Construction of LCA Center in Region 02) 2) Deepening the indigenous knowledge, system and practices through mainstreaming IPED, teachers training, production of orthographies and production of indigenous learning materials', 29, '6', 1, '0.000', '50.000', '50.000', '50.000', '50.000', '50.000', '250.000', '14.5641', '121.0117', '0', 'O', NULL),
(27, 'Nueva Vizcaya Center for Culture and Arts', 'Construction of two story permanent structure (dormitory) to cater indigenous people', 41, '4', 1, '10.000', '10.000', '20.000', '20.000', '50.000', '0.000', '110.000', '13.7420', '121.1771', '0', 'O', NULL),
(28, 'Nueva Vizcaya Center for Culture and Arts', 'Construction of amphitheater', 41, '4', 1, '0.000', '0.000', '10.000', '10.000', '0.000', '0.000', '20.000', '15.5638', '120.3504', '0', 'O', NULL),
(30, 'Support for Irrigation Network Services', 'Development, construction, rehabilitation and expansion of irrigation infrastructure including development and maintenance of water source', 44, '6', 11, '693.100', '488.700', '727.800', '671.200', '501.200', '455.300', '3537.200', '13.1606', '123.7875', '0', 'O', NULL),
(31, 'Agricultural Machinery, Equipment and Facilities Support Services', 'Enhancement of agricultural productivity and efficiency, reduce production cost, minimize post-harvest losses, and increase the value of agricultural commodities in order to achieve food security and safety and increase farmers income', 44, '6', 11, '207.400', '400.900', '168.200', '169.300', '178.600', '188.300', '1312.600', '10.3631', '123.8052', '0', 'O', NULL),
(33, 'Fingerling Dispersal', 'Production and distribution of fingerlings as input assistance to the backyard fishpond and fish cage operators; Communal Bodies of Waters and techno-demo projects and as rehabilitation assistance for calamity-stricken fisherfolk', 45, '6', 1, '17.680', '18.030', '19.890', '20.260', '20.630', '21.410', '117.890', '11.9861', '123.9197', '0', 'O', NULL),
(35, 'Industry Roadmapping', 'A program to encourage different sectors to come up with industry roadmaps, in collaboration with government, academe, and civil society to chart the direction, goals and strategies for key industries to enhance competitiveness and sustain inclusive growth', 46, '6', 1, '0.500', '0.525', '0.551', '0.579', '0.608', '0.638', '3.400', '18.4393', '122.2141', '0', 'O', NULL),
(36, 'Negosyo Center', 'The establishment of Negosyo Center ...', 46, '6', 1, '31.030', '34.400', '37.800', '41.600', '45.800', '50.400', '241.030', '11.7458', '122.3458', '0', 'O', NULL),
(37, 'SME Roving Academy', 'SME Roving Academy ...', 46, '6', 1, '1.700', '1.900', '2.100', '2.300', '2.500', '2.700', '13.200', '14.2219', '122.5321', '0', 'O', NULL),
(51, 'Provision of Emergency Shelter Assistance to Victims of Calamities', '?', 47, '6', 17, '296.290', '287.070', '301.400', '316.450', '332.260', '348.860', '1882.330', '8.5089', '124.4199', '1', 'O', 'Enter remarks here...'),
(52, 'Strengthening Rehabilitation and Reintegration Services for Children in Conflict with the Laws(CICL)', '?', 47, '6', 17, '10.980', '14.980', '14.990', '15.700', '15.840', '15.900', '88.400', '11.4286', '125.0640', '0', 'O', 'Enter remarks here...'),
(53, 'Expansion of Coverage of Beneficiaries and Partners of the Aid in Crisis Situation/Protective Services Program of the DSWD', '?', 47, '6', 17, '139.930', '304.790', '335.280', '368.820', '405.720', '446.310', '2000.860', '7.5104', '123.3461', '1', 'O', 'Enter remarks here...'),
(54, 'Capacitating families and victims of violence against women, children and human trafficking (center based)', '?', 47, '6', 17, '8.670', '9.180', '9.890', '8.570', '9.420', '10.360', '56.090', '9.1036', '123.0374', '1', 'O', 'Enter remarks here...'),
(55, 'Improvement of capacities of persons with disabilities', '?', 47, '6', 17, '0.000', '0.600', '0.660', '0.726', '0.799', '0.878', '3.660', '16.6776', '121.1837', '0', 'O', 'Enter remarks here...'),
(56, 'Point of Service (POS) Program', '?', 48, '6', 18, '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '3000.000', '12.6153', '123.6433', '0', 'O', 'Enter remarks here...'),
(57, 'Land Tenure Services Improved', '?', 49, '6', 1, '23.200', '22.200', '43.600', '43.700', '4.800', '4.800', '142.320', '7.1904', '124.2425', '0', 'O', 'Enter remarks here...'),
(58, 'Agrarian Justice Delivery Services', '?', 49, '6', 1, '6.900', '8.900', '9.400', '10.600', '10.900', '11.700', '58.350', '10.7992', '123.2250', '0', 'O', 'Enter remarks here...'),
(59, 'Sustainability of the Parametric Insurance Policy for the Province of Isabela', '?', 50, '3', 1, '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '9.8561', '124.2719', '0', 'O', 'Enter remarks here...'),
(60, 'Expansion of Health Insurance Program', '?', 51, '5', 10, '15.000', '15.000', '15.000', '15.000', '15.000', '15.000', '90.000', '10.7918', '124.9375', '0', 'O', 'Enter remarks here...'),
(73, 'Construction of Warehouse for DRRM Facilities and Equipment and Goods and Dontaions', '?', 29, '6', 1, '10.000', '20.000', '20.000', '20.000', '20.000', '20.000', '110.000', '14.6042', '120.9822', '1', NULL, NULL),
(74, 'Establishment of Quick Response Team or Task Force Lingkod Cagayan Command Center per District', '?', 33, '2', 1, '0.000', '30.000', '0.000', '0.000', '0.000', '0.000', '30.000', '14.6042', '120.9822', '1', NULL, NULL),
(75, 'Construction of the Isabela Disaster Risk Reduction and Management (IDRM) Complex', '?', 50, '3', 1, '0.000', '15.000', '15.000', '15.000', '15.000', '15.000', '75.000', '14.6042', '120.9822', '1', NULL, NULL),
(76, 'DRR Upgrading of Equipment', '?', 51, '5', 10, '3.500', '0.000', '0.000', '0.000', '0.000', '0.000', '3.500', '14.6042', '120.9822', '0', NULL, NULL),
(77, 'Core Shelter Assistance Program (CSAP)', '?', 51, '5', 10, '0.000', '22.500', '22.500', '22.500', '22.500', '22.500', '112.500', '14.6042', '120.9822', '1', NULL, NULL),
(78, 'CDRRM Command Center with Fiber Optic and Surveillance Cameras', '?', 53, '2', 10, '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '80.000', '14.6042', '120.9822', '1', NULL, NULL),
(79, 'Construction of Regional Evacuation Center', '?', 54, '4', 1, '0.000', '0.000', '0.000', '35.000', '0.000', '0.000', '35.000', '14.6042', '120.9822', '1', NULL, NULL),
(80, 'Traffic Lights (10 Units)', '?', 53, '2', 10, '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '16.000', '14.6042', '120.9822', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prog_proj_status`
--
-- Creation: May 24, 2019 at 01:58 AM
--

DROP TABLE IF EXISTS `prog_proj_status`;
CREATE TABLE `prog_proj_status` (
  `Code` int(11) NOT NULL,
  `Status` varchar(1) DEFAULT NULL,
  `Remarks` varchar(1024) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `prog_proj_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `prog_proj_status`:
--   `prog_proj_ID`
--       `prog_proj` -> `ID`
--

--
-- Dumping data for table `prog_proj_status`
--

INSERT INTO `prog_proj_status` (`Code`, `Status`, `Remarks`, `Date`, `prog_proj_ID`) VALUES
(32, 'C', '1', '2019-05-24 07:10:26', 18),
(33, 'C', 'Enter Remarks here...asdasdc', '2019-05-24 07:10:30', 18),
(34, 'C', '19 1', '2019-05-24 07:22:17', 19);

-- --------------------------------------------------------

--
-- Table structure for table `project_chapter`
--
-- Creation: May 08, 2019 at 07:16 AM
--

DROP TABLE IF EXISTS `project_chapter`;
CREATE TABLE `project_chapter` (
  `Code` int(11) NOT NULL,
  `rdip_ml_ID` int(11) DEFAULT NULL,
  `prog_proj_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `project_chapter`:
--   `rdip_ml_ID`
--       `rdip_ml` -> `ID`
--   `prog_proj_ID`
--       `prog_proj` -> `ID`
--

--
-- Dumping data for table `project_chapter`
--

INSERT INTO `project_chapter` (`Code`, `rdip_ml_ID`, `prog_proj_ID`) VALUES
(7, 19, 18),
(8, 19, 19),
(10, 19, 21),
(11, 20, 22),
(12, 20, 23),
(13, 20, 24),
(14, 20, 25),
(15, 21, 26),
(16, 21, 27),
(17, 21, 28),
(19, 22, 30),
(20, 22, 31),
(22, 22, 33),
(24, 23, 35),
(25, 23, 36),
(26, 23, 37),
(40, 25, 51),
(41, 25, 52),
(42, 25, 53),
(43, 25, 54),
(44, 25, 55),
(45, 25, 56),
(46, 25, 57),
(47, 25, 58),
(48, 25, 59),
(49, 25, 60),
(62, 26, 73),
(63, 26, 74),
(64, 26, 75),
(65, 26, 76),
(66, 26, 77),
(67, 26, 78),
(68, 26, 79),
(69, 26, 80);

-- --------------------------------------------------------

--
-- Table structure for table `rdip_ml`
--
-- Creation: Apr 30, 2019 at 06:59 AM
--

DROP TABLE IF EXISTS `rdip_ml`;
CREATE TABLE `rdip_ml` (
  `ID` int(11) NOT NULL,
  `Chap_No` int(2) NOT NULL,
  `Chap_Title` varchar(512) NOT NULL,
  `Chap_Desc` varchar(512) DEFAULT NULL,
  `Year` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `rdip_ml`:
--

--
-- Dumping data for table `rdip_ml`
--

INSERT INTO `rdip_ml` (`ID`, `Chap_No`, `Chap_Title`, `Chap_Desc`, `Year`) VALUES
(19, 5, 'Ensuring people-centered, clean, and efficient governance', '?', '2017-2022'),
(20, 6, 'Pursuing Swift & Fair Administration of Justice', '?', '2017-2022'),
(21, 7, 'Promoting PH Culture and Values', '?', '2017-2022'),
(22, 8, 'Expanding Economic Opportunities in Agriculture, Forestry & Fisheries', '?', '2017-2022'),
(23, 9, 'Expanding Economic Opportunities in Industry & Services through Trabaho & Negosyo', '?', '2017-2022'),
(24, 10, 'Accelerating Human Capital Development', '?', '2017-2022'),
(25, 11, 'Reducing Vulnerability of Individuals & Families', '?', '2017-2022'),
(26, 12, 'Building Safe & Secure Communities', '?', '2017-2022'),
(27, 13, 'Reaching for the Demographic Dividend', '?', '2017-2022'),
(28, 14, 'Vigorously Advancing Science, Technology & Innovation', '?', '2017-2022'),
(29, 18, 'Ensuring Security, Public Order & Safety', '?', '2017-2022'),
(30, 19, 'Accelerating Infrastructure Development', '?', '2017-2022'),
(31, 20, 'Maintaining Ecological Integrity, Clean & Healthy Environment', '?', '2017-2022'),
(32, 1, 'Trade and Investment', '?', '2005-2010'),
(33, 2, 'Agribusiness', '?', '2005-2010'),
(34, 3, 'Environment and Natural Resources', '?', '2005-2010'),
(35, 4, 'Housing/Construction', '?', '2005-2010'),
(36, 5, 'Tourism Development', '?', '2005-2010'),
(37, 6, 'Infrastructure', '?', '2005-2010'),
(38, 7, 'Fiscal Strength/The Financial Sector', '?', '2005-2010'),
(39, 8, 'Labor', '?', '2005-2010'),
(40, 9, 'Energy Independence', '?', '2005-2010'),
(41, 10, 'Power Sector Reforms', '?', '2005-2010'),
(42, 11, 'Responding to the Needs of the Poor', '?', '2005-2010'),
(43, 12, 'Basic Need: Peace and Order and Rule of Law Programs and Projects for National Government Funding', '?', '2005-2010'),
(44, 13, 'Peace Process/Overcoming Insurgency', '?', '2005-2010'),
(45, 14, 'Education', '?', '2005-2010'),
(46, 15, 'Science and Technology', '?', '2005-2010'),
(47, 16, 'Good Governance', '?', '2005-2010');

-- --------------------------------------------------------

--
-- Table structure for table `user_record`
--
-- Creation: Apr 17, 2019 at 01:00 AM
--

DROP TABLE IF EXISTS `user_record`;
CREATE TABLE `user_record` (
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Type` int(1) NOT NULL,
  `AgencyID` int(11) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `user_record`:
--   `AgencyID`
--       `agency` -> `AgencyID`
--

--
-- Dumping data for table `user_record`
--

INSERT INTO `user_record` (`Username`, `Password`, `Type`, `AgencyID`, `Status`) VALUES
('arnels', 'asd', 3, 1, 1),
('aviernes', 'aviernes', 2, 1, 1),
('fcordova', 'lyramae', 1, 3, 1),
('giled', 'giled', 2, 2, 1),
('jv', 'jv', 3, 3, 1),
('rico', 'rico', 3, 4, 1),
('sdannang', 'sdannang', 3, 1, 0),
('varnedo', 'varnedo', 3, 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agency`
--
ALTER TABLE `agency`
  ADD PRIMARY KEY (`AgencyID`);

--
-- Indexes for table `funding_src`
--
ALTER TABLE `funding_src`
  ADD PRIMARY KEY (`FSID`);

--
-- Indexes for table `prog_proj`
--
ALTER TABLE `prog_proj`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AgencyID` (`AgencyID`),
  ADD KEY `FSID` (`FSID`);

--
-- Indexes for table `prog_proj_status`
--
ALTER TABLE `prog_proj_status`
  ADD PRIMARY KEY (`Code`),
  ADD KEY `prog_proj_ID` (`prog_proj_ID`);

--
-- Indexes for table `project_chapter`
--
ALTER TABLE `project_chapter`
  ADD PRIMARY KEY (`Code`),
  ADD KEY `rdip_ml_ID` (`rdip_ml_ID`),
  ADD KEY `prog_proj_ID` (`prog_proj_ID`);

--
-- Indexes for table `rdip_ml`
--
ALTER TABLE `rdip_ml`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_record`
--
ALTER TABLE `user_record`
  ADD PRIMARY KEY (`Username`),
  ADD KEY `AgencyID` (`AgencyID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agency`
--
ALTER TABLE `agency`
  MODIFY `AgencyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `funding_src`
--
ALTER TABLE `funding_src`
  MODIFY `FSID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `prog_proj`
--
ALTER TABLE `prog_proj`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `prog_proj_status`
--
ALTER TABLE `prog_proj_status`
  MODIFY `Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `project_chapter`
--
ALTER TABLE `project_chapter`
  MODIFY `Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `rdip_ml`
--
ALTER TABLE `rdip_ml`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prog_proj`
--
ALTER TABLE `prog_proj`
  ADD CONSTRAINT `prog_proj_ibfk_1` FOREIGN KEY (`AgencyID`) REFERENCES `agency` (`AgencyID`),
  ADD CONSTRAINT `prog_proj_ibfk_2` FOREIGN KEY (`FSID`) REFERENCES `funding_src` (`FSID`);

--
-- Constraints for table `prog_proj_status`
--
ALTER TABLE `prog_proj_status`
  ADD CONSTRAINT `prog_proj_status_ibfk_1` FOREIGN KEY (`prog_proj_ID`) REFERENCES `prog_proj` (`ID`);

--
-- Constraints for table `project_chapter`
--
ALTER TABLE `project_chapter`
  ADD CONSTRAINT `project_chapter_ibfk_1` FOREIGN KEY (`rdip_ml_ID`) REFERENCES `rdip_ml` (`ID`),
  ADD CONSTRAINT `project_chapter_ibfk_2` FOREIGN KEY (`prog_proj_ID`) REFERENCES `prog_proj` (`ID`);

--
-- Constraints for table `user_record`
--
ALTER TABLE `user_record`
  ADD CONSTRAINT `user_record_ibfk_1` FOREIGN KEY (`AgencyID`) REFERENCES `agency` (`AgencyID`);


--
-- Metadata
--
USE `phpmyadmin`;

--
-- Metadata for table agency
--

--
-- Metadata for table funding_src
--

--
-- Metadata for table prog_proj
--

--
-- Metadata for table prog_proj_status
--

--
-- Metadata for table project_chapter
--

--
-- Metadata for table rdip_ml
--

--
-- Metadata for table user_record
--

--
-- Metadata for database db_rdip
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
