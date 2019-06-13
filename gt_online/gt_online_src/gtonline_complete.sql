-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 13, 2012 at 03:16 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: 'gtonline_complete'
--

CREATE DATABASE IF NOT EXISTS gtonline_complete;
USE gtonline_complete;

-- --------------------------------------------------------

--
-- Table structure for table 'adminuser'
--

DROP TABLE IF EXISTS adminuser;
CREATE TABLE IF NOT EXISTS adminuser (
  email varchar(250) NOT NULL,
  lastlogin datetime DEFAULT NULL,
  PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'adminuser'
--

INSERT INTO adminuser (email, lastlogin) VALUES('admin@gtonline.com', '2012-08-13 08:20:00');

-- --------------------------------------------------------

--
-- Table structure for table 'attend'
--

DROP TABLE IF EXISTS attend;
CREATE TABLE IF NOT EXISTS attend (
  email varchar(250) NOT NULL,
  schoolname varchar(250) NOT NULL,
  yeargraduated int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (email,schoolname,yeargraduated),
  KEY schoolname (schoolname)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'attend'
--

INSERT INTO attend (email, schoolname, yeargraduated) VALUES('michael@bluthco.com', 'Pheonix High School', 1986);
INSERT INTO attend (email, schoolname, yeargraduated) VALUES('michael@bluthco.com', 'University of California', 1989);

-- --------------------------------------------------------

--
-- Table structure for table 'comment'
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  email varchar(250) NOT NULL,
  dateandtime datetime NOT NULL,
  `text` varchar(1000) NOT NULL,
  suemail varchar(250) NOT NULL,
  sudateandtime datetime NOT NULL,
  PRIMARY KEY (email,dateandtime),
  KEY suemail (suemail,sudateandtime)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'comment'
--

INSERT INTO `comment` (email, dateandtime, `text`, suemail, sudateandtime) VALUES('dschrute@dundermifflin.com', '2012-08-13 15:02:00', 'This is a comment!', 'michael@bluthco.com', '2012-08-13 15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table 'employer'
--

DROP TABLE IF EXISTS employer;
CREATE TABLE IF NOT EXISTS employer (
  employername varchar(50) NOT NULL,
  PRIMARY KEY (employername)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'employer'
--

INSERT INTO employer (employername) VALUES('Bluth Development Company');
INSERT INTO employer (employername) VALUES('Dunder Mifflin');

-- --------------------------------------------------------

--
-- Table structure for table 'employment'
--

DROP TABLE IF EXISTS employment;
CREATE TABLE IF NOT EXISTS employment (
  email varchar(250) NOT NULL,
  employername varchar(50) NOT NULL,
  jobtitle varchar(50) NOT NULL,
  PRIMARY KEY (email,employername),
  KEY employername (employername)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'employment'
--

INSERT INTO employment (email, employername, jobtitle) VALUES('dschrute@dundermifflin.com', 'Dunder Mifflin', '');
INSERT INTO employment (email, employername, jobtitle) VALUES('michael@bluthco.com', 'Bluth Development Company', '');

-- --------------------------------------------------------

--
-- Table structure for table 'friendship'
--

DROP TABLE IF EXISTS friendship;
CREATE TABLE IF NOT EXISTS friendship (
  email varchar(250) NOT NULL,
  friendemail varchar(250) NOT NULL,
  relationship varchar(50) NOT NULL,
  dateconnected date DEFAULT NULL,
  PRIMARY KEY (email,friendemail),
  KEY friendemail (friendemail)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'friendship'
--

INSERT INTO friendship (email, friendemail, relationship, dateconnected) VALUES('michael@bluthco.com', 'gbluth@bluthco.com', 'Father', '2011-07-07');
INSERT INTO friendship (email, friendemail, relationship, dateconnected) VALUES('michael@bluthco.com', 'jhalpert@dundermifflin.com', 'Long Lost Cousin', NULL);
INSERT INTO friendship (email, friendemail, relationship, dateconnected) VALUES('michael@bluthco.com', 'lfunke@bluthco.com', 'Sister', '2012-03-05');
INSERT INTO friendship (email, friendemail, relationship, dateconnected) VALUES('pam@dundermifflin.com', 'michael@bluthco.com', 'Colleague', NULL);

-- --------------------------------------------------------

--
-- Table structure for table 'regularuser'
--

DROP TABLE IF EXISTS regularuser;
CREATE TABLE IF NOT EXISTS regularuser (
  email varchar(250) NOT NULL,
  sex char(1) NOT NULL,
  birthdate date NOT NULL,
  currentcity varchar(250) DEFAULT NULL,
  hometown varchar(250) DEFAULT NULL,
  PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'regularuser'
--

INSERT INTO regularuser (email, sex, birthdate, currentcity, hometown) VALUES('dschrute@dundermifflin.com', 'M', '1971-07-15', 'Scranton', 'Rochester');
INSERT INTO regularuser (email, sex, birthdate, currentcity, hometown) VALUES('gbluth@bluthco.com', 'M', '1950-11-17', 'Los Angeles', 'Los Angeles');
INSERT INTO regularuser (email, sex, birthdate, currentcity, hometown) VALUES('jhalpert@dundermifflin.com', 'M', '1973-10-02', 'Scranton', 'Buffalo');
INSERT INTO regularuser (email, sex, birthdate, currentcity, hometown) VALUES('lfunke@bluthco.com', 'F', '1974-05-05', 'Los Angeles', 'Las Vegas');
INSERT INTO regularuser (email, sex, birthdate, currentcity, hometown) VALUES('michael@bluthco.com', 'M', '1971-01-01', 'Pheonix', 'Beverly Hills');
INSERT INTO regularuser (email, sex, birthdate, currentcity, hometown) VALUES('pam@dundermifflin.com', 'F', '1975-04-28', 'Scranton', 'Sacramento');
INSERT INTO regularuser (email, sex, birthdate, currentcity, hometown) VALUES('rocky@cc.gatech.edu', 'M', '1981-03-22', 'Atlanta', 'Conyers');

-- --------------------------------------------------------

--
-- Table structure for table 'school'
--

DROP TABLE IF EXISTS school;
CREATE TABLE IF NOT EXISTS school (
  schoolname varchar(250) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (schoolname),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'school'
--

INSERT INTO school (schoolname, `type`) VALUES('Pheonix High School', 'High School');
INSERT INTO school (schoolname, `type`) VALUES('University of Georgia', 'High School');
INSERT INTO school (schoolname, `type`) VALUES('Georgia Tech', 'University');
INSERT INTO school (schoolname, `type`) VALUES('University of California', 'University');

-- --------------------------------------------------------

--
-- Table structure for table 'schooltype'
--

DROP TABLE IF EXISTS schooltype;
CREATE TABLE IF NOT EXISTS schooltype (
  typename varchar(50) NOT NULL,
  PRIMARY KEY (typename)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'schooltype'
--

INSERT INTO schooltype (typename) VALUES('Community College');
INSERT INTO schooltype (typename) VALUES('High School');
INSERT INTO schooltype (typename) VALUES('University');

-- --------------------------------------------------------

--
-- Table structure for table 'statusupdate'
--

DROP TABLE IF EXISTS statusupdate;
CREATE TABLE IF NOT EXISTS statusupdate (
  email varchar(250) NOT NULL,
  dateandtime datetime NOT NULL,
  `text` varchar(1000) NOT NULL,
  PRIMARY KEY (email,dateandtime),
  KEY dateandtime (dateandtime)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'statusupdate'
--

INSERT INTO statusupdate (email, dateandtime, `text`) VALUES('michael@bluthco.com', '2012-08-13 15:00:00', 'My first status update!');
INSERT INTO statusupdate (email, dateandtime, `text`) VALUES('michael@bluthco.com', '2012-08-13 16:00:00', 'Going to the store.');

-- --------------------------------------------------------

--
-- Table structure for table 'user'
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  email varchar(250) NOT NULL,
  `password` varchar(50) NOT NULL,
  firstname varchar(100) NOT NULL,
  lastname varchar(100) NOT NULL,
  PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'user'
--

INSERT INTO `user` (email, `password`, firstname, lastname) VALUES('admin@gtonline.com', 'admin123', 'Johnny', 'Admin');
INSERT INTO `user` (email, `password`, firstname, lastname) VALUES('dschrute@dundermifflin.com', 'dwight123', 'Dwight', 'Schrute');
INSERT INTO `user` (email, `password`, firstname, lastname) VALUES('gbluth@bluthco.com', 'george123', 'George', 'Bluth');
INSERT INTO `user` (email, `password`, firstname, lastname) VALUES('jhalpert@dundermifflin.com', 'jim123', 'Jim', 'Halpert');
INSERT INTO `user` (email, `password`, firstname, lastname) VALUES('lfunke@bluthco.com', 'lindsey123', 'Lindsey', 'Funke');
INSERT INTO `user` (email, `password`, firstname, lastname) VALUES('michael@bluthco.com', 'michael123', 'Michael', 'Bluth');
INSERT INTO `user` (email, `password`, firstname, lastname) VALUES('pam@dundermifflin.com', 'pam123', 'Pam', 'Halpert');
INSERT INTO `user` (email, `password`, firstname, lastname) VALUES('rocky@cc.gatech.edu', 'rocky123', 'Rocky', 'Dunlap');

-- --------------------------------------------------------

--
-- Table structure for table 'userinterests'
--

DROP TABLE IF EXISTS userinterests;
CREATE TABLE IF NOT EXISTS userinterests (
  email varchar(250) NOT NULL,
  interest varchar(250) NOT NULL,
  PRIMARY KEY (email,interest)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'userinterests'
--

INSERT INTO userinterests (email, interest) VALUES('jhalpert@dundermifflin.com', 'bird watching');
INSERT INTO userinterests (email, interest) VALUES('michael@bluthco.com', 'golf');
INSERT INTO userinterests (email, interest) VALUES('michael@bluthco.com', 'real estate development');
INSERT INTO userinterests (email, interest) VALUES('michael@bluthco.com', 'tennis');
INSERT INTO userinterests (email, interest) VALUES('pam@dundermifflin.com', 'horse racing');
INSERT INTO userinterests (email, interest) VALUES('pam@dundermifflin.com', 'volleyball');
INSERT INTO userinterests (email, interest) VALUES('rocky@cc.gatech.edu', 'piano');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adminuser`
--
ALTER TABLE `adminuser`
  ADD CONSTRAINT adminuser_ibfk_1 FOREIGN KEY (email) REFERENCES `user` (email);

--
-- Constraints for table `attend`
--
ALTER TABLE `attend`
  ADD CONSTRAINT attend_ibfk_1 FOREIGN KEY (email) REFERENCES regularuser (email),
  ADD CONSTRAINT attend_ibfk_2 FOREIGN KEY (schoolname) REFERENCES school (schoolname);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT comment_ibfk_1 FOREIGN KEY (suemail, sudateandtime) REFERENCES statusupdate (email, dateandtime);

--
-- Constraints for table `employment`
--
ALTER TABLE `employment`
  ADD CONSTRAINT employment_ibfk_1 FOREIGN KEY (email) REFERENCES regularuser (email),
  ADD CONSTRAINT employment_ibfk_2 FOREIGN KEY (employername) REFERENCES employer (employername);

--
-- Constraints for table `friendship`
--
ALTER TABLE `friendship`
  ADD CONSTRAINT friendship_ibfk_1 FOREIGN KEY (email) REFERENCES regularuser (email),
  ADD CONSTRAINT friendship_ibfk_2 FOREIGN KEY (friendemail) REFERENCES regularuser (email);

--
-- Constraints for table `regularuser`
--
ALTER TABLE `regularuser`
  ADD CONSTRAINT regularuser_ibfk_1 FOREIGN KEY (email) REFERENCES `user` (email);

--
-- Constraints for table `school`
--
ALTER TABLE `school`
  ADD CONSTRAINT school_ibfk_1 FOREIGN KEY (`type`) REFERENCES schooltype (typename);

--
-- Constraints for table `statusupdate`
--
ALTER TABLE `statusupdate`
  ADD CONSTRAINT statusupdate_ibfk_1 FOREIGN KEY (email) REFERENCES regularuser (email);

--
-- Constraints for table `userinterests`
--
ALTER TABLE `userinterests`
  ADD CONSTRAINT userinterests_ibfk_1 FOREIGN KEY (email) REFERENCES regularuser (email);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
