# Caffeine Brew - Setup Guide

## Quick Start

Follow these steps to get your refactored Caffeine Brew e-commerce site running:

### Step 1: Database Setup

1. Open phpMyAdmin or MySQL command line
2. Create a new database:
   ```sql
   CREATE DATABASE caffienebrewdb;
   ```

3. If you already have an existing database with data, you're good to go!

4. If starting fresh, run the SQL found in `database-schema.sql` (create this file with the schema from README.md)

### Step 2: Configuration

1. Open `config/database.php`
2. Update these lines if needed:
   ```php
   private $host = 'localhost';
   private $username = 'root';  // Your MySQL username
   private $password = '';       // Your MySQL password
   private $database = 'caffienebrewdb';
   ```

3. Open `config/config.php`
4. Update the BASE_URL to match your setup:
   ```php
   define('BASE_URL', 'http://localhost/Caffeine_Brew-E-Commerce-');
   ```

### Step 3: Test the Installation

1. Navigate to: `http://localhost/Caffeine_Brew-E-Commerce-/public/index.php`
2. You should see the homepage!

### Step 4: Admin Access

1. Go to: `http://localhost/Caffeine_Brew-E-Commerce-/admin/auth/login.php`
2. Login with your existing admin credentials or create one in the database

### Step 5: Start Using

**User Side:**
- Browse products: `/user/products/products.php`
- Login/Register: `/user/auth/login.php`
- Shopping cart: `/user/cart/cart.php`

**Admin Side:**
- Dashboard: `/admin/index.php`
- Manage Products: `/admin/products/manage.php`
- Add Products: `/admin/products/add.php`

## Important Notes

### Password Security
- Old MD5 passwords will automatically upgrade to bcrypt on first login
- All new passwords use bcrypt encryption
- This is a major security improvement!

### File Structure
- Your old files are still in the root (backup)
- New organized structure is in folders
- CSS moved to: `public/css/`
- Images moved to: `public/images/`
- JS moved to: `public/js/`

### Common Issues

**"Database connection failed"**
- Check your database credentials in `config/database.php`
- Make sure MySQL is running

**"Images not showing"**
- Check that images were copied to `public/images/`
- Verify BASE_URL in `config/config.php`

**"Permission denied" when uploading**
- Make sure `assets/uploads/` directory exists
- Set permissions: `chmod 755 assets/uploads`

## What's New?

✅ **Better Security** - Bcrypt passwords, prepared statements, input sanitization
✅ **Organized Structure** - MVC-inspired architecture
✅ **Reusable Code** - No more copy-paste!
✅ **Session Management** - Proper login/logout handling
✅ **Clean URLs** - Better organized routes
✅ **Admin Panel** - Centralized management interface
✅ **Error Handling** - Proper error messages

## Need Help?

Check the main README.md for detailed documentation!
