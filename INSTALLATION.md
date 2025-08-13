# 🛒 Laravel POS System - Installation Guide

## 🚀 Quick Setup

### Prerequisites
- PHP 8.1 or higher
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

6. **Create database and run migrations**
```bash
# Create database named 'pos_system' in MySQL
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
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

**Admin Account:**
- Email: `admin@mail.com`
- Password: `12345678`

**Employee Account:**
- Email: `employee@mail.com` 
- Password: `12345678`

## 🎯 Features

### Admin Dashboard
- ✅ User Management
- ✅ Product Management
- ✅ Reports System
- ✅ Inventory Management
- ✅ POS Terminal

### Employee Dashboard  
- ✅ POS Terminal
- ✅ Personal Transactions
- ✅ Personal Collections

## 🛠️ Tech Stack
- **Backend:** Laravel 8
- **Frontend:** Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Built-in Auth
- **UI Components:** Vue.js scaffolding

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

# Compile assets for development
npm run dev

# Compile assets for production
npm run prod

# Start development server
php artisan serve
```

## 📁 Project Structure
```
📁 POS/ (Laravel Root)
├── 📁 app/ (Controllers, Models, Middleware)
├── 📁 config/ (Configuration files)
├── 📁 database/ (Migrations, Seeders)
├── 📁 public/ (Web accessible files)
├── 📁 resources/ (Views, Assets, CSS)
├── 📁 routes/ (Web & API routes)
├── 📁 storage/ (Logs, Cache, Uploads)
├── 📄 composer.json (PHP dependencies)
├── 📄 package.json (NPM dependencies)
├── 📄 .env.example (Environment template)
└── 📄 artisan (Laravel CLI)
```

## 📞 Support
For any issues or questions, please contact the development team.