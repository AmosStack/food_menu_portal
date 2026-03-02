SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

START TRANSACTION;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_menu_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'denis', 'denis@gmail.com', 'denis'),
(6, 'xxx', 'xxx@xxx.com', '$2y$10$FEm2fJlXJGs0R5674CehQueJcN7aZUtDm4fylJmZZy6TLnqJRv7aC'),
(7, 'amos', 'amgenious28@gmail.com', '$2y$10$1wgyofXXSktySARqDrPL6OjpNda8EgX/ZmuYVqlLLu/8AMpOk1zrq'),
(8, 'amos', 'amgenious28@gmail.com', '$2y$10$1wgyofXXSktySARqDrPL6OjpNda8EgX/ZmuYVqlLLu/8AMpOk1zrq');

COMMIT;

START TRANSACTION;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

DROP TABLE IF EXISTS `tbl_contact`;
CREATE TABLE IF NOT EXISTS `tbl_contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`id`, `name`, `email`, `subject`, `message`) VALUES
(1, 'Ajay', 'ajay@gmail.com', 'qdeeas', 'dsgffhgjhmhjm'),
(2, 'Amos JR', 'xxx@xxx.com', 'dfghm', 'ghbktvf');

COMMIT;

START TRANSACTION;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `tbl_menu_id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `menu_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`tbl_menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`tbl_menu_id`, `image`, `menu_name`, `price`, `description`) VALUES
(3, 'background.jpg', 'mix', 50, 'at play time today'),
(4, 'food5.jpg', 'piza', 50, 'at ba frank'),
(5, 'fish.jpg', 'flies', 45, 'fish'),
(6, 'food1.jpg', 'capatti', 60, 'iyughjm'),
(7, 'card1.jpg', 'gugu', 47, 'b uiv4fergthjko89juj');

COMMIT;

START TRANSACTION;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_offers`
--

DROP TABLE IF EXISTS `tbl_offers`;
CREATE TABLE IF NOT EXISTS `tbl_offers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `restaurant_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `discount_percentage` float NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_offers`
--

INSERT INTO `tbl_offers` (`id`, `restaurant_id`, `menu_id`, `discount_percentage`, `start_time`, `end_time`) VALUES
(3, 1, 4, 57, '2024-06-16 16:00:00', '2024-06-17 16:00:00'),
(2, 1, 4, 30, '2024-06-29 15:58:00', '2024-07-06 15:58:00');

COMMIT;

START TRANSACTION;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_restaurants`
--

DROP TABLE IF EXISTS `tbl_restaurants`;
CREATE TABLE IF NOT EXISTS `tbl_restaurants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `restaurant_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_restaurants`
--

INSERT INTO `tbl_restaurants` (`id`, `image`, `restaurant_name`, `address`, `description`) VALUES
(1, 'card2.jpg', 'gsfegbarea', 'gesegbr', 'dtrghji');

COMMIT;

START TRANSACTION;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `email`, `password`) VALUES
(6, 'xxx', 'xxx@xxx.com', '$2y$10$Tk27ZbolltrBZ6ijQdhV3OkIQzFlgWFeO2vwbrapwmMf14M1RqJwe');
