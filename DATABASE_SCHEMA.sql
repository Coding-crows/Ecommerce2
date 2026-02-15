-- =====================================================
-- E-COMMERCE PORTAL - COMPLETE DATABASE SCHEMA
-- =====================================================

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `phone` varchar(255) UNIQUE,
  `is_login` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `venders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `business_type` varchar(255) NOT NULL,
  `gst_number` varchar(255) NOT NULL,
  `business_category` varchar(255) NOT NULL,
  `bank_account_no` varchar(255) NOT NULL,
  `payment_methord` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'unverifide',
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `c_name` varchar(255) NOT NULL,
  `c_commision` varchar(255) NOT NULL,
  `p_c_id` bigint UNSIGNED,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `products` (
  `p_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `v_id` varchar(255) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_price` varchar(255) NOT NULL,
  `c_id` varchar(255) NOT NULL,
  `p_stock` varchar(255) NOT NULL,
  `p_description` text NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  KEY `idx_vendor_id` (`v_id`),
  KEY `idx_category_id` (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `banners` (
  `b_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `b_image` varchar(255) NOT NULL,
  `b_alt` varchar(255) NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `carts` (
  `cart_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` varchar(255) NOT NULL,
  `p_id` varchar(255) NOT NULL,
  `p_qty` varchar(255) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_price` varchar(255) NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  KEY `idx_user_id` (`user_id`),
  KEY `idx_product_id` (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `billing` (
  `bill_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint UNSIGNED NOT NULL,
  `country` varchar(255),
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `landmark` varchar(255),
  `city` varchar(255) NOT NULL,
  `state` varchar(255),
  `address` text NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_no` varchar(255) NOT NULL UNIQUE,
  `status` varchar(255) DEFAULT 'pending',
  `payment_mode` varchar(255),
  `total` decimal(10,2) DEFAULT 0,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `order_items` (
  `order_item_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_id` bigint UNSIGNED NOT NULL,
  `p_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255),
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL PRIMARY KEY,
  `user_id` bigint UNSIGNED,
  `ip_address` varchar(45),
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL PRIMARY KEY,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL PRIMARY KEY,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL PRIMARY KEY,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int,
  `created_at` int NOT NULL,
  `finished_at` int
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_users_phone ON users(phone);
CREATE INDEX idx_venders_email ON venders(email);
CREATE INDEX idx_venders_status ON venders(status);
CREATE INDEX idx_categories_name ON categories(c_name);
CREATE INDEX idx_products_name ON products(p_name);
CREATE INDEX idx_products_vendor ON products(v_id);
CREATE INDEX idx_products_category ON products(c_id);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_orders_date ON orders(created_at);
CREATE INDEX idx_carts_user ON carts(user_id);
CREATE INDEX idx_billing_user ON billing(user_id);
