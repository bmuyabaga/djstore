-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2024 at 04:53 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gwabokia`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `branch_address` varchar(100) NOT NULL,
  `branch_contact` varchar(50) NOT NULL,
  `branch_email` varchar(100) NOT NULL,
  `tin_noo` varchar(50) NOT NULL,
  `skin` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `branch_address`, `branch_contact`, `branch_email`, `tin_noo`, `skin`) VALUES
(1, 'Muyabaga', 'Pwani, Kibaha,Maili Moja', '+255 658579646,+255 718030268', 'info@bethelbd.com', '157-345-657', 'green');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_name` varchar(250) NOT NULL,
  `brand_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `category_id`, `brand_name`, `brand_status`) VALUES
(1, 3, 'Tabora', 'active'),
(2, 3, 'Kigoma', 'active'),
(3, 3, 'Singida', 'active'),
(4, 1, 'Mwanza', 'active'),
(5, 1, 'Zanzibar', 'active'),
(6, 5, 'marketing-suvacor', 'active'),
(7, 6, 'food allowance', 'active'),
(8, 7, 'boat ticket', 'active'),
(9, 7, 'transport fees', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `category_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_status`) VALUES
(1, 'Samaki', 'active'),
(2, 'Unga', 'active'),
(3, 'Asali', 'active'),
(4, 'Maziwa', 'active'),
(5, 'marketing', 'active'),
(6, 'food', 'active'),
(7, 'transport', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address1` varchar(200) NOT NULL,
  `address2` varchar(200) NOT NULL,
  `due_days` int(11) NOT NULL,
  `due_type` enum('prepay','invoice_date','eom') NOT NULL,
  `max_credit` int(11) NOT NULL,
  `tin_no` varchar(50) NOT NULL,
  `vrn` varchar(50) NOT NULL,
  `country` int(11) NOT NULL,
  `post_code` varchar(50) NOT NULL,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_outstanding` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `client_status` enum('active','inactive') NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `client_name`, `city`, `address1`, `address2`, `due_days`, `due_type`, `max_credit`, `tin_no`, `vrn`, `country`, `post_code`, `notes`, `user_id`, `total_outstanding`, `created_on`, `client_status`, `photo`) VALUES
(1, 'Mimi', 'Unguja', 'Kisauni', 'Kisauni', 3, 'prepay', 2, '111-1111-111', '0', 0, '255', 'good', 1, 0, '2024-04-29 02:55:27', 'active', 'image_client/user.png'),
(2, 'Utalii Cafe-Mr Lesseni', 'Unguja', 'Kisauni', 'Kisauni', 3, 'prepay', 5000, '111-1111-111', 'y-345-278', 0, '255', 'good', 1, 0, '2024-04-29 02:55:52', 'active', 'image_client/banana-ripen-1-300x300.png'),
(3, 'Suvacor Limited', 'Zanzibar', 'Kombeni', 'Zanzibar', 2, 'prepay', 200000, '127-374-481', 'nil', 0, '255', '', 1, 2655000, '2024-05-27 04:17:08', 'active', 'image_client/Raba.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`, `country_status`) VALUES
(1, 'Tanzania', 'active'),
(2, 'Kenya', 'active'),
(3, 'Uganda', 'active'),
(4, 'Burundi', 'active'),
(5, 'Rwanda', 'active'),
(6, 'Congo DRC', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `total` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `grandtotal` int(11) NOT NULL,
  `pay` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `payment_type` enum('Not Delivered','Partially Delivered','Fully Delivered') NOT NULL,
  `status` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_item`
--

CREATE TABLE `customer_order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_order_item`
--

INSERT INTO `customer_order_item` (`id`, `order_id`, `product_code`, `selling_price`, `qty`, `total`) VALUES
(1, 1, 11111, 6000, 2, 369000),
(2, 1, 77777, 78000, 3, 369000),
(3, 1, 33333, 15000, 6, 369000),
(4, 1, 44444, 33000, 1, 369000),
(5, 2, 44444, 33000, 1, 111000),
(6, 2, 77777, 78000, 1, 111000),
(7, 3, 11111, 6000, 1, 117000),
(8, 3, 77777, 78000, 1, 117000),
(9, 3, 44444, 33000, 1, 117000),
(10, 4, 77777, 78000, 2, 156000);

-- --------------------------------------------------------

--
-- Table structure for table `custom_price`
--

CREATE TABLE `custom_price` (
  `custom_price_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `date_set` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(200) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `status`) VALUES
