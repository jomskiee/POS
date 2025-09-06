-- SQL script to manually update the database if needed
-- This script updates existing 'employee' roles to 'broker' and modifies the enum constraint

-- Step 1: Update all existing 'employee' roles to 'broker'
UPDATE users SET role = 'broker' WHERE role = 'employee';

-- Step 2: Modify the enum constraint to replace 'employee' with 'broker'
-- Note: This syntax is for MySQL. Adjust for other database systems as needed.
ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'broker') DEFAULT 'broker';

-- Step 3: Verify the changes
SELECT role, COUNT(*) as count FROM users GROUP BY role;