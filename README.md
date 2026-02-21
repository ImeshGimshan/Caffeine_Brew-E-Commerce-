# Caffeine Brew - E-Commerce Platform

A modern, refactored PHP e-commerce platform for a coffee shop with improved architecture, security, and maintainability.

## 🎯 Project Overview

Caffeine Brew is a fully functional e-commerce website built for a coffee shop, featuring:
- User authentication and authorization
- Product catalog with categories
- Shopping cart system
- Admin panel for product management
- Reservation system
- Contact form
- Secure password handling with bcrypt

## 🏗️ Architecture

This project has been completely refactored from a flat file structure to a modern MVC-inspired architecture:

```
Caffeine_Brew-E-Commerce/
├── config/                 # Configuration files
│   ├── config.php         # Application configuration
│   └── database.php       # Database connection (Singleton pattern)
│
├── src/                   # Source code
│   ├── models/           # Data layer (Database operations)
│   │   ├── User.php
│   │   ├── Admin.php
│   │   ├── Product.php
│   │   ├── Cart.php
│   │   └── Reservation.php
│   └── helpers/          # Utility classes
│       ├── SessionHelper.php
│       └── SecurityHelper.php
│
├── includes/             # Reusable components
│   ├── header.php
│   ├── navbar.php
│   ├── footer.php
│   └── admin-navbar.php
│
├── public/              # Public-facing files
│   ├── index.php       # Main landing page
│   ├── css/           # Stylesheets
│   ├── js/            # JavaScript files
│   └── images/        # Public images
│
├── user/               # User-facing features
│   ├── auth/          # Authentication (login, register, logout)
│   ├── cart/          # Shopping cart operations
│   ├── products/      # Product browsing
│   └── pages/         # Static pages (about, contact, etc.)
│
├── admin/             # Admin panel
│   ├── auth/         # Admin authentication
│   ├── products/     # Product management (CRUD)
│   ├── reservations/ # Reservation management
│   └── contact/      # Contact message management
│
├── assets/           # Uploaded files
│   └── uploads/     # Product images
│
├── .env.example     # Environment variables template
└── README.md        # This file
```

## 🚀 Key Improvements

### Security
- ✅ **Bcrypt password hashing** (replaced MD5)
- ✅ **Prepared statements** for all database queries
- ✅ **Input sanitization** using SecurityHelper
- ✅ **XSS protection** with proper escaping
- ✅ **Session management** with SessionHelper
- ✅ **CSRF token support** (ready to implement)

### Code Organization
- ✅ **Separation of concerns** (MVC-inspired)
- ✅ **Reusable components** (header, footer, navbar)
- ✅ **DRY principle** (Don't Repeat Yourself)
- ✅ **Singleton database connection**
- ✅ **Model classes** for clean data access
- ✅ **Helper classes** for common operations

### Maintainability
- ✅ **Clear file structure**
- ✅ **Consistent naming conventions**
- ✅ **Commented code**
- ✅ **Configuration centralization**
- ✅ **Error handling**

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB 10.2 or higher
- Apache/Nginx web server
- mysqli PHP extension

## 🔧 Installation

### 1. Clone/Download the Project

```bash
git clone <repository-url>
cd Caffeine_Brew-E-Commerce-
```

### 2. Configure Database

Create a MySQL database:

```sql
CREATE DATABASE caffienebrewdb;
```

Import your existing database tables or create new ones:

```sql
-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(100),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cart table
CREATE TABLE cart (
    cid INT AUTO_INCREMENT PRIMARY KEY,
    pid INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    user_id INT DEFAULT NULL,
    FOREIGN KEY (pid) REFERENCES products(id) ON DELETE CASCADE
);

-- Reservations table
CREATE TABLE reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    guests INT NOT NULL,
    message TEXT,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact messages table
CREATE TABLE contactus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3. Configure Application

Update database credentials in `config/database.php`:

```php
private $host = 'localhost';
private $username = 'root';
private $password = '';
private $database = 'caffienebrewdb';
```

Update base URL in `config/config.php`:

```php
define('BASE_URL', 'http://localhost/Caffeine_Brew-E-Commerce-');
```

### 4. Set Permissions

Ensure the uploads directory is writable:

```bash
chmod 755 assets/uploads
```

### 5. Create Admin Account

Insert an admin user (password will be auto-updated to bcrypt on first login):

```sql
INSERT INTO admin (name, password) VALUES ('admin', 'admin123');
```

## 🎮 Usage

### User Features

1. **Browse Products**: Navigate to `/public/index.php`
2. **Register**: Create an account at `/user/auth/register.php`
3. **Login**: Login at `/user/auth/login.php`
4. **Shop**: Browse products at `/user/products/products.php`
5. **Cart**: View cart at `/user/cart/cart.php`
6. **Checkout**: Complete purchase at `/user/cart/checkout.php`

### Admin Features

1. **Admin Login**: Access admin panel at `/admin/auth/login.php`
2. **Dashboard**: View statistics at `/admin/index.php`
3. **Manage Products**: Add/Edit/Delete products at `/admin/products/manage.php`
4. **View Reservations**: Check reservations at `/admin/reservations/manage.php`
5. **Contact Messages**: View messages at `/admin/contact/manage.php`

## 🔐 Default Credentials

**Admin:**
- Username: `admin`
- Password: `admin123` (change after first login)

## 📝 Key Features

### User Side
- ✅ User registration and login
- ✅ Product browsing with categories
- ✅ Add to cart functionality
- ✅ Cart management (update quantity, remove items)
- ✅ Checkout process
- ✅ Table reservation
- ✅ Contact form

### Admin Side
- ✅ Secure admin login
- ✅ Dashboard with statistics
- ✅ Product management (CRUD operations)
- ✅ Image upload for products
- ✅ Reservation management
- ✅ Contact message viewing

## 🔒 Security Features

1. **Password Security**: All passwords are hashed using bcrypt
2. **SQL Injection Prevention**: Prepared statements used throughout
3. **XSS Protection**: All output is escaped using SecurityHelper
4. **Session Management**: Secure session handling with SessionHelper
5. **Input Validation**: All user inputs are sanitized
6. **File Upload Security**: Validated file types and unique filenames

## 🛠️ Development

### Adding New Features

**Add a new model:**
```php
// src/models/YourModel.php
class YourModel {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
}
```

**Add a new page:**
```php
<?php
require_once dirname(__DIR__) . '/config/config.php';
// Your code here
$pageTitle = 'Page Title';
include dirname(__DIR__) . '/includes/header.php';
include dirname(__DIR__) . '/includes/navbar.php';
// Page content
include dirname(__DIR__) . '/includes/footer.php';
?>
```

## 🐛 Troubleshooting

**Database Connection Error:**
- Check credentials in `config/database.php`
- Ensure MySQL service is running
- Verify database exists

**File Upload Issues:**
- Check `assets/uploads` directory exists
- Verify write permissions (755 or 777)
- Check PHP upload_max_filesize setting

**Session Issues:**
- Ensure session directory is writable
- Check PHP session configuration

**CSS/Images Not Loading:**
- Verify BASE_URL is correct in `config/config.php`
- Check file paths in browser console
- Ensure files were copied to public/css and public/images

## 📚 Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **CSS Framework**: Bootstrap 4.5.2
- **Icons**: Font Awesome 6.0
- **Architecture Pattern**: MVC-inspired

## 🔄 Migration from Old Structure

If you have the old flat-file structure:

1. Old files are preserved in the root directory
2. New architecture files are in organized folders
3. Database schema remains compatible
4. CSS/JS/Images automatically copied to new locations
5. Old MD5 passwords automatically upgraded to bcrypt on first login

## 📞 Support

For issues or questions:
- Check troubleshooting section
- Review error logs
- Ensure all requirements are met

## 📄 License

This project is provided as-is for educational and commercial purposes.

## ✨ Future Enhancements

- [ ] Order management system
- [ ] User profile management
- [ ] Email notifications
- [ ] Payment gateway integration
- [ ] Advanced search and filters
- [ ] Product reviews and ratings
- [ ] Wishlist functionality
- [ ] Invoice generation
- [ ] Analytics dashboard
- [ ] API endpoints for mobile app

---

**Refactored and Improved** - 2026
**Original Version** - 2024
