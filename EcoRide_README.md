
# 🚗 EcoRide

## 📌 Project Overview
EcoRide is a web-based platform for managing eco-friendly ride-sharing and logistics. Built with **Laravel**, **PHP**, **MySQL**, **Node.js**, and **npm**, it aims to offer users and drivers a seamless ride-sharing experience with secure authentication and efficient ride management.

---

## ⚙️ Installation & Setup Guide

### 1️⃣ Prerequisites

Before running this project, ensure you have the following installed:

- PHP (>= 8.2)
- Composer
- MySQL or MariaDB
- Node.js (>= 16) & npm
- Git
- Laravel 11

### 2️⃣ Clone the Repository

```bash
git clone https://github.com/your-repo/ecoride.git
cd ecoride
```

### 3️⃣ Install PHP Dependencies

```bash
composer install
```

### 4️⃣ Set Up Environment Variables

```bash
cp .env.example .env
```

Update `.env` with your database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecoride
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### 5️⃣ Generate Application Key

```bash
php artisan key:generate
```

### 6️⃣ Run Database Migrations & Seeders

```bash
php artisan migrate --seed
```

This creates the necessary tables and default users.

### 7️⃣ Install JavaScript & CSS Dependencies

```bash
npm install && npm run build
```

### 8️⃣ Start the Development Server

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## 👤 Example Test Accounts

These accounts are pre-seeded for examiners to test the application:

**Admin Account**  
- Email: admin@ecoride.com  
- Password: Admin1234

**Driver Account**  
- Email: driver@ecoride.com  
- Password: Driver1234

**User Account**  
- Email: user@ecoride.com  
- Password: User1234

---

## 🛠️ Troubleshooting & Common Issues

- **If .env changes are not applied**, run:
  ```bash
  php artisan config:clear
  ```

- **If database migrations fail**, check your MySQL credentials in `.env`.

- **If assets don’t load correctly**, re-run:
  ```bash
  npm run build
  ```

---

## 📌 Features

### ✅ Authentication & Role-Based Access
- User roles: Admin, Driver, Passenger
- Secure authentication with Laravel
- Session management & middleware-based access

### 🚗 Ride Management
- Request, accept, and track rides
- Admin ride monitoring dashboard

---

## 🔍 Next Steps

- Final retesting & debugging
- Review account suspension implementation
- UI enhancements

This document will be updated as the project evolves. Let me know if you need additional installation steps or refinements!
