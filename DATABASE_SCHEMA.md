# E-Commerce Portal - Database Schema Documentation

**Database Name:** `ecommerce`
**Created:** February 3, 2026
**Engine:** InnoDB
**Charset:** utf8mb4 (Unicode support)

---

## Table of Contents
1. [Users Table](#users)
2. [Venders Table](#venders)
3. [Categories Table](#categories)
4. [Products Table](#products)
5. [Banners Table](#banners)
6. [Carts Table](#carts)
7. [Billing Table](#billing)
8. [Orders Table](#orders)
9. [Order Items Table](#order-items)
10. [Sessions Table](#sessions)
11. [Password Reset Tokens Table](#password-reset-tokens)
12. [Cache Table](#cache)
13. [Jobs Table](#jobs)

---

## <a name="users"></a>1. Users Table

**Purpose:** Store customer/user account information

```sql
CREATE TABLE `users` (
  `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `phone` varchar(255) UNIQUE NULLABLE,
  `is_login` boolean DEFAULT false,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| user_id | BIGINT UNSIGNED | NO | Primary Key, Auto Increment |
| phone | VARCHAR(255) | YES | Unique phone number |
| is_login | BOOLEAN | NO | Login status (default: false) |
| created_at | TIMESTAMP | YES | Record creation timestamp |
| updated_at | TIMESTAMP | YES | Last update timestamp |

---

## <a name="venders"></a>2. Venders Table

**Purpose:** Store vendor/seller information

```sql
CREATE TABLE `venders` (
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
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| id (v_id) | BIGINT UNSIGNED | NO | Primary Key |
| fullname | VARCHAR(255) | NO | Vendor's full name |
| phone | VARCHAR(255) | NO | Contact number |
| email | VARCHAR(255) | NO | Email address |
| password | VARCHAR(255) | NO | Encrypted password |
| address | TEXT | NO | Business address |
| id_number | VARCHAR(255) | NO | Government ID number |
| business_name | VARCHAR(255) | NO | Official business name |
| business_type | VARCHAR(255) | NO | Type of business |
| gst_number | VARCHAR(255) | NO | GST number |
| business_category | VARCHAR(255) | NO | Business category |
| bank_account_no | VARCHAR(255) | NO | Bank account number |
| payment_methord | VARCHAR(255) | NO | Payment method |
| image | VARCHAR(255) | NO | Vendor image/profile photo |
| status | VARCHAR(255) | NO | Verification status (default: unverifide) |
| created_at | TIMESTAMP | YES | Record creation timestamp |
| updated_at | TIMESTAMP | YES | Last update timestamp |

---

## <a name="categories"></a>3. Categories Table

**Purpose:** Store product categories

```sql
CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `c_name` varchar(255) NOT NULL,
  `c_commision` varchar(255) NOT NULL,
  `p_c_id` bigint UNSIGNED NULLABLE,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| id (c_id) | BIGINT UNSIGNED | NO | Primary Key |
| c_name | VARCHAR(255) | NO | Category name |
| c_commision | VARCHAR(255) | NO | Commission percentage |
| p_c_id | BIGINT UNSIGNED | YES | Parent category ID (for subcategories) |
| created_at | TIMESTAMP | YES | Record creation timestamp |
| updated_at | TIMESTAMP | YES | Last update timestamp |

---

## <a name="products"></a>4. Products Table

**Purpose:** Store product information

```sql
CREATE TABLE `products` (
  `p_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `v_id` varchar(255) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_price` varchar(255) NOT NULL,
  `c_id` varchar(255) NOT NULL,
  `p_stock` varchar(255) NOT NULL,
  `p_description` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| p_id | BIGINT UNSIGNED | NO | Primary Key |
| v_id | VARCHAR(255) | NO | Vendor ID (Foreign Key - venders.id) |
| p_name | VARCHAR(255) | NO | Product name |
| p_price | VARCHAR(255) | NO | Product price |
| c_id | VARCHAR(255) | NO | Category ID (Foreign Key - categories.id) |
| p_stock | VARCHAR(255) | NO | Stock quantity |
| p_description | VARCHAR(255) | NO | Product description |
| p_image | VARCHAR(255) | NO | Product image path |
| created_at | TIMESTAMP | YES | Record creation timestamp |
| updated_at | TIMESTAMP | YES | Last update timestamp |

---

## <a name="banners"></a>5. Banners Table

**Purpose:** Store promotional banner information

```sql
CREATE TABLE `banners` (
  `b_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `b_image` varchar(255) NOT NULL,
  `b_alt` varchar(255) NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| b_id | BIGINT UNSIGNED | NO | Primary Key |
| b_image | VARCHAR(255) | NO | Banner image path |
| b_alt | VARCHAR(255) | NO | Alt text for image |
| created_at | TIMESTAMP | YES | Record creation timestamp |
| updated_at | TIMESTAMP | YES | Last update timestamp |

---

## <a name="carts"></a>6. Carts Table

**Purpose:** Store shopping cart items

```sql
CREATE TABLE `carts` (
  `cart_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` varchar(255) NOT NULL,
  `p_id` varchar(255) NOT NULL,
  `p_qty` varchar(255) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_price` varchar(255) NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| cart_id | BIGINT UNSIGNED | NO | Primary Key |
| user_id | VARCHAR(255) | NO | User ID (Foreign Key - users.user_id) |
| p_id | VARCHAR(255) | NO | Product ID (Foreign Key - products.p_id) |
| p_qty | VARCHAR(255) | NO | Quantity in cart |
| p_name | VARCHAR(255) | NO | Product name (denormalized) |
| p_price | VARCHAR(255) | NO | Product price (denormalized) |
| created_at | TIMESTAMP | YES | Record creation timestamp |
| updated_at | TIMESTAMP | YES | Last update timestamp |

---

## <a name="billing"></a>7. Billing Table

**Purpose:** Store billing/shipping address information

```sql
CREATE TABLE `billing` (
  `bill_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint UNSIGNED NOT NULL,
  `country` varchar(255) NULLABLE,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `landmark` varchar(255) NULLABLE,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NULLABLE,
  `address` text NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| bill_id | BIGINT UNSIGNED | NO | Primary Key |
| user_id | BIGINT UNSIGNED | NO | User ID (Foreign Key - users.user_id) |
| country | VARCHAR(255) | YES | Country name |
| fullname | VARCHAR(255) | NO | Full name for billing |
| email | VARCHAR(255) | NO | Email address |
| pincode | VARCHAR(255) | NO | Postal code |
| landmark | VARCHAR(255) | YES | Nearby landmark |
| city | VARCHAR(255) | NO | City name |
| state | VARCHAR(255) | YES | State/Province |
| address | TEXT | NO | Complete address |
| created_at | TIMESTAMP | YES | Record creation timestamp |
| updated_at | TIMESTAMP | YES | Last update timestamp |

---

## <a name="orders"></a>8. Orders Table

**Purpose:** Store order information

```sql
CREATE TABLE `orders` (
  `order_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_no` varchar(255) NOT NULL UNIQUE,
  `status` varchar(255) DEFAULT 'pending',
  `payment_mode` varchar(255) NULLABLE,
  `total` decimal(10,2) DEFAULT 0,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| order_id | BIGINT UNSIGNED | NO | Primary Key |
| user_id | BIGINT UNSIGNED | NO | User ID (Foreign Key - users.user_id) |
| order_no | VARCHAR(255) | NO | Unique order number |
| status | VARCHAR(255) | NO | Order status (default: pending) |
| payment_mode | VARCHAR(255) | YES | Payment method used |
| total | DECIMAL(10,2) | NO | Total order amount |
| created_at | TIMESTAMP | YES | Record creation timestamp |
| updated_at | TIMESTAMP | YES | Last update timestamp |

---

## <a name="order-items"></a>9. Order Items Table

**Purpose:** Store individual items in an order

```sql
CREATE TABLE `order_items` (
  `order_item_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_id` bigint UNSIGNED NOT NULL,
  `p_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) NULLABLE,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| order_item_id | BIGINT UNSIGNED | NO | Primary Key |
| order_id | BIGINT UNSIGNED | NO | Order ID (Foreign Key - orders.order_id) |
| p_id | BIGINT UNSIGNED | NO | Product ID (Foreign Key - products.p_id) |
| image | VARCHAR(255) | YES | Product image at time of order |
| name | VARCHAR(255) | NO | Product name at time of order |
| price | DECIMAL(10,2) | NO | Product price at time of order |
| qty | INT | NO | Quantity ordered |
| total | DECIMAL(10,2) | NO | Line total (price × qty) |
| created_at | TIMESTAMP | YES | Record creation timestamp |
| updated_at | TIMESTAMP | YES | Last update timestamp |

---

## <a name="sessions"></a>10. Sessions Table

**Purpose:** Store user session data for authentication

```sql
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL PRIMARY KEY,
  `user_id` bigint UNSIGNED NULLABLE,
  `ip_address` varchar(45) NULLABLE,
  `user_agent` text NULLABLE,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| id | VARCHAR(255) | NO | Primary Key - Session ID |
| user_id | BIGINT UNSIGNED | YES | Associated user ID |
| ip_address | VARCHAR(45) | YES | Client IP address |
| user_agent | TEXT | YES | Browser user agent |
| payload | LONGTEXT | NO | Serialized session data |
| last_activity | INT | NO | Unix timestamp of last activity |

---

## <a name="password-reset-tokens"></a>11. Password Reset Tokens Table

**Purpose:** Store password reset tokens

```sql
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL PRIMARY KEY,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| email | VARCHAR(255) | NO | Primary Key - Email address |
| token | VARCHAR(255) | NO | Reset token |
| created_at | TIMESTAMP | YES | Token creation timestamp |

---

## <a name="cache"></a>12. Cache Table

**Purpose:** Store cached data

```sql
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL PRIMARY KEY,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Nullable | Notes |
|--------|------|----------|-------|
| key | VARCHAR(255) | NO | Primary Key - Cache key |
| value | MEDIUMTEXT | NO | Cached value |
| expiration | INT | NO | Expiration timestamp |

---

## <a name="jobs"></a>13. Jobs Table

**Purpose:** Store queued jobs for background processing

```sql
CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULLABLE,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## Entity Relationship Diagram (ERD)

```
┌─────────────┐
│    users    │
├─────────────┤
│ user_id (PK)│
│ phone       │
│ is_login    │
└─────────────┘
       │
       │ 1:N
       ├──────────────┬─────────────────┬──────────────────┐
       │              │                 │                  │
       ▼              ▼                 ▼                  ▼
  ┌─────────┐   ┌──────────┐   ┌────────────┐    ┌──────────────┐
  │ orders  │   │ billing  │   │ sessions   │    │    carts     │
  ├─────────┤   ├──────────┤   ├────────────┤    ├──────────────┤
  │order_id │   │ bill_id  │   │ id (PK)    │    │ cart_id (PK) │
  │user_id  │   │ user_id  │   │ user_id    │    │ user_id      │
  │order_no │   │address   │   │ payload    │    │ p_id         │
  │status   │   │email     │   └────────────┘    │ p_qty        │
  │total    │   │fullname  │                     │ p_name       │
  └─────────┘   └──────────┘                     │ p_price      │
       │                                         └──────────────┘
       │ 1:N
       ▼
  ┌──────────────┐
  │ order_items  │
  ├──────────────┤
  │order_item_id │
  │ order_id     │
  │ p_id         │
  │ price        │
  │ qty          │
  │ total        │
  └──────────────┘
       │
       └────────────────┐
                        │
                        ▼
                   ┌──────────────┐      ┌─────────────┐
                   │  products    │◄─────┤ categories  │
                   ├──────────────┤      ├─────────────┤
                   │ p_id (PK)    │      │ id (PK)     │
                   │ v_id (FK)    │      │ c_name      │
                   │ p_name       │      │ c_commision │
                   │ p_price      │      │ p_c_id      │
                   │ c_id (FK)    │      └─────────────┘
                   │ p_stock      │
                   │ p_image      │
                   └──────────────┘
                        │
                        └────────────────┐
                                         │
                                         ▼
                                   ┌──────────────┐
                                   │   venders    │
                                   ├──────────────┤
                                   │ id (PK)      │
                                   │ fullname     │
                                   │ email        │
                                   │ phone        │
                                   │ business_name│
                                   │ status       │
                                   └──────────────┘

┌──────────────┐
│   banners    │
├──────────────┤
│ b_id (PK)    │
│ b_image      │
│ b_alt        │
└──────────────┘
```

---

## Key Relationships

| From | To | Type | Foreign Key |
|------|----|----|---|
| users | orders | 1:N | user_id |
| users | billing | 1:N | user_id |
| users | carts | 1:N | user_id |
| users | sessions | 1:N | user_id |
| orders | order_items | 1:N | order_id |
| products | order_items | 1:N | p_id |
| venders | products | 1:N | v_id |
| categories | products | 1:N | c_id |
| categories | categories | 1:N | p_c_id (parent-child) |

---

## Database Statistics

- **Total Tables:** 13
- **Primary Keys:** All tables
- **Foreign Keys:** 7 relationships
- **Indexes:** Multiple on foreign keys and frequently queried columns
- **Estimated Size:** Depends on data volume
- **Charset:** utf8mb4_unicode_ci (Full Unicode support)
- **Storage Engine:** InnoDB (ACID compliance, transactions)

---

## Important Notes

1. **Naming Conventions:** Tables use mixed naming (snake_case and abbreviations like p_id, v_id, c_id)
2. **Data Types:** Some columns use VARCHAR for numeric values (p_price, p_stock) - consider using DECIMAL/INT
3. **Foreign Keys:** Not all foreign key relationships are enforced at the database level
4. **Timestamps:** All tables include created_at and updated_at for audit trails
5. **Vendor Status:** Default value is 'unverifide' (note the typo - should be 'unverified')

---

**Last Updated:** February 3, 2026
**Documentation Version:** 1.0
