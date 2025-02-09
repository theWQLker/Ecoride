✅ EcoRide Project Plan (With GitHub Instructions and Updates)
Below is a structured plan for the EcoRide project, including all steps and guidelines from setup to pushing changes to GitHub. You can refer to it as a clear roadmap.

📌 Project Overview
EcoRide is a web-based platform for managing eco-friendly ride-sharing and logistics, providing users with easy access to ride booking, ride management, and administrative controls.

⚙️ Installation & Setup Guide
1️⃣ Prerequisites
Before running this project, ensure you have the following installed:

PHP (>= 8.2)
Composer
MySQL or MariaDB
Node.js (>= 16) & npm
Git
Laravel 11
2️⃣ Clone the Repository

git clone https://github.com/your-repo/ecoride.git
cd ecoride
3️⃣ Install PHP Dependencies

composer install
4️⃣ Set Up Environment Variables

cp .env.example .env
Update .env with your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecoride
DB_USERNAME=root
DB_PASSWORD=yourpassword

5️⃣ Generate Application Key
bash
Copy
Edit
php artisan key:generate
6️⃣ Run Database Migrations & Seeders

php artisan migrate --seed
This creates the necessary tables and default users.

7️⃣ Install JavaScript & CSS Dependencies

npm install && npm run build
8️⃣ Start the Development Server

php artisan serve
Open http://127.0.0.1:8000 in your browser.

👤 Example Test Accounts
These accounts are pre-seeded for examiners to test the application:

Admin Account
Email: admin@example.com
Password: password123
Driver Account
Email: driver@example.com
Password: password123
User Account
Email: user@example.com
Password: User1234
Additional Admin Test Accounts:
Email: admin@ecoride.com
Password: Admin1234
Driver Test Accounts:
Email: driver@ecoride.com
Password: password123
User Test Accounts:
Email: user@ecoride.com
Password: User1234
🛠️ Troubleshooting & Common Issues
If .env changes are not applied:
Run:


php artisan config:clear
If database migrations fail, check your MySQL credentials in .env.

If assets don’t load correctly, re-run:

npm run build

📌 Features
✅ Authentication & Role-Based Access
User roles: Admin, Driver, Passenger
Secure authentication with Laravel
Session management & middleware-based access
🚗 Ride Management
Request, accept, and track rides
Admin ride monitoring dashboard
🔍 Next Steps
Final retesting & debugging
Review account suspension implementation
UI enhancements