(1, 'Purchasing ', 'active'),
(2, 'Finance', 'active'),
(3, 'Sales', 'active'),
(4, 'Human Resource', 'active'),
(5, 'Management', 'active'),
(6, 'Warehouse', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `join_date` date NOT NULL,
  `dob` date NOT NULL,
  `end_date` date NOT NULL,
  `position_id` int(11) NOT NULL,
  `tribe_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `sex` enum('m','f') NOT NULL,
  `country_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `data_entered_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `start_event`, `end_event`) VALUES
(1, 'Meeting', '2022-01-17 00:00:00', '2022-01-18 00:00:00'),
(2, 'Prayers', '2022-01-18 03:00:00', '2022-01-18 03:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `expaccount`
--

CREATE TABLE `expaccount` (
  `expenseaccount_id` int(11) NOT NULL,
  `expense_account` varchar(255) NOT NULL,
  `definition` text NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expaccount`
--

INSERT INTO `expaccount` (`expenseaccount_id`, `expense_account`, `definition`, `status`) VALUES
(1, 'Internet & Telephone', 'In this account we record purchase of voucher for bundle and airtime', 'active'),
(2, 'Food & Refreshment', 'This account you need to record any payment made to food or drinks at hotel, restaurant etc, also for any recreational events done by the company ', 'active'),
(3, 'Advertisement & Marketing', 'Funds used to advertise or market our old or new products are recorded in this account', 'active'),
(4, 'Insurance', 'Staff insurance or vehicles insurance are recorded in this account  ', 'active'),
(5, 'Stationeries & Printing', 'funds paid for printing, buy pens, envelops, Rim papers and etc are recorded in this account.', 'active'),
(6, 'Electricity', 'Funds paind to buy luku for office are recorded in this account', 'active'),
(7, 'Water Bills', 'Funds used to pay water bills for office use are recorded in this account', 'active'),
(8, 'Salaries & Wages', 'Funds used to pay salaries to employees or wages are recorded in this account', 'active'),
(9, 'Clearing & Forwarding', 'Clearance goods through sea port and airport, the funds are recorded in this account', 'active'),
(10, 'Transport', 'Funds paid for bus, bodaboda, Taxes for all office movement are recorded in this account', 'active'),
(11, 'Travel', 'Funds paid for Boat tickets or Air tickets are recorded in this account', 'active'),
(12, 'Rent', 'Funds paid either to vehicle or office rent are recorded in this account', 'active'),
(13, 'Oil & Fuels', 'Funds paid to buy oil or fuels for company vehicle are recorded in this account', 'active'),
(14, 'Maintenance and Repairs', 'Funds paid for repairing of our assets like vans etc are recorded in this account', 'active'),
(15, 'License Fees', 'Funds paid for driving license are recorded in this account', 'active'),
(16, 'Accounting Fees', 'Funds paid for all accounting issue are recorded in this account ', 'active'),
(17, 'Drawings', 'to use company funds for personal use', 'active'),
(18, 'Director Loan', 'Account to give loan to Director', 'active'),
(19, 'Packing Material', 'For packaging of products', 'active'),
(20, 'Money Transfer Charges', 'This account is for recording all the charges incurred after we transfer funds to suppliers through mobile transaction', 'active'),
(21, 'Bank Deposit', 'This account is only for cash Deposited in the bank', 'active'),
(22, 'Kibubu Deposit', 'This cash for all cash deposited in the kibubu', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `expenseaccount_id` int(11) NOT NULL,
  `expense_unit_cost` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `units` varchar(15) NOT NULL,
  `expense_total_cost` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `booked_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `user_id`, `expense_date`, `expenseaccount_id`, `expense_unit_cost`, `quantity`, `units`, `expense_total_cost`, `payment_method`, `description`, `status`, `booked_on`, `branch_id`) VALUES
(1, 1, '2022-04-03', 16, 5000, 2, 'pcs', 10000, 'transfer', 'eee', 'active', '2022-04-03 18:06:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `history_log`
--

CREATE TABLE `history_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(200) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loan_id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `emp_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `return_date` date NOT NULL,
  `returned_amount` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `payment_method` enum('cash','transfer','tigo_pesa') NOT NULL,
  `payment_type` enum('paid','unpaid','partially_paid') NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_payment`
--

CREATE TABLE `loan_payment` (
  `loan_payment_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `due` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `notes` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `booked_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_payment`
--

INSERT INTO `loan_payment` (`loan_payment_id`, `loan_id`, `user_id`, `emp_id`, `payment_date`, `payment_method`, `due`, `paid`, `balance`, `notes`, `status`, `booked_on`) VALUES
(1, 1, 1, 1, '2021-12-14', 'cash', 140000, 50000, 90000, 'cool', 'active', '2021-12-14 09:01:39'),
(2, 1, 1, 1, '2021-12-14', 'cash', 90000, 40000, 50000, '', 'active', '2021-12-14 09:29:13'),
(3, 1, 1, 1, '2021-12-14', 'cash', 50000, 10000, 40000, '', 'active', '2021-12-14 09:29:41'),
(4, 1, 1, 1, '2021-12-14', 'cash', 40000, 15000, 25000, '', 'active', '2021-12-14 09:31:51'),
(5, 3, 1, 1, '2022-11-20', 'cash', 60000, 50000, 10000, '', 'active', '2022-01-13 09:55:09'),
(6, 3, 1, 1, '2022-11-20', 'cash', 10000, 5000, 5000, '', 'active', '2022-01-13 09:57:37'),
(7, 3, 1, 1, '2022-11-20', 'cash', 5000, 4000, 1000, '', 'active', '2022-01-13 10:00:42'),
(8, 3, 1, 1, '2022-11-20', 'cash', 1000, 500, 500, '', 'active', '2022-01-13 10:02:51'),
(9, 3, 1, 1, '2022-11-20', 'cash', 1000, 500, 500, '', 'active', '2022-01-13 10:02:51'),
(10, 1, 1, 1, '2022-11-20', 'cash', 25000, 20000, 5000, '', 'active', '2022-01-13 10:03:23'),
(11, 1, 1, 1, '2022-11-20', 'cash', 25000, 20000, 5000, '', 'active', '2022-01-13 10:03:24'),
(12, 3, 1, 1, '2022-11-20', 'cash', 500, 500, 0, '', 'active', '2022-02-09 16:25:00'),
(13, 1, 1, 1, '2022-11-20', 'cash', 5000, 5000, 0, '', 'active', '2022-02-09 16:32:58'),
(14, 2, 1, 1, '2022-02-05', 'cash', 6000, 6000, 0, '', 'active', '2022-02-09 16:34:08'),
(15, 4, 1, 1, '2022-11-20', 'cash', 70000, 70000, 0, '', 'active', '2022-02-09 16:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `nmb`
--

CREATE TABLE `nmb` (
  `nmb_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `method` enum('cash','tigo_pesa','cheque','transfer') NOT NULL,
  `transaction` enum('deposit','withdraw') NOT NULL,
  `bank_type` enum('nmb','crdb') NOT NULL,
  `notes` text NOT NULL,
  `booked_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `due` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `notes` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `booked_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `sales_id`, `user_id`, `client_id`, `payment_date`, `payment_method`, `due`, `paid`, `balance`, `notes`, `status`, `branch_id`, `booked_on`) VALUES
(1, 6, 1, 3, '2023-11-27', 'cash', 440000, 440000, 0, '', 'active', 1, '2023-11-27 07:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `position_name`, `status`) VALUES
(1, 'Managing Director', 'active'),
(2, 'Manager', 'active'),
(3, 'sales Manager', 'active'),
(4, 'Operational Supervisor', 'active'),
(5, 'Stock manager', 'active'),
(6, 'Secaretary', 'active'),
(7, 'owner', 'active'),
(8, 'Chef', 'active'),
(9, 'office attendant', 'active'),
(10, 'office Cleaner', 'active'),
(11, 'Food and Beverage Manager', 'active'),
(12, 'Chief Technician', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` varchar(300) NOT NULL,
  `product_description` text NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_unit` varchar(150) NOT NULL,
  `product_base_price` double(10,2) NOT NULL,
  `product_tax` decimal(4,2) NOT NULL,
  `product_minimum_order` double(10,2) NOT NULL,
  `product_enter_by` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `product_status` enum('active','inactive') NOT NULL,
  `product_date` date NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `brand_id`, `product_name`, `product_description`, `product_quantity`, `product_unit`, `product_base_price`, `product_tax`, `product_minimum_order`, `product_enter_by`, `product_code`, `product_status`, `product_date`, `branch_id`) VALUES
(1, 3, 1, 'Asali Ya Tabora 500g', 'Inatoka tabora', -16, 'Bottles', 10000.00, '0.00', 0.00, 1, 1001, 'active', '2022-03-28', 0),
(2, 1, 4, 'Miyombo Tabora Super Honey 350g', 'Nzuri', -13, 'Bottles', 6500.00, '0.00', 0.00, 1, 1022, 'active', '2022-03-28', 0),
(3, 5, 6, 'Marketing 1 day', '23days x  from 29/04/2024 to 31/05/2024', -143, 'virtue', 60000.00, '0.00', 0.00, 1, 1112, 'inactive', '2023-11-27', 0),
(4, 7, 8, 'Boat Ticket 1 trip', 'boat ticket 1 trip', -59, 'virtue', 30000.00, '0.00', 0.00, 1, 1115, 'inactive', '2023-11-27', 0),
(5, 7, 9, 'Transport fee 1 week stone town', 'Transport', -6, 'virtue', 17000.00, '0.00', 0.00, 1, 1117, 'inactive', '2023-11-27', 0),
(6, 6, 7, 'Food allowance 1 Day', '23days x  from 29/04/2024 to 31/05/2024', -146, 'virtue', 15000.00, '0.00', 0.00, 1, 1113, 'inactive', '2023-11-27', 0),
(7, 5, 6, 'ZFDA-Import Permit Processing', 'good', -5, 'Nos', 45000.00, '0.00', 0.00, 1, 1002, 'inactive', '2023-12-16', 0),
(8, 7, 9, 'Transport 1 Week town and Shamba', 'transport', -4, 'virtue', 22500.00, '0.00', 0.00, 1, 1118, 'inactive', '2024-01-05', 0),
(9, 5, 6, 'Renewal of ZFDA premises certificate', 'Renewal', -1, 'virtue', 40000.00, '0.00', 0.00, 1, 2024, 'inactive', '2024-01-08', 0),
(10, 5, 6, 'Renewal of ZFDA Import/Export certificate', '23days x  (from 29/04/2024 to 31/05/2024)', -1, 'virtue', 40000.00, '0.00', 0.00, 1, 20241, 'inactive', '2024-01-08', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_input`
--

CREATE TABLE `product_input` (
  `input_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `input_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `barcode` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `branch_id` int(11) NOT NULL,
  `status` varchar(15) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_input`
--

INSERT INTO `product_input` (`input_id`, `user_id`, `input_name`, `price`, `barcode`, `created_on`, `branch_id`, `status`, `description`) VALUES
(1, 1, 'Mahindi', 2500, 10001, '2021-11-15 04:05:58', 1, 'active', 'good'),
(2, 1, 'samaki sangara', 6500, 10002, '2021-08-08 02:50:25', 1, 'active', 'good'),
(3, 4, 'Samaki Sato', 9500, 10003, '2021-08-08 02:50:25', 1, 'active', 'good'),
(4, 10, 'Mafuta ya alizeti', 25000, 10004, '2021-08-08 02:50:25', 1, 'active', 'Good'),
(5, 1, 'Ulezi', 1000, 10008, '2021-08-08 03:21:46', 1, 'active', 'good'),
(6, 1, 'Samaki Sangara', 2000, 10008, '2022-01-13 10:08:42', 1, 'active', ''),
(7, 1, 'Dagaa wa kukaangwa', 2000, 10008, '2022-01-13 10:09:49', 1, 'active', 'ggdgedf');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `grandtotal` int(11) NOT NULL,
  `pay` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item`
--

CREATE TABLE `purchase_item` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `buying_price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_item`
--

INSERT INTO `purchase_item` (`id`, `purchase_id`, `product_code`, `buying_price`, `qty`, `total`) VALUES
(1, 2, 10004, 25000, 2, 79000),
(2, 2, 10008, 1000, 3, 79000),
(3, 2, 10002, 6500, 4, 79000),
(4, 3, 10004, 25000, 2, 50000),
(5, 3, 10008, 1000, 3, 3000),
(6, 3, 10002, 6500, 4, 26000),
(7, 4, 10004, 25000, 2, 50000),
(8, 4, 10008, 1000, 3, 3000),
(9, 4, 10002, 6500, 4, 26000),
(10, 4, 10003, 9500, 1, 9500),
(11, 5, 10004, 25000, 2, 50000),
(12, 5, 10008, 1000, 3, 3000),
(13, 5, 10002, 6500, 4, 26000),
(14, 5, 10003, 9500, 1, 9500),
(15, 34, 10004, 25000, 1, 25000),
(16, 35, 10004, 25000, 1, 25000),
(17, 35, 10001, 2500, 1, 2500),
(18, 35, 10002, 6500, 1, 6500),
(19, 35, 10003, 9500, 1, 9500),
(20, 36, 10002, 13000, 2, 26000),
(21, 36, 10008, 1000, 1, 1000),
(22, 44, 10002, 6500, 2, 13000),
(23, 45, 10004, 75000, 3, 225000),
(24, 45, 10002, 13000, 2, 26000),
(25, 45, 10008, 1000, 1, 1000),
(26, 46, 10004, 25000, 5, 125000);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payment`
--

CREATE TABLE `purchase_payment` (
  `payment_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `due` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `notes` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `branch_id` int(11) NOT NULL,
  `booked_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(100) NOT NULL,
  `region_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`region_id`, `region_name`, `region_status`) VALUES
(1, 'Mbeya', 'active'),
(2, 'Tabora', 'active'),
(3, 'Singida', 'active'),
(4, 'Mwanza', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `grandtotal` int(11) NOT NULL,
  `pay` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `user_id`, `client_id`, `date`, `total`, `discount`, `grandtotal`, `pay`, `balance`, `payment_type`, `status`, `branch_id`) VALUES
(8, 1, '2', '2023-11-30', 30000, 0, 30000, 0, 30000, 'unpaid', 'active', 1),
(99, 1, '2', '2022-06-06', 256500, 0, 256500, 0, 256500, 'unpaid', 'active', 1),
(100, 1, '2', '2022-06-06', 19500, 0, 19500, 0, 19500, 'unpaid', 'active', 1),
(101, 1, '1', '2023-02-09', 205000, 5000, 200000, 0, 200000, 'unpaid', 'active', 1),
(102, 1, '1', '2023-11-27', 76500, 0, 76500, 0, 76500, 'unpaid', 'active', 1),
(103, 1, '3', '2023-11-27', 30000, 0, 30000, 0, 30000, 'unpaid', 'active', 1),
(104, 1, '3', '2023-11-27', 440000, 0, 440000, 440000, 0, 'paid', 'active', 1),
(107, 1, '2', '2023-11-30', 15000, 0, 15000, 0, 15000, 'unpaid', 'active', 1),
(108, 1, '3', '2023-12-01', 365000, 0, 365000, 0, 365000, 'unpaid', 'active', 1),
(109, 1, '3', '2023-12-07', 443000, 0, 443000, 0, 443000, 'unpaid', 'active', 1),
(110, 1, '3', '2023-12-14', 440000, 0, 440000, 0, 440000, 'unpaid', 'active', 1),
(111, 1, '3', '2023-12-16', 45000, 0, 45000, 0, 45000, 'unpaid', 'active', 1),
(112, 1, '3', '2023-12-16', 45000, 0, 45000, 0, 45000, 'unpaid', 'active', 1),
(113, 1, '3', '2023-12-16', 45000, 0, 45000, 0, 45000, 'unpaid', 'active', 1),
(114, 1, '3', '2023-12-18', 45000, 0, 45000, 0, 45000, 'unpaid', 'active', 1),
(115, 1, '3', '2023-12-22', 375000, 0, 375000, 0, 375000, 'unpaid', 'active', 1),
(116, 1, '3', '2023-12-30', 270000, 0, 270000, 0, 270000, 'unpaid', 'active', 1),
(117, 1, '3', '2024-01-05', 375000, 0, 375000, 0, 375000, 'unpaid', 'active', 1),
(118, 1, '3', '2024-01-08', 125000, 0, 125000, 0, 125000, 'unpaid', 'active', 1),
(119, 1, '3', '2024-01-11', 298000, 0, 298000, 0, 298000, 'unpaid', 'active', 1),
(120, 1, '3', '2024-01-19', 453000, 0, 453000, 0, 453000, 'unpaid', 'active', 1),
(121, 1, '3', '2024-01-26', 405000, 0, 405000, 0, 405000, 'unpaid', 'active', 1),
(122, 1, '3', '2024-02-01', 452000, 0, 452000, 0, 452000, 'unpaid', 'active', 1),
(123, 1, '3', '2024-02-02', 452000, 0, 452000, 0, 452000, 'unpaid', 'active', 1),
(124, 1, '3', '2024-02-09', 457500, 0, 457500, 0, 457500, 'unpaid', 'active', 1),
(125, 1, '3', '2024-02-16', 435000, 0, 435000, 0, 435000, 'unpaid', 'active', 1),
(126, 1, '3', '2024-02-23', 435000, 0, 435000, 0, 435000, 'unpaid', 'active', 1),
(127, 1, '3', '2024-03-01', 435000, 0, 435000, 0, 435000, 'unpaid', 'active', 1),
(128, 1, '3', '2024-03-08', 435000, 0, 435000, 0, 435000, 'unpaid', 'active', 1),
(129, 1, '3', '2024-03-15', 435000, 0, 435000, 0, 435000, 'unpaid', 'active', 1),
(130, 1, '3', '2024-03-22', 435000, 0, 435000, 0, 435000, 'unpaid', 'active', 1),
(131, 1, '3', '2024-03-27', 360000, 0, 360000, 0, 360000, 'unpaid', 'active', 1),
(132, 1, '3', '2024-04-05', 360000, 0, 360000, 0, 360000, 'unpaid', 'active', 1),
(133, 1, '3', '2024-04-09', 210000, 0, 210000, 0, 210000, 'unpaid', 'active', 1),
(134, 1, '3', '2024-04-12', 210000, 0, 210000, 0, 210000, 'unpaid', 'active', 1),
(135, 1, '3', '2024-04-19', 435000, 0, 435000, 0, 435000, 'unpaid', 'active', 1),
(136, 1, '3', '2024-04-26', 435000, 0, 435000, 0, 435000, 'unpaid', 'active', 1),
(137, 1, '3', '2024-04-27', 495000, 0, 495000, 0, 495000, 'unpaid', 'active', 1),
(138, 1, '3', '2024-05-03', 375000, 0, 375000, 0, 375000, 'unpaid', 'active', 1),
(139, 1, '3', '2024-05-03', 375000, 0, 375000, 0, 375000, 'unpaid', 'active', 1),
(140, 1, '3', '2024-05-27', 1905000, 0, 1905000, 0, 1905000, 'unpaid', 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_item`
--

CREATE TABLE `sales_item` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_item`
--

INSERT INTO `sales_item` (`id`, `sales_id`, `product_code`, `selling_price`, `qty`, `total`) VALUES
(1, 1, 1001, 50000, 5, 256500),
(2, 1, 1002, 6500, 1, 256500),
(3, 2, 1002, 6500, 3, 19500),
(4, 3, 1002, 32500, 6, 205000),
(5, 3, 1001, 10000, 1, 205000),
(6, 4, 1001, 10000, 7, 76500),
(7, 4, 1002, 6500, 1, 76500),
(8, 5, 1001, 10000, 3, 30000),
(9, 6, 1112, 60000, 5, 440000),
(10, 6, 1117, 5000, 1, 440000),
(11, 6, 1115, 30000, 2, 440000),
(12, 6, 1113, 15000, 5, 440000),
(13, 7, 1113, 15000, 1, 15000),
(14, 8, 1113, 15000, 2, 30000),
(15, 108, 1112, 60000, 4, 365000),
(16, 108, 1115, 30000, 2, 365000),
(17, 108, 1113, 15000, 4, 365000),
(18, 108, 1117, 5000, 1, 365000),
(19, 109, 1112, 60000, 5, 443000),
(20, 109, 1113, 15000, 5, 443000),
(21, 109, 1115, 30000, 2, 443000),
(22, 109, 1117, 8000, 1, 443000),
(23, 110, 1112, 60000, 5, 440000),
(24, 110, 1115, 30000, 2, 440000),
(25, 110, 1113, 15000, 5, 440000),
(26, 110, 1117, 5000, 1, 440000),
(27, 111, 1002, 45000, 1, 45000),
(28, 112, 1002, 45000, 1, 45000),
(29, 113, 1002, 45000, 1, 45000),
(30, 114, 1002, 45000, 1, 45000),
(31, 115, 1112, 60000, 4, 375000),
(32, 115, 1113, 15000, 5, 375000),
(33, 115, 1115, 30000, 2, 375000),
(34, 116, 1112, 60000, 3, 270000),
(35, 116, 1115, 30000, 2, 270000),
(36, 116, 1113, 15000, 2, 270000),
(37, 117, 1112, 60000, 4, 375000),
(38, 117, 1115, 30000, 2, 375000),
(39, 117, 1113, 15000, 4, 375000),
(40, 117, 1118, 15000, 1, 375000),
(41, 118, 20241, 40000, 1, 125000),
(42, 118, 2024, 40000, 1, 125000),
(43, 118, 1002, 45000, 1, 125000),
(44, 119, 1112, 60000, 3, 298000),
(45, 119, 1113, 15000, 3, 298000),
(46, 119, 1118, 13000, 1, 298000),
(47, 119, 1115, 30000, 2, 298000),
(48, 120, 1112, 60000, 5, 453000),
(49, 120, 1113, 15000, 5, 453000),
(50, 120, 1115, 30000, 2, 453000),
(51, 120, 1118, 18000, 1, 453000),
(52, 121, 1112, 60000, 5, 405000),
(53, 121, 1113, 15000, 5, 405000),
(54, 121, 1115, 30000, 1, 405000),
(55, 122, 1112, 60000, 5, 452000),
(56, 122, 1113, 15000, 5, 452000),
(57, 122, 1115, 30000, 2, 452000),
(58, 122, 1117, 17000, 1, 452000),
(59, 123, 1112, 60000, 5, 452000),
(60, 123, 1113, 15000, 5, 452000),
(61, 123, 1115, 30000, 2, 452000),
(62, 123, 1117, 17000, 1, 452000),
(63, 124, 1112, 60000, 5, 457500),
(64, 124, 1113, 15000, 5, 457500),
(65, 124, 1115, 30000, 2, 457500),
(66, 124, 1118, 22500, 1, 457500),
(67, 125, 1112, 60000, 5, 435000),
(68, 125, 1115, 30000, 2, 435000),
(69, 125, 1113, 15000, 5, 435000),
(70, 126, 1112, 60000, 5, 435000),
(71, 126, 1113, 15000, 5, 435000),
(72, 126, 1115, 30000, 2, 435000),
(73, 127, 1112, 60000, 5, 435000),
(74, 127, 1113, 15000, 5, 435000),
(75, 127, 1115, 30000, 2, 435000),
(76, 128, 1112, 60000, 5, 435000),
(77, 128, 1113, 15000, 5, 435000),
(78, 128, 1115, 30000, 2, 435000),
(79, 129, 1112, 60000, 5, 435000),
(80, 129, 1113, 15000, 5, 435000),
(81, 129, 1115, 30000, 2, 435000),
(82, 130, 1112, 60000, 5, 435000),
(83, 130, 1113, 15000, 5, 435000),
(84, 130, 1115, 30000, 2, 435000),
(85, 131, 1112, 60000, 4, 360000),
(86, 131, 1113, 15000, 4, 360000),
(87, 131, 1115, 30000, 2, 360000),
(88, 132, 1112, 60000, 4, 360000),
(89, 132, 1113, 15000, 4, 360000),
(90, 132, 1115, 30000, 2, 360000),
(91, 133, 1112, 60000, 2, 210000),
(92, 133, 1113, 15000, 2, 210000),
(93, 133, 1115, 30000, 2, 210000),
(94, 134, 1112, 60000, 2, 210000),
(95, 134, 1113, 15000, 2, 210000),
(96, 134, 1115, 30000, 2, 210000),
(97, 135, 1112, 60000, 5, 435000),
(98, 135, 1113, 15000, 5, 435000),
(99, 135, 1115, 30000, 2, 435000),
(100, 136, 1112, 60000, 5, 435000),
(101, 136, 1113, 15000, 5, 435000),
(102, 136, 1115, 30000, 2, 435000),
(103, 137, 1112, 60000, 6, 495000),
(104, 137, 1113, 15000, 5, 495000),
(105, 137, 1115, 30000, 2, 495000),
(106, 138, 1112, 60000, 4, 375000),
(107, 138, 1113, 15000, 5, 375000),
(108, 138, 1115, 30000, 2, 375000),
(109, 140, 1112, 60000, 23, 1905000),
(110, 140, 1113, 15000, 23, 1905000),
(111, 140, 1115, 30000, 6, 1905000);

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `stat_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `qty_produced` int(11) NOT NULL,
  `buying_price_per_each` int(11) NOT NULL,
  `selling_price_per_each` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `total_revenue` int(11) NOT NULL,
  `Gross_profit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stockin`
--

CREATE TABLE `stockin` (
  `stockin_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `stockin_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `product_status` enum('active','inactive') NOT NULL,
  `date_stock_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_order`
--

CREATE TABLE `temp_order` (
  `temp_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_purchase`
--

CREATE TABLE `temp_purchase` (
  `temp_purchase_id` int(11) NOT NULL,
  `input_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `barcode` int(100) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_trans`
--

CREATE TABLE `temp_trans` (
  `temp_trans_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tribe`
--

CREATE TABLE `tribe` (
  `tribe_id` int(11) NOT NULL,
  `tribe_name` varchar(100) NOT NULL,
  `tribe_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tribe`
--

INSERT INTO `tribe` (`tribe_id`, `tribe_name`, `tribe_status`) VALUES
(1, 'Nyamwezi', 'active'),
(2, 'Nyakyusa', 'active'),
(3, 'Chaga', 'active'),
(4, 'Msukuma', 'active'),
(5, 'Mhehe', 'active'),
(6, 'Mhaya', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_type` enum('master','user') NOT NULL,
  `last_login` bigint(20) NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_email`, `user_password`, `user_name`, `user_type`, `last_login`, `user_status`) VALUES
(1, 'bmuyabaga@gmail.com', '$2y$10$sc/R0zVrCdxLDrs05vdBAukCUQPzSBFGUhieJcIYGAWBckrZUkLBi', 'Baraka Muyabaga', 'master', 1709857757, 'Active'),
(4, 'ppatricia@gmail.com', '$2y$10$E6pzDU3dNfEQDG2qkB4c3O7wTNnNaKInVPcLIZPevicbEs5SBvPKS', 'Patricia', 'user', 0, 'Inactive'),
(5, 'fgasper@gmail.com', '$2y$10$lfFy2zcRpfTf0T1sHYpTl.pPocCqbTZZNvDGi0wAkR.LcxrKlWgEi', 'Flora', 'user', 1643715510, 'Active'),
(6, 'mmuyabaga@gmail.com', '$2y$10$eBcQoaMb47qUzBR2Uj4M4Ocx5U590GK9jPtH6dXOJ5RTYayBxLeNG', 'Mwanahamisi', 'user', 0, 'Active'),
(8, 'amuyabaga@gmail.com', '$2y$10$2d/gxlhoF5SkQNf3dE9eeeVrvEeDuHJMwVMtwqn4WZ6rjBy52MzOK', 'Avniel', 'user', 0, 'Active'),
(10, 'deboramogosi@gmail.com', '$2y$10$bLMRMMHLcDj/dyKj0IcvFuB6VBymIy.dy72EYVdcOAjC4X8I8GnPq', 'Debora', 'user', 1643650922, 'Active'),
(11, 'benjamin@gmail.com', '$2y$10$fZgKL8dYUn99.czyVGXrkO2t.XUkq7rHflwhfzsWui0KPnk2/mus6', 'Benjamin Raphael', 'user', 0, 'Inactive'),
(13, 'john@gmail.com', '$2y$10$Zek2ysZsH71FSpx2BKXzqOLGei.BY.OikNYqgkLn40FTrWwqj8ssm', 'John', 'master', 0, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vname` varchar(255) NOT NULL,
  `contactno` varchar(50) NOT NULL,
  `tin_no` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `total_outstanding` int(11) NOT NULL,
  `recorded_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `user_id`, `vname`, `contactno`, `tin_no`, `email`, `address`, `notes`, `total_outstanding`, `recorded_on`, `status`) VALUES
(1, 0, 'Lazaro Dar', '768456588', '34525', 'test@gmail.com', 'Dar es Salaam', '', 0, '2021-08-06 02:49:23', 'active'),
(2, 0, 'Ennie', '717003456', '456377', 'admin@phpzag.com', 'Dar Es Salaam', '', 0, '2021-08-06 02:49:23', 'active'),
(3, 0, 'Avniel', '666666', '4774883', 'test@gmail.com', 'Tomondo', '', 500, '2022-01-04 12:17:06', 'active'),
(4, 0, 'Debora Gasper', '666666', '45636', 'test@gmail.com', 'Tomondo', 'Good', 0, '2021-08-06 17:56:52', 'active'),
(5, 0, 'Baraka Muyabaga', '666666', '54382', 'test@gmail.com', 'Tomondo', 'yes', 0, '2021-08-06 17:56:25', 'active'),
(6, 0, 'Sarah Mwanza', '23454', '8879968', 'test@gmail.com', 'Mwanza', '', 0, '2021-08-06 02:49:23', 'active'),
(7, 0, 'Paulo Tabora', '666666', '58896', 'test@gmail.com', 'Tabora', '', 0, '2021-08-06 02:49:23', 'active'),
(8, 0, 'Melia Zanzibar', '666666', '34553', 'test@gmail.com', 'kiwengwa', '', 0, '2021-08-06 02:49:23', 'active'),
(9, 0, 'Debora', '111111', '88744', 'admin@flexibleit.net', 'kisauni', '', 0, '2021-08-06 02:49:23', 'active'),
(10, 0, 'Baraka Muyabaga', '716735367', '994883', 'bmuyabaga@gmail.com', 'tomondo', '', 0, '2021-08-06 02:49:23', 'active'),
(11, 0, 'Mombasa Supermarket', '715985677', '46647', 'test@gmail.com', 'Mombasa', '', 0, '2021-08-06 02:49:23', 'active'),
(12, 1, 'Adelphina Jacobo', '455546', '555555', 'adel@gmail.com', 'Kisauni', '', 0, '2021-08-06 03:56:27', 'active'),
(13, 1, 'Adelphina Jacobo', '455546', '555555', 'adel@gmail.com', 'Kisauni', '', 0, '2021-08-06 18:40:24', 'active'),
(14, 1, 'Adelphina Jacobo', '455546', '555555', 'adel@gmail.com', 'Kisauni', '', 0, '2021-08-06 18:40:26', 'active'),
(15, 1, 'Chai Bora Company Limited', '455546', '555555', 'adel@gmail.com', 'Kisauni', 'good', 0, '2022-01-20 12:24:18', 'inactive'),
(16, 1, 'Tanga Fresh', '455546', '111111', 'test@gmail.com', 'Kisauni', 'good', -77236975, '2022-01-20 12:23:17', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `customer_order_item`
--
ALTER TABLE `customer_order_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_price`
--
ALTER TABLE `custom_price`
  ADD PRIMARY KEY (`custom_price_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `region_id` (`region_id`),
  ADD KEY `tribe_id` (`tribe_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expaccount`
--
ALTER TABLE `expaccount`
  ADD PRIMARY KEY (`expenseaccount_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `history_log`
--
ALTER TABLE `history_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `loan_payment`
--
ALTER TABLE `loan_payment`
  ADD PRIMARY KEY (`loan_payment_id`);

--
-- Indexes for table `nmb`
--
ALTER TABLE `nmb`
  ADD PRIMARY KEY (`nmb_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_input`
--
ALTER TABLE `product_input`
  ADD PRIMARY KEY (`input_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_item`
--
ALTER TABLE `purchase_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_payment`
--
ALTER TABLE `purchase_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`region_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `sales_item`
--
ALTER TABLE `sales_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`stat_id`);

--
-- Indexes for table `stockin`
--
ALTER TABLE `stockin`
  ADD PRIMARY KEY (`stockin_id`);

--
-- Indexes for table `temp_order`
--
ALTER TABLE `temp_order`
  ADD PRIMARY KEY (`temp_order_id`);

--
-- Indexes for table `temp_purchase`
--
ALTER TABLE `temp_purchase`
  ADD PRIMARY KEY (`temp_purchase_id`);

--
-- Indexes for table `temp_trans`
--
ALTER TABLE `temp_trans`
  ADD PRIMARY KEY (`temp_trans_id`);

--
-- Indexes for table `tribe`
--
ALTER TABLE `tribe`
  ADD PRIMARY KEY (`tribe_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_order_item`
--
ALTER TABLE `customer_order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `custom_price`
--
ALTER TABLE `custom_price`
  MODIFY `custom_price_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expaccount`
--
ALTER TABLE `expaccount`
  MODIFY `expenseaccount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_payment`
--
ALTER TABLE `loan_payment`
  MODIFY `loan_payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nmb`
--
ALTER TABLE `nmb`
  MODIFY `nmb_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_input`
--
ALTER TABLE `product_input`
  MODIFY `input_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `purchase_payment`
--
ALTER TABLE `purchase_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `sales_item`
--
ALTER TABLE `sales_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stockin`
--
ALTER TABLE `stockin`
  MODIFY `stockin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_order`
--
ALTER TABLE `temp_order`
  MODIFY `temp_order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_purchase`
--
ALTER TABLE `temp_purchase`
  MODIFY `temp_purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_trans`
--
ALTER TABLE `temp_trans`
  MODIFY `temp_trans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tribe`
--
ALTER TABLE `tribe`
  MODIFY `tribe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
