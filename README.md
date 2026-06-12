# ShopForge — Web Based Application Development

**Online E-Commerce Store with Admin Panel**

A full-stack e-commerce website built with **PHP** and **MySQL**.

## Tech Stack

| Layer      | Technology          |
|------------|---------------------|
| Backend    | PHP                 |
| Database   | MySQL               |
| Frontend   | HTML, CSS, JavaScript |
| Local host | XAMPP               |

---

## Setup Instructions (XAMPP)

### 1. Install XAMPP
Download from https://www.apachefriends.org and install.

### 2. Copy project files
Copy the `shopforge` folder into:
```
C:\xampp\htdocs\shopforge
```

### 3. Create the database
1. Open XAMPP Control Panel - Start **Apache** and **MySQL**
2. Open your browser and go to: http://localhost/phpmyadmin
3. Click **Import** - choose `shopforge/database.sql` → click **Go**

### 4. Open the site
Visit: http://localhost/shopforge/

---

## Pages

| URL | Page |
|-----|------|
| `/shopforge/` | Home= hero, featured products, categories |
| `/shopforge/products.php` | Browse= all products with search & filter |
| `/shopforge/contact.php` | Contact Us= form saved to database |
| `/shopforge/about.php` | About Us= story, values, team |
| `/shopforge/admin/login.php` | Admin Login |
| `/shopforge/admin/` | Admin Dashboard |

---

## Admin Login Credentials

| Field    | Value    |
|----------|----------|
| Username | `admin`  |
| Password | `password` |

> To change the password, generate a new hash with `password_hash('yourpassword', PASSWORD_DEFAULT)` and update the `admin_users` table in phpMyAdmin.

---

## DML Operations (Database)

| Operation | Where it happens |
|-----------|-----------------|
| **CREATE** | Admin - Add Product (`admin/add_product.php`) |
| **READ**   | Home page featured grid, Browse page, Admin overview & product list |
| **UPDATE** | Admin - Products - Edit (`admin/edit_product.php`) |
| **DELETE** | Admin - Products - Delete button (`admin/products.php`) |

Contact form submissions also **INSERT** into the `contacts` table and are viewable in Admin → Messages.

---

## File Structure

```
shopforge/
├── index.php               # Home page
├── products.php            # Browse products
├── contact.php             # Contact form
├── about.php               # About us
├── database.sql            # Run this in phpMyAdmin to set up DB
├── includes/
│   ├── db.php              # Database connection
│   ├── header.php          # Shared nav header
│   └── footer.php          # Shared footer
├── assets/
│   └── css/
│       ├── style.css       # Public site styles
│       └── admin.css       # Admin panel styles
└── admin/
    ├── auth.php            # Session login check
    ├── login.php           # Admin login page
    ├── logout.php          # Destroys session
    ├── index.php           # Dashboard overview
    ├── products.php        # Product list + delete
    ├── add_product.php     # Add new product (CREATE)
    ├── edit_product.php    # Edit product (UPDATE)
    └── contacts.php        # View messages (READ)
```

---

## GitHub

Push this folder to GitHub. The `database.sql` file is included so your lecturer can set it up.
There is no `node_modules` or any build step — just PHP files.
