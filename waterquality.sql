-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 18-02-03 23:22
-- 서버 버전: 10.1.29-MariaDB
-- PHP 버전: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `waterquality`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `criteria`
--

CREATE TABLE `criteria` (
  `idcriteria` varchar(11) CHARACTER SET utf8 NOT NULL,
  `value1` double NOT NULL,
  `value2` double NOT NULL,
  `desc` varchar(45) CHARACTER SET utf8 NOT NULL,
  `unit` varchar(10) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 테이블의 덤프 데이터 `criteria`
--

INSERT INTO `criteria` (`idcriteria`, `value1`, `value2`, `desc`, `unit`) VALUES
('CLI', 0.5, 0.8, '잔류염소', 'PPM'),
('PHI', 5.5, 8.5, 'PH', 'PH'),
('TBI', 0.5, 3.5, '탁도', 'NTU'),
('TEI', 13.7, 21.5, '온도', '℃');

-- --------------------------------------------------------

--
-- 테이블 구조 `datapoint`
--

CREATE TABLE `datapoint` (
  `iddatapoint` varchar(11) CHARACTER SET utf8 NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `value` double NOT NULL,
  `flag` bit(1) NOT NULL,
  `idstation` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `idcriteria` varchar(11) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 테이블의 덤프 데이터 `datapoint`
--

INSERT INTO `datapoint` (`iddatapoint`, `timestamp`, `value`, `flag`, `idstation`, `idcriteria`) VALUES
('DT-1', '2018-01-30 05:08:00', 6.6, b'1', 'NJ-NP-PHI-0', 'PHI'),
('DT-10', '2018-01-29 20:02:00', 5, b'0', 'NJ-NP-PHI-0', 'PHI'),
('DT-11', '2018-02-02 06:00:00', 6, b'1', 'NJ-NP-PHI-0', 'PHI'),
('DT-12', '2018-02-02 14:11:00', 8, b'1', 'NJ-NP-PHI-0', 'PHI'),
('DT-13', '2018-02-02 11:54:00', 7, b'1', 'NJ-NP-PHI-0', 'PHI'),
('DT-14', '2018-02-02 02:59:00', 6, b'1', 'NJ-NP-PHI-0', 'PHI'),
('DT-15', '2018-02-02 06:01:00', 5.5, b'1', 'NJ-NP-PHI-0', 'PHI'),
('DT-16', '2018-02-02 07:01:00', 6, b'1', 'NJ-NP-PHI-0', 'PHI'),
('DT-17', '2018-02-01 17:01:00', 5, b'0', 'NJ-NP-PHI-0', 'PHI'),
('DT-18', '2018-02-01 20:01:00', 9, b'0', 'NJ-NP-PHI-0', 'PHI'),
('DT-19', '2018-02-01 15:00:00', 5, b'0', 'NJ-NP-PHI-0', 'PHI'),
('DT-2', '2018-01-30 05:09:00', 6, b'0', 'NJ-NP-PHI-0', 'TEI'),
('DT-20', '2018-02-01 16:01:00', 5, b'0', 'NJ-NP-PHI-0', 'PHI'),
('DT-3', '2018-01-30 05:09:00', 8.8, b'0', 'ST-2', 'PHI'),
('DT-4', '2018-01-30 05:09:00', 19, b'1', 'ST-2', 'TEI'),
('DT-5', '2018-01-30 05:10:00', 0.6, b'1', 'ST-2', 'CLI'),
('DT-6', '2018-01-30 05:10:00', 15.5, b'0', 'ST-2', 'TBI'),
('DT-7', '2018-01-30 05:10:00', 7.9, b'1', 'ST-6', 'PHI'),
('DT-8', '2018-01-30 05:10:00', 2.3, b'0', 'ST-7', 'TEI'),
('DT-9', '2018-01-30 08:13:00', 0.5, b'1', 'ST-8', 'TBI');

-- --------------------------------------------------------

--
-- 테이블 구조 `location`
--

CREATE TABLE `location` (
  `idlocation` varchar(11) CHARACTER SET utf8 NOT NULL,
  `location1` varchar(45) CHARACTER SET utf8 NOT NULL,
  `location2` varchar(45) CHARACTER SET utf8 NOT NULL,
  `location3` varchar(45) CHARACTER SET utf8 NOT NULL,
  `location4` varchar(45) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 테이블의 덤프 데이터 `location`
--

INSERT INTO `location` (`idlocation`, `location1`, `location2`, `location3`, `location4`) VALUES
('HP-HB', '금영섬', '전남북부권', '함평', '해보'),
('JD_GW', '금영섬', '전남서남권', '진도', '길우'),
('JH_GS', '금영섬', '전남서남권', '장흥', '관산'),
('JH_YJ', '금영섬', '전남서남권', '장흥', '연지'),
('NJ-NP', '금영섬', '전남중부권', '나주', '남평'),
('NJ_DS', '금영섬', '전남중부권', '나주', '다시'),
('PL_BS', '금영섬', '전남북부권', '평림', '법성'),
('PL_DY', '금영섬', '전남북부권', '평림', '담양'),
('WD_ND', '금영섬', '전남서남권', '완도', '대야');

-- --------------------------------------------------------

--
-- 테이블 구조 `station`
--

CREATE TABLE `station` (
  `idstation` varchar(11) CHARACTER SET utf8 NOT NULL,
  `desc` varchar(20) CHARACTER SET utf8 NOT NULL,
  `idlocation` varchar(11) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 테이블의 덤프 데이터 `station`
--

INSERT INTO `station` (`idstation`, `desc`, `idlocation`) VALUES
('NJ-NP-PHI-0', '나주 남평(배) pH', 'NJ-NP'),
('ST-2', '중대부근', 'NJ_DS'),
('ST-3', '중앙대 후문', 'WD_ND'),
('ST-4', '상도3동 부근', 'JH_GS'),
('ST-5', '상도1동 주민센터', 'WD_ND'),
('ST-6', '상도3동 주민센터', 'JH_GS'),
('ST-7', '해운대 하수펌프장', 'PL_BS'),
('ST-8', '매립지 하수처리장', 'HP-HB');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`idcriteria`);

--
-- 테이블의 인덱스 `datapoint`
--
ALTER TABLE `datapoint`
  ADD PRIMARY KEY (`iddatapoint`),
  ADD KEY `station_FK` (`idstation`),
  ADD KEY `criteria_FK` (`idcriteria`);

--
-- 테이블의 인덱스 `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`idlocation`);

--
-- 테이블의 인덱스 `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`idstation`),
  ADD KEY `location_FK` (`idlocation`);

--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `datapoint`
--
ALTER TABLE `datapoint`
  ADD CONSTRAINT `datapoint_ibfk_1` FOREIGN KEY (`idcriteria`) REFERENCES `criteria` (`idcriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `datapoint_ibfk_2` FOREIGN KEY (`idstation`) REFERENCES `station` (`idstation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 테이블의 제약사항 `station`
--
ALTER TABLE `station`
  ADD CONSTRAINT `station_ibfk_1` FOREIGN KEY (`idlocation`) REFERENCES `location` (`idlocation`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
