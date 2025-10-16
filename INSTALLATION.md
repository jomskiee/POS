# 🐟 Fish Market POS System - Installation Guide

## 🚀 Quick Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL Database

### Installation Steps

1. **Clone the repository**
```bash
git clone https://github.com/jomskiee/POS.git
cd POS
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node.js dependencies** 
```bash
npm install
```

4. **Setup environment file**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database in .env file**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pos_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Create database and run migrations with seeders**
```bash
# Create database named 'pos_system' in MySQL
php artisan migrate
php artisan db:seed --class=UserSeeder
# Or run all seeders
php artisan db:seed
```

7. **Compile assets**
```bash
npm run dev
# or for production
npm run prod
```

8. **Start the development server**
```bash
php artisan serve
```

## 🔐 Demo Accounts

**Admin Accounts:**
- Email: `admin@mail.com` | Password: `12345678`
- Email: `sarah@mail.com` | Password: `12345678`

**Broker Accounts:**
- Email: `john.broker@mail.com` | Password: `12345678`
- Email: `jane.sales@mail.com` | Password: `12345678`
- Email: `mike.seller@mail.com` | Password: `12345678`
- Email: `lisa.agent@mail.com` | Password: `12345678`

## 🎯 Features

### Admin Dashboard
- ✅ **User Management** - Manage brokers and admin accounts
- ✅ **Fish Types Management** - Add, edit, and manage fish types
- ✅ **Inventory Management** - Track fish boxes and inventory
- ✅ **Sales Analytics** - Comprehensive sales reports and analytics
- ✅ **Transaction Management** - View and manage all transactions
- ✅ **Movement Tracking** - Track fish box movements and status
- ✅ **Profile Management** - Update admin profile information

### Broker Dashboard  
- ✅ **Sales Management** - Create and manage sales transactions
- ✅ **Analytics Dashboard** - Personal sales analytics and reports
- ✅ **Inventory View** - View available fish boxes
- ✅ **Payment Tracking** - Track payments and balances
- ✅ **Profile Management** - Update broker profile and stall information
- ✅ **Receipt Printing** - Print sales receipts

### System Features
- ✅ **Role-based Access Control** - Admin and Broker roles
- ✅ **QR Code Integration** - QR code scanning for fish boxes
- ✅ **Real-time Analytics** - Live sales and inventory data
- ✅ **Responsive Design** - Mobile-first responsive interface

## 🛠️ Tech Stack
- **Backend:** Laravel 10
- **Frontend:** Tailwind CSS, Blade Templates, Alpine.js
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **HTTP Client:** Axios (AJAX requests)
- **UI Components:** Heroicons, Custom Components
- **Notifications:** SweetAlert2, Toastr
- **QR Code:** QR Scanner, QR Code Styling

## 📱 Responsive Design
- ✅ Mobile-first design
- ✅ Tablet optimized
- ✅ Desktop ready
- ✅ Modern UI/UX

## 🔧 Development Commands

```bash
# Install dependencies
composer install && npm install

# Generate app key
php artisan key:generate

# Run migrations with seeders
php artisan migrate:fresh --seed

# Run specific seeder
php artisan db:seed --class=UserSeeder

# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Compile assets for development
npm run dev

# Compile assets for production
npm run prod

# Start development server
php artisan serve
```

## 🗄️ Database Structure

### Core Tables
- **users** - User authentication and basic info
- **admins** - Admin profile information
- **brokers** - Broker profile information (includes stall_name)
- **fish_types** - Available fish types
- **fish_boxes** - Individual fish boxes with QR codes
- **sales** - Sales transactions
- **sales_details** - Individual items in sales
- **sales_payments** - Payment records
- **inventory_logs** - Inventory movement tracking

### Key Features
- **QR Code Integration** - Each fish box has a unique QR code
- **Role-based Access** - Separate admin and broker dashboards

## 📁 Project Structure
```
📁 POS/ (Laravel Root)
├── 📁 app/
│   ├── 📁 Http/Controllers/
│   │   ├── 📁 Admin/ (Admin-specific controllers)
│   │   ├── 📁 Broker/ (Broker-specific controllers)
│   │   └── 📁 Auth/ (Authentication controllers)
│   ├── 📁 Models/ (User, Admin, Broker, Sales, FishBox, etc.)
│   ├── 📁 Repositories/ (Data access layer)
│   └── 📁 Constants/ (Status constants)
├── 📁 config/ (Configuration files)
├── 📁 database/
│   ├── 📁 migrations/ (Database schema)
│   └── 📁 seeders/ (UserSeeder, DatabaseSeeder)
├── 📁 public/ (Web accessible files)
├── 📁 resources/
│   ├── 📁 views/
│   │   ├── 📁 admin/ (Admin dashboard views)
│   │   ├── 📁 broker/ (Broker dashboard views)
│   │   └── 📁 auth/ (Authentication views)
│   ├── 📁 js/ (JavaScript files)
│   └── 📁 css/ (Stylesheets)
├── 📁 routes/ (Web & API routes)
├── 📁 storage/ (Logs, Cache, Uploads)
├── 📄 composer.json (PHP dependencies)
├── 📄 package.json (NPM dependencies)
├── 📄 .env.example (Environment template)
└── 📄 artisan (Laravel CLI)
```

## 🚀 Getting Started

1. **Login as Admin** using `admin@mail.com` / `12345678`
2. **Create Fish Types** in the Fish Types management section
3. **Add Fish Boxes** to inventory with QR codes
4. **Create Broker Accounts** in User Management
5. **Login as Broker** to start making sales
6. **View Analytics** in both admin and broker dashboards

## 📞 Support
For any issues or questions, please contact the development team.
