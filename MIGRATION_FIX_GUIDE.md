# Migration Fix Guide: Role Column Error

## The Error
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'role' in 'where clause'
```

This error occurs because the migration is trying to update the `role` column before it exists in the database.

## Root Cause
The original migration `2025_08_13_061804_add_role_to_users_table.php` creates the role column with `['admin', 'employee']` values, but our update migration tries to modify this before the column exists.

## Solution Applied
I've updated the original migration to create the role column with the correct values from the start:

**File**: `database/migrations/2025_08_13_061804_add_role_to_users_table.php`
- Changed from: `['admin', 'employee']` with default `'employee'`
- Changed to: `['admin', 'broker']` with default `'broker'`

## How to Fix Your Database

### Option 1: Fresh Migration (Recommended for Development)
```bash
# Drop all tables and re-run migrations with seeders
php artisan migrate:fresh --seed
```

### Option 2: Manual Database Fix (If you have existing data)
```sql
-- If the role column already exists with 'employee' values
UPDATE users SET role = 'broker' WHERE role = 'employee';
ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'broker') DEFAULT 'broker';
```

### Option 3: Reset and Re-run Specific Migration
```bash
# Rollback the role migration
php artisan migrate:rollback --step=1

# Re-run the migration (now with correct broker values)
php artisan migrate

# Run the seeder
php artisan db:seed --class=UserSeeder
```

## Verification
After applying the fix, verify it worked:

```sql
-- Check the role column structure
DESCRIBE users;

-- Check role distribution
SELECT role, COUNT(*) as count FROM users GROUP BY role;

-- Verify no employee roles exist
SELECT * FROM users WHERE role = 'employee';
```

## Expected Results
- Role column should have ENUM('admin', 'broker')
- Default value should be 'broker'
- No 'employee' roles should exist
- All users should have either 'admin' or 'broker' roles

## Prevention
To avoid this issue in the future:
1. Always check if columns exist before trying to update them
2. Use `Schema::hasColumn()` in migrations when modifying existing columns
3. Consider the order of migrations when creating dependent changes
4. Test migrations on a copy of production data before deploying

## Files Modified
1. `database/migrations/2025_08_13_061804_add_role_to_users_table.php` - Updated to use 'broker' instead of 'employee'
2. `database/seeders/UserSeeder.php` - Already updated to create broker users
3. `database/factories/UserFactory.php` - Already updated to use broker role