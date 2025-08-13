# 🛒 Laravel 8 POS System Setup Instructions

## 📋 Overview
A modern Point of Sale system built with Laravel 8 and Tailwind CSS, featuring role-based authentication and responsive design.

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL (or SQLite)

### Installation Steps

1. **Clone and Navigate**
```bash
git clone https://github.com/jomskiee/POS.git
cd POS/pos-system
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**

For **MySQL** (recommended):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pos_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

For **SQLite** (development):
```env
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite
```

5. **Run Migrations & Seeders**
```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

6. **Compile Assets**
```bash
npm run dev
# or for production
npm run production
```

7. **Start Development Server**
```bash
php artisan serve
```

## 🔐 Demo Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@mail.com | 12345678 |
| Employee | employee@mail.com | 12345678 |

## 🎯 Features

### Admin Dashboard
- **User Management**: Create, edit, view, delete users
- **Product Management**: Complete product catalog
- **Reports**: Transactions, expenses, collections
- **Inventory Management**: Stock tracking
- **POS Terminal**: Full point-of-sale interface
- **Responsive Design**: Mobile-first approach

### Employee Dashboard
- **POS Terminal**: Access to point-of-sale
- **Personal Transactions**: View own sales
- **Personal Collections**: Track own collections
- **Limited Access**: Restricted permissions

## 🛠️ Tech Stack

- **Backend**: Laravel 8
- **Frontend**: Tailwind CSS, Vue.js
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Auth with role-based access
- **Build Tools**: Laravel Mix, Webpack

## 📱 Responsive Design

The system is fully responsive and optimized for:
- Desktop computers
- Tablets
- Mobile phones
- Touch interfaces

## 🎨 UI/UX Features

- Modern, clean interface
- Intuitive navigation
- Beautiful dashboards
- Interactive components
- Professional color scheme
- Smooth animations

## 🔧 Development

### File Structure
```
pos-system/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminDashboardController.php
│   │   ├── EmployeeDashboardController.php
│   │   └── Auth/LoginController.php
│   ├── Http/Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── EmployeeMiddleware.php
│   └── Models/User.php
├── database/
│   ├── migrations/
│   └── seeders/AdminUserSeeder.php
├── resources/
│   ├── views/
│   │   ├── admin/dashboard.blade.php
│   │   ├── employee/dashboard.blade.php
│   │   └── auth/login.blade.php
│   └── css/app.css
└── routes/web.php
```

### Key Components

1. **Authentication System**
   - Role-based login redirects
   - Admin and Employee middlewares
   - Secure route protection

2. **Dashboard Layouts**
   - Collapsible sidebar navigation
   - Breadcrumb navigation
   - User profile dropdown
   - Notification system

3. **Responsive Components**
   - Mobile-optimized navigation
   - Touch-friendly interfaces
   - Adaptive layouts

## 🚧 Future Enhancements

The following features are planned for future releases:

- [ ] Complete User Management CRUD
- [ ] Product Management System
- [ ] POS Terminal Interface
- [ ] Reports & Analytics
- [ ] Inventory Tracking
- [ ] Real-time Updates
- [ ] Print Receipts
- [ ] Barcode Scanning

## 📞 Support

For questions or issues, please open an issue in the GitHub repository.

## 📄 License

This project is open-source and available under the MIT License.