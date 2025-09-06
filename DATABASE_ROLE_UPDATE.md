# Database Role Update: Employee → Broker

This document outlines the changes made to update user roles from "employee" to "broker" in the database.

## Changes Made

### 1. Migration Created
- **File**: `database/migrations/2025_01_08_120000_update_user_roles_employee_to_broker.php`
- **Purpose**: Updates existing employee roles to broker and modifies the enum constraint
- **Actions**:
  - Updates all existing users with role 'employee' to 'broker'
  - Modifies the role column enum from `('admin', 'employee')` to `('admin', 'broker')`
  - Changes default role from 'employee' to 'broker'

### 2. Seeder Updated
- **File**: `database/seeders/UserSeeder.php`
- **Changes**:
  - Creates 2 admin users and 4 broker users
  - All users now have addresses
  - No more employee role references

### 3. Factory Updated
- **File**: `database/factories/UserFactory.php`
- **Changes**:
  - Added `role` and `address` fields to default definition
  - Role randomly selects between 'admin' and 'broker'
  - Added `admin()` and `broker()` state methods for specific role creation

## How to Apply Changes

### Option 1: Run Migration (Recommended)
```bash
php artisan migrate
```

### Option 2: Manual SQL Update
If you need to manually update the database, use the provided SQL script:
```bash
mysql -u your_username -p your_database < database_update_script.sql
```

### Option 3: Fresh Migration with Seeder
```bash
php artisan migrate:fresh --seed
```

## Verification

After applying changes, verify the update worked:

```sql
-- Check role distribution
SELECT role, COUNT(*) as count FROM users GROUP BY role;

-- Verify no employee roles exist
SELECT * FROM users WHERE role = 'employee';
```

## Expected Results

- **Before**: Users could have roles 'admin' or 'employee'
- **After**: Users can have roles 'admin' or 'broker'
- All existing 'employee' users are now 'broker' users
- Default role for new users is 'broker'

## Files Modified

1. `database/migrations/2025_01_08_120000_update_user_roles_employee_to_broker.php` (NEW)
2. `database/seeders/UserSeeder.php` (UPDATED)
3. `database/factories/UserFactory.php` (UPDATED)
4. `database_update_script.sql` (NEW - manual backup option)

## Test Users Created by Seeder

### Admin Users:
- admin@mail.com (Admin User)
- sarah@mail.com (Sarah Manager)

### Broker Users:
- john.broker@mail.com (John Broker)
- jane.sales@mail.com (Jane Sales)
- mike.seller@mail.com (Mike Seller)
- lisa.agent@mail.com (Lisa Agent)

**Default Password for all users**: `12345678`