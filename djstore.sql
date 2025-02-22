-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2025 at 01:25 PM
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
-- Database: `djstore`
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
  `skin` varchar(15) NOT NULL,
  `branch_timezone` varchar(150) NOT NULL,
  `branch_currency` varchar(30) NOT NULL,
  `branch_added_on` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `branch_address`, `branch_contact`, `branch_email`, `tin_noo`, `skin`, `branch_timezone`, `branch_currency`, `branch_added_on`, `user_id`) VALUES
(1, 'Muyabaga', 'Pwani, Kibaha,Maili Moja', '+255 658579646,+255 718030268', 'info@bethelbd.com', '157-345-657', 'green', 'Africa/Dar_es_Salaam', 'TZS', '2025-01-20 12:18:00', 1);

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
(1, 1, 'Chai Bora', 'active'),
(2, 4, 'Chai Bora', 'active'),
(3, 3, 'Chai Bora', 'active'),
(4, 2, 'Chai Bora', 'active'),
(5, 1, 'Africafe', 'active'),
(6, 4, 'Africafe', 'active'),
(7, 3, 'Africafe', 'active'),
(8, 2, 'Africafe', 'active'),
(9, 5, 'Africa\'s Best Coffee', 'active'),
(10, 6, 'Africa\'s Best Coffee', 'active'),
(11, 8, 'Lavazza', 'active'),
(12, 7, 'Amimza', 'active'),
(13, 7, 'Chai Bora', 'active'),
(14, 7, 'Africafe', 'active');

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
(1, 'Black Tea', 'active'),
(2, 'Infusions Tea', 'active'),
(3, 'Green Tea', 'active'),
(4, 'Flavoured Black Tea', 'active'),
(5, 'Coffee Beans', 'active'),
(6, 'Ground Coffee', 'active'),
(7, 'Instant Coffee', 'active'),
(8, 'Coffee Capsules', 'active');

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
  `country` varchar(255) NOT NULL,
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
(1, 'Mimi', 'Unguja', 'Kisauni', 'Kisauni', 3, 'prepay', 2, '111-1111-111', '0', 'Tanzania', '255', 'good', 1, 0, '2025-02-10 00:43:27', 'active', 'image_client/user.png'),
(2, 'Utalii Cafe-Mr Lesseni', 'Unguja', 'Kisauni', 'Kisauni', 3, 'prepay', 5000, '111-1111-111', 'y-345-278', 'Tanzania', '255', 'good', 1, 0, '2025-02-10 00:43:27', 'active', 'image_client/banana-ripen-1-300x300.png'),
(3, 'Suvacor Limited', 'Zanzibar', 'Kombeni', 'Zanzibar', 2, 'prepay', 200000, '127-374-481', 'nil', 'Tanzania', '255', '', 1, 0, '2025-02-10 00:43:27', 'active', 'image_client/Raba.jpg'),
(4, '101 Investment', 'Zanzibar', 'Nungwi', 'Machina mwanzo', 7, 'prepay', 8000, '123-4664-377', '40-025029-G', 'Tanzania', '43305', 'good', 1, 0, '2025-02-10 00:43:27', 'active', 'image_client/WhatsApp Image 2025-01-22 at 11.12.09 (1).jpeg'),
(5, 'DJ Store', 'Zanzibar', 'Nungwi', 'Machina mwanzo', 5, 'invoice_date', 7000, '123-4664-3775', 'Z464664646', 'Tanzania', '43305', 'excellent', 1, 0, '2025-02-10 00:43:27', 'active', 'image_client/WIN_20241022_00_25_33_Pro.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `contact_name` varchar(200) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `phone2` varchar(30) DEFAULT NULL,
  `email_address` varchar(50) NOT NULL,
  `email2` varchar(50) DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `customer_id`, `title`, `contact_name`, `phone_number`, `phone2`, `email_address`, `email2`, `position_id`, `comments`, `user_id`, `contact_status`) VALUES
(1, 3, 'Ms', 'Mpoki Mwanjala', '0754662244', '0765778844', 'mpoki@gmail.com', NULL, 1, '35 years', 1, 'active'),
(2, 3, 'Mr', 'Baraka Muyabaga', '0781330952', '', 'bmuyabaga@gmail.com', 'bmuyabaga@gmail.com', 8, 'fffff', 1, 'active'),
(3, 3, 'Mr', 'Debora Muyabaga', '0756455631', '0763773389', 'debora@gmail.com', 'info@gmail.com', 1, 'Good Manager', 1, 'active'),
(4, 1, 'Miss', 'Joseph Msuya', '0743552677', '0752772699', 'joseph@gmail.com', 'msuya@gmail.com', 10, 'good', 1, 'active');

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
-- Table structure for table `credit_settings`
--

CREATE TABLE `credit_settings` (
  `credit_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `max_credit` int(11) NOT NULL,
  `payterms` varchar(50) NOT NULL,
  `days` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `credit_status` enum('Enable','Disable') NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_settings`
--

INSERT INTO `credit_settings` (`credit_id`, `client_id`, `max_credit`, `payterms`, `days`, `user_id`, `credit_status`, `created_at`) VALUES
(1, 1, 300000, 'eom', 20, 1, 'Enable', '2025-01-26 19:50:18'),
(2, 2, 150000, 'invoice_date', 10, 1, 'Enable', '2025-01-27 05:46:23'),
(3, 3, 1500000, 'eom', 30, 1, 'Enable', '2025-01-27 05:56:33'),
(8, 4, 2000000, 'invoice_date', 8, 1, 'Enable', '2025-01-27 06:51:08'),
(9, 5, 50000000, 'eom', 15, 1, 'Enable', '2025-01-28 04:48:36');

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
-- Table structure for table `due_invoices`
--

CREATE TABLE `due_invoices` (
  `due_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `sales_date` date NOT NULL,
  `sales_due_date` date NOT NULL,
  `due_status` enum('pending','paid') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `due_invoices`
--

INSERT INTO `due_invoices` (`due_id`, `client_id`, `sales_id`, `invoice_number`, `sales_date`, `sales_due_date`, `due_status`) VALUES
(1, 2, 1, 'INV20250001', '2025-02-12', '2025-02-22', 'pending'),
(2, 4, 2, 'INV20250002', '2025-02-12', '2025-02-20', 'pending'),
(3, 5, 3, 'INV20250003', '2025-02-12', '2025-03-15', 'pending'),
(4, 3, 4, 'INV20250004', '2025-02-12', '2025-03-30', 'pending');

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
-- Table structure for table `equity`
--

CREATE TABLE `equity` (
  `id` int(11) NOT NULL,
  `type` enum('capital','retained_earnings') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equity`
--

INSERT INTO `equity` (`id`, `type`, `amount`, `description`, `created_at`) VALUES
(1, 'capital', '10000.00', 'Initial investment by owner', '2025-02-07 00:01:34'),
(2, 'retained_earnings', '0.00', 'Quarterly retained earnings update', '2025-02-07 00:36:30'),
(3, 'retained_earnings', '0.00', 'Quarterly retained earnings update', '2025-02-07 00:36:33');

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
(1, 1, '2025-02-11', 16, 30000, 1, 'virtue', 30000, 'cash', 'accounting fee used', 'active', '2025-02-11 18:05:47', 1);

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
-- Table structure for table `income_statements`
--

CREATE TABLE `income_statements` (
  `income_statements_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_revenue` decimal(15,2) NOT NULL DEFAULT '0.00',
  `beginning_inventory` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_purchases` decimal(15,2) NOT NULL DEFAULT '0.00',
  `ending_inventory` decimal(15,2) NOT NULL DEFAULT '0.00',
  `cogs` decimal(15,2) NOT NULL DEFAULT '0.00',
  `gross_profit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_expenses` decimal(15,2) NOT NULL DEFAULT '0.00',
  `net_profit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `order_date` varchar(255) NOT NULL,
  `order_total` int(11) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders_item`
--

CREATE TABLE `orders_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `receipt_number` varchar(100) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
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
  `product_code` varchar(50) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `product_status` enum('active','inactive') NOT NULL,
  `product_date` date NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `brand_id`, `product_name`, `product_description`, `product_quantity`, `product_unit`, `product_base_price`, `product_tax`, `product_minimum_order`, `product_enter_by`, `product_code`, `barcode`, `product_status`, `product_date`, `branch_id`) VALUES
(1, 1, 1, 'Chai Bora Luxury Blend Tea Bags (24x50bags)', '24 Boxes a 50 Tea bags', 0, 'Box', 36000.00, '0.00', 0.00, 1, 'K0001', '123', 'active', '2025-02-10', 1),
(2, 2, 4, 'Chai Bora Organic Lemon Symphony Tea Bags (12x25bags)', '12 Boxes a 25 Tea Bags', 0, 'Box', 36000.00, '0.00', 0.00, 1, 'K0002', '', 'active', '2025-02-10', 1),
(3, 1, 1, 'Chai Bora Premium Blend Tea bags bulk packs (8 x 100 bags)', 'There are 8 packs in a carton and 1 pack contains 100 tea bags of 200g each', 0, 'Bags', 32000.00, '0.00', 0.00, 1, 'K0003', '', 'active', '2025-02-10', 1),
(4, 2, 4, 'Chai Bora Ginger Tea (12x25bags)', 'Chai Bora Ginger Tea (12x25 bags) Premium ginger-infused tea, perfect for a refreshing and spicy brew.', 6, 'Box', 36000.00, '0.00', 0.00, 1, 'K0004', '', 'active', '2025-02-10', 1),
(5, 2, 4, 'Chai Bora Organic Green Tea Bags (12x25bags)', '12 Boxes a 25 Tea Bags', 0, 'Box', 36000.00, '0.00', 0.00, 1, 'K0005', '', 'active', '2025-02-10', 1),
(6, 2, 4, 'Chai Bora African Infusions Organic Peppermint Tea Bags (12x25bags)', '12 Boxes a 25 Tea Bags', 0, 'Box', 48000.00, '0.00', 0.00, 1, 'K0006', '', 'active', '2025-02-10', 1),
(7, 2, 8, 'Kilimanjaro Infusion Tea Bags - Rooibos 18x50g (25 Bags)', 'A caffeine-free herbal tea with a smooth pleasant fragrance// 18 boxes a 25 Tea bags', 0, 'Box', 60000.00, '0.00', 0.00, 1, 'K0007', '', 'active', '2025-02-10', 1),
(8, 5, 9, 'Africa\'s Best - Tanzania Highlands 500g Retail - Coffee Beans', 'Africa\'s Best Coffee &amp; Tea Pure Premium Arabica Whole Roasted Coffee Beans, Resealable Zipper Bag with Aroma Valve', 0, 'Grams', 16600.00, '0.00', 0.00, 1, 'K0008', '', 'active', '2025-02-10', 1),
(9, 5, 9, 'Africa\'s Best - Kilimanjaro Peaks Roasted Coffee Beans 1kg', 'Roasted Coffee Beans, Premium Arabica AA &amp; Peaberry Tanzania, 1 Bag', 13, 'Kg', 28000.00, '0.00', 0.00, 1, 'K0009', '', 'active', '2025-02-10', 1),
(10, 6, 10, 'Africa\'s Best - Kilimanjaro Peaks 500g Retail - Ground Coffee', 'Africa\'s Best Coffee &amp; Tea  Pure Premium Arabica Ground Coffee, Resealable Zipper Bag with Aroma Valve', 10, 'Grams', 17400.00, '0.00', 0.00, 1, 'K00010', '', 'active', '2025-02-10', 1),
(11, 6, 10, 'Africa\'s Best - Tanzania Highlands Roasted Ground Coffee 1kg', 'Roasted Ground Coffee, 1 Bag', 0, 'Kg', 25000.00, '0.00', 0.00, 1, 'K00011', '', 'active', '2025-02-10', 1),
(12, 7, 12, 'Cafe Amimza 1.8g Instant Coffee Premium Sticks 25 x 12', 'This instant coffee captures the robust and smooth flavors of traditional coffee, offering a rich and aromatic experience in every cup.', 0, 'Rolls', 49000.00, '0.00', 0.00, 1, 'K00012', '', 'active', '2025-02-10', 1),
(13, 8, 11, 'Lavazza Blue Caffe Crema Lungo (100 capsules)', 'Espresso blend with a sweet, fragrant aroma', 0, 'Box', 172500.00, '0.00', 0.00, 1, 'K00013', '', 'active', '2025-02-10', 1),
(14, 7, 12, 'Caffe amimza instant coffee sachets 1.8g x 100 sachets', 'Ideal for breakfast', 0, 'Bags', 16000.00, '0.00', 0.00, 1, 'CA-1200', '', 'active', '2025-02-11', 0),
(15, 8, 11, 'Lavazza Intenso coffee capsules 1 x 100pcs', 'For espresso', 0, 'Box', 172000.00, '0.00', 0.00, 1, 'LB-100', '', 'active', '2025-02-11', 0),
(16, 2, 8, 'Veo Peanut Butter (12 x 880g)', 'Good', 0, 'Box', 54000.00, '0.00', 0.00, 1, 'VPB-880g', '', 'active', '2025-02-11', 0),
(17, 4, 6, 'Chai Bora Pure Masala(12x50bags)', 'Good quality', 0, 'Box', 81000.00, '0.00', 0.00, 1, 'CBM-0017', '', 'active', '2025-02-11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_batches`
--

CREATE TABLE `product_batches` (
  `product_batches_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `batch_number` varchar(50) NOT NULL,
  `production_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `stock` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `total_revenue` int(11) NOT NULL,
  `gross_profit` int(11) NOT NULL,
  `received_date` date NOT NULL,
  `batch_status` enum('Enable','Disable') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_batches`
--

INSERT INTO `product_batches` (`product_batches_id`, `purchase_id`, `product_id`, `product_code`, `batch_number`, `production_date`, `expiry_date`, `stock`, `cost`, `selling_price`, `total_cost`, `total_revenue`, `gross_profit`, `received_date`, `batch_status`, `created_at`) VALUES
(1, 1, 9, 'K0009', 'GC1KG-01', '2025-02-12', '2025-02-28', 0, 18000, 28000, 90000, 140000, 50000, '2025-02-12', 'Enable', '2025-02-12 02:00:43'),
(2, 1, 9, 'K0009', 'GC1KG-02', '2025-02-12', '2025-03-05', 13, 18000, 28000, 270000, 420000, 150000, '2025-02-12', 'Enable', '2025-02-12 02:01:44'),
(3, 1, 10, 'K00010', 'GC500G-01', '2025-02-12', '2025-03-05', 10, 13000, 17400, 195000, 261000, 66000, '2025-02-12', 'Enable', '2025-02-12 02:02:43'),
(4, 2, 4, 'K0004', 'GTB-01', '2025-02-12', '2025-02-25', 0, 28000, 36000, 140000, 180000, 40000, '2025-02-12', 'Enable', '2025-02-12 03:08:27'),
(5, 2, 4, 'K0004', 'GTB-02', '2025-02-12', '2025-02-28', 0, 28000, 36000, 140000, 180000, 40000, '2025-02-12', 'Enable', '2025-02-12 03:09:22'),
(6, 2, 4, 'K0004', 'GTB-03', '2025-02-12', '2025-03-12', 0, 28000, 36000, 336000, 432000, 96000, '2025-02-12', 'Enable', '2025-02-12 03:10:19'),
(7, 2, 4, 'K0004', 'GTB-04', '2025-02-12', '2025-07-10', 6, 28000, 36000, 224000, 288000, 64000, '2025-02-12', 'Enable', '2025-02-12 03:10:48');

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
  `receiving_status` enum('pending','partial','received') NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `user_id`, `vendor_id`, `date`, `total`, `discount`, `grandtotal`, `pay`, `balance`, `payment_type`, `receiving_status`, `status`) VALUES
(1, 1, '18', '2025-02-12', 555000, 0, 555000, 0, 555000, 'unpaid', 'received', 'active'),
(2, 1, '14', '2025-02-12', 840000, 0, 840000, 0, 840000, 'unpaid', 'received', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item`
--

CREATE TABLE `purchase_item` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `buying_price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `received_qty` int(11) NOT NULL DEFAULT '0',
  `total` int(11) NOT NULL,
  `purchase_item_status` enum('Pending','Partial','Received') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_item`
--

INSERT INTO `purchase_item` (`id`, `purchase_id`, `product_id`, `product_code`, `buying_price`, `qty`, `received_qty`, `total`, `purchase_item_status`) VALUES
(1, 1, 9, 0, 18000, 20, 20, 360000, 'Received'),
(2, 1, 10, 0, 13000, 15, 15, 195000, 'Received'),
(3, 2, 4, 0, 28000, 30, 30, 840000, 'Received');

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
  `invoice_number` varchar(50) NOT NULL,
  `date` date NOT NULL,
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

INSERT INTO `sales` (`sales_id`, `user_id`, `client_id`, `invoice_number`, `date`, `total`, `discount`, `grandtotal`, `pay`, `balance`, `payment_type`, `status`, `branch_id`) VALUES
(1, 1, '2', 'INV20250001', '2025-02-12', 84000, 0, 84000, 0, 84000, 'unpaid', 'active', 1),
(2, 1, '4', 'INV20250002', '2025-02-12', 199000, 0, 199000, 0, 199000, 'unpaid', 'active', 1),
(3, 1, '5', 'INV20250003', '2025-02-12', 108000, 0, 108000, 0, 108000, 'unpaid', 'active', 1),
(4, 1, '3', 'INV20250004', '2025-02-12', 756000, 0, 756000, 0, 756000, 'unpaid', 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_details_batches`
--

CREATE TABLE `sales_details_batches` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `batch_number` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `total_revenue` int(11) NOT NULL,
  `gross_profit` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_details_batches`
--

INSERT INTO `sales_details_batches` (`id`, `sale_id`, `product_id`, `product_code`, `batch_number`, `quantity`, `cost_price`, `selling_price`, `total_cost`, `total_revenue`, `gross_profit`, `created_at`) VALUES
(1, 1, 9, 'K0009', 'GC1KG-01', 3, 18000, 28000, 54000, 84000, 30000, '2025-02-12 02:14:37'),
(2, 2, 9, 'K0009', 'GC1KG-01', 2, 18000, 28000, 36000, 56000, 20000, '2025-02-12 02:17:05'),
(3, 2, 9, 'K0009', 'GC1KG-02', 2, 18000, 28000, 36000, 56000, 20000, '2025-02-12 02:17:05'),
(4, 2, 10, 'K00010', 'GC500G-01', 5, 13000, 17400, 65000, 87000, 22000, '2025-02-12 02:17:05'),
(5, 3, 4, 'K0004', 'GTB-01', 3, 28000, 36000, 84000, 108000, 24000, '2025-02-12 03:15:04'),
(6, 4, 4, 'K0004', 'GTB-01', 2, 28000, 36000, 56000, 72000, 16000, '2025-02-12 03:17:53'),
(7, 4, 4, 'K0004', 'GTB-02', 5, 28000, 36000, 140000, 180000, 40000, '2025-02-12 03:17:53'),
(8, 4, 4, 'K0004', 'GTB-03', 12, 28000, 36000, 336000, 432000, 96000, '2025-02-12 03:17:53'),
(9, 4, 4, 'K0004', 'GTB-04', 2, 28000, 36000, 56000, 72000, 16000, '2025-02-12 03:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `sales_item`
--

CREATE TABLE `sales_item` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_item`
--

INSERT INTO `sales_item` (`id`, `sales_id`, `product_id`, `product_code`, `selling_price`, `qty`, `total`) VALUES
(1, 1, 9, 'K0009', 28000, 3, 84000),
(2, 2, 9, 'K0009', 28000, 4, 112000),
(3, 2, 10, 'K00010', 17400, 5, 87000),
(4, 3, 4, 'K0004', 36000, 3, 108000),
(5, 4, 4, 'K0004', 36000, 21, 756000);

-- --------------------------------------------------------

--
-- Table structure for table `stockin`
--

CREATE TABLE `stockin` (
  `stockin_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_code` int(11) NOT NULL,
  `product_id` int(1) NOT NULL,
  `qty` int(11) NOT NULL,
  `stockin_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `stocking_status` enum('active','inactive') NOT NULL,
  `date_stock_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `store_id` int(11) NOT NULL,
  `store_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `store_address` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `store_contact_no` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `store_email_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `store_timezone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `store_currency` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `store_added_on` datetime NOT NULL,
  `store_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `store_name`, `store_address`, `store_contact_no`, `store_email_address`, `store_timezone`, `store_currency`, `store_added_on`, `store_updated_on`) VALUES
(1, 'Belinda Fashion', 'Kariakoo Zanzibar', '0785535535', 'bmuyabaga@gmail.com', 'Africa/Dar_es_Salaam', 'UGX', '2024-12-29 07:07:30', '2024-12-29 07:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `tax_id` int(11) NOT NULL,
  `tax_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tax_percentage` decimal(4,2) NOT NULL,
  `tax_status` enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL,
  `tax_added_on` datetime NOT NULL,
  `tax_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`tax_id`, `tax_name`, `tax_percentage`, `tax_status`, `tax_added_on`, `tax_updated_on`) VALUES
(1, 'SGST', '9.00', 'Enable', '2022-05-10 18:13:13', '2022-05-10 18:27:39'),
(2, 'CGST', '9.00', 'Enable', '2022-05-10 18:29:44', '2022-05-10 18:29:44'),
(3, 'VAT', '15.00', 'Disable', '2024-12-29 09:15:04', '2024-12-29 09:15:04'),
(4, 'Stamp Duty', '3.00', 'Enable', '2025-01-17 06:06:46', '2025-01-17 06:06:46'),
(5, 'Excise Duty', '25.00', 'Enable', '2025-01-17 06:07:35', '2025-01-17 06:07:35');

-- --------------------------------------------------------

--
-- Table structure for table `temp_purchase`
--

CREATE TABLE `temp_purchase` (
  `temp_purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `product_code` int(100) NOT NULL,
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
  `total` int(11) NOT NULL,
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
  `user_type` enum('master','user','office') NOT NULL,
  `last_login` bigint(20) NOT NULL,
  `user_status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_email`, `user_password`, `user_name`, `user_type`, `last_login`, `user_status`) VALUES
(1, 'bmuyabaga@gmail.com', '$2y$10$sc/R0zVrCdxLDrs05vdBAukCUQPzSBFGUhieJcIYGAWBckrZUkLBi', 'Baraka Muyabaga', 'master', 1740096584, 'Active'),
(4, 'ppatricia@gmail.com', '$2y$10$E6pzDU3dNfEQDG2qkB4c3O7wTNnNaKInVPcLIZPevicbEs5SBvPKS', 'Patricia', 'user', 0, 'Inactive'),
(5, 'fgasper@gmail.com', '$2y$10$lfFy2zcRpfTf0T1sHYpTl.pPocCqbTZZNvDGi0wAkR.LcxrKlWgEi', 'Flora', 'office', 1643715510, 'Active'),
(6, 'mmuyabaga@gmail.com', '$2y$10$eBcQoaMb47qUzBR2Uj4M4Ocx5U590GK9jPtH6dXOJ5RTYayBxLeNG', 'Mwanahamisi', 'user', 0, 'Active'),
(8, 'amuyabaga@gmail.com', '$2y$10$2d/gxlhoF5SkQNf3dE9eeeVrvEeDuHJMwVMtwqn4WZ6rjBy52MzOK', 'Avniel', 'user', 0, 'Active'),
(10, 'deboramogosi@gmail.com', '$2y$10$bLMRMMHLcDj/dyKj0IcvFuB6VBymIy.dy72EYVdcOAjC4X8I8GnPq', 'Debora', 'office', 1643650922, 'Active'),
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
(3, 0, 'Avniel', '666666', '4774883', 'test@gmail.com', 'Tomondo', '', 0, '2025-02-10 00:33:17', 'active'),
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
(14, 1, 'Adelphina Jacobo', '455546', '555555', 'adel@gmail.com', 'Kisauni', '', 1140000, '2025-02-12 03:06:50', 'active'),
(15, 1, 'Chai Bora Company Limited', '455546', '555555', 'adel@gmail.com', 'Kisauni', 'good', 3450000, '2025-02-10 01:36:58', 'active'),
(16, 1, 'Tanga Fresh', '455546', '111111', 'test@gmail.com', 'Kisauni', 'good', 0, '2025-02-10 00:33:17', 'active'),
(17, 1, 'Luig Lavazza', '074535665', '557777', 'luig@lavazza.com', 'Italy', 'Leading Company', 5280000, '2025-02-10 01:38:40', 'active'),
(18, 1, 'Suvacor Limited', '0767772262', '10028819', 'znz@suvacor.com', 'Msasani', 'Coffee producer', 2975000, '2025-02-12 01:57:39', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_alerts`
--

CREATE TABLE `warehouse_alerts` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `received_quantity` int(11) DEFAULT '0',
  `status` enum('Pending','Partial','Received') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse_alerts`
--

INSERT INTO `warehouse_alerts` (`id`, `purchase_id`, `product_id`, `product_code`, `quantity`, `received_quantity`, `status`, `created_at`) VALUES
(1, 1, 9, '0', 20, 20, 'Received', '2025-02-12 01:57:39'),
(2, 1, 10, '0', 15, 15, 'Received', '2025-02-12 01:57:39'),
(3, 2, 4, '0', 30, 30, 'Received', '2025-02-12 03:06:50');

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
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `credit_settings`
--
ALTER TABLE `credit_settings`
  ADD PRIMARY KEY (`credit_id`);

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
-- Indexes for table `due_invoices`
--
ALTER TABLE `due_invoices`
  ADD PRIMARY KEY (`due_id`);

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
-- Indexes for table `equity`
--
ALTER TABLE `equity`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `income_statements`
--
ALTER TABLE `income_statements`
  ADD PRIMARY KEY (`income_statements_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD PRIMARY KEY (`order_item_id`);

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
-- Indexes for table `product_batches`
--
ALTER TABLE `product_batches`
  ADD PRIMARY KEY (`product_batches_id`);

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
-- Indexes for table `sales_details_batches`
--
ALTER TABLE `sales_details_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_item`
--
ALTER TABLE `sales_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stockin`
--
ALTER TABLE `stockin`
  ADD PRIMARY KEY (`stockin_id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`tax_id`);

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
-- Indexes for table `warehouse_alerts`
--
ALTER TABLE `warehouse_alerts`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `credit_settings`
--
ALTER TABLE `credit_settings`
  MODIFY `credit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- AUTO_INCREMENT for table `due_invoices`
--
ALTER TABLE `due_invoices`
  MODIFY `due_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equity`
--
ALTER TABLE `equity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `income_statements`
--
ALTER TABLE `income_statements`
  MODIFY `income_statements_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_payment`
--
ALTER TABLE `loan_payment`
  MODIFY `loan_payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nmb`
--
ALTER TABLE `nmb`
  MODIFY `nmb_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_item`
--
ALTER TABLE `orders_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_batches`
--
ALTER TABLE `product_batches`
  MODIFY `product_batches_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_details_batches`
--
ALTER TABLE `sales_details_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales_item`
--
ALTER TABLE `sales_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stockin`
--
ALTER TABLE `stockin`
  MODIFY `stockin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `warehouse_alerts`
--
ALTER TABLE `warehouse_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
