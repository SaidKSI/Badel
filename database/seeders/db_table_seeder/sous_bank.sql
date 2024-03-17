-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 17, 2024 at 01:49 AM
-- Server version: 8.0.36
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bedelportal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `sous_bank`
--

-- CREATE TABLE `sous_bank` (
--   `id` bigint UNSIGNED NOT NULL,
--   `Sb_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
--   `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
--   `instruction_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
--   `instruction_pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
--   `prefix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
--   `shortTransaction` tinyint(1) NOT NULL,
--   `can_send` tinyint(1) NOT NULL DEFAULT '1',
--   `can_receive` tinyint(1) NOT NULL DEFAULT '1',
--   `send_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '123456',
--   `transaction_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
--   `transaction_name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
--   `num_of_characters` int UNSIGNED NOT NULL,
--   `only_digit` tinyint(1) NOT NULL DEFAULT '1',
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sous_bank`
--

INSERT INTO `sous_bank` (`id`, `Sb_name`, `profile_picture`, `instruction_image`, `instruction_pdf`, `prefix`, `shortTransaction`, `can_send`, `can_receive`, `send_account`, `transaction_name`, `transaction_name_ar`, `num_of_characters`, `only_digit`, `created_at`, `updated_at`) VALUES
(1, 'sedad', 'assets/images/brand_icons/sadad.png', 'assets/images/instruction/sedadpay.png', 'assets/pdf/sedad.pdf', 'TR', 0, 1, 1, '04684- BEDEL', 'Numero', 'رقم المعاملة', 10, 1, NULL, NULL),
(2, 'bankily', 'assets/images/brand_icons/bankily.png', 'assets/images/instruction/bankilypay.png', 'assets/pdf/bankily.pdf', 'BA', 1, 1, 1, '43478193- hamza', 'txn id', 'معرف المعاملة', 5, 1, NULL, NULL),
(3, 'masrivi', 'assets/images/brand_icons/masrivi.png', 'assets/images/instruction/masrivipay.png', 'assets/pdf/masrivi.pdf', 'REF', 0, 1, 1, '27383291-BEDEL', 'Transaction N', 'رقم عملية', 8, 1, NULL, NULL),
(4, 'bimbank', 'assets/images/brand_icons/bimbank.png', 'assets/images/instruction/sedadpay.png', 'assets/pdf/bimbank.pdf', 'TR', 0, 1, 1, '27383291-BEDEL\r\n', 'id de la transcation', 'رقم المعاملة', 9, 1, NULL, NULL),
(5, 'bamisdigital', 'assets/images/brand_icons/bamis.png', 'assets/images/instruction/BA.png', NULL, 'BD', 1, 1, 1, '30307681-BEDEL', 'reference', 'قيد العملية', 4, 1, NULL, NULL),
(6, 'Barid-Cash', 'assets/images/brand_icons/beridicash.png', 'assets/images/instruction/BER.png', NULL, 'CH', 1, 0, 0, 'not availbe', 'numero d autorisation', 'رمز العملية ', 4, 1, NULL, NULL),
(7, 'CLICK', 'assets/images/brand_icons/click.png', '', NULL, 'AW', 0, 0, 0, '123456', 'reference', 'قيد العملية', 12, 1, NULL, NULL),
(8, 'amanty', 'assets/images/brand_icons/amanty.png', '', NULL, 'AM', 1, 0, 0, '123456', 'transaction id', 'رقم المعاملة', 4, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sous_bank`
--
ALTER TABLE `sous_bank`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sous_bank`
--
ALTER TABLE `sous_bank`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
