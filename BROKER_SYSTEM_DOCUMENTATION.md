# Broker Management System Documentation

## Overview
This documentation covers the implementation of the Broker Management System that has been added to the user management branch. The system includes a comprehensive broker list with user relationships, account balances based on sales, validation rules, and database seeding.

## System Components

### 1. Models

#### Broker Model (`app/Models/Broker.php`)
- **Relationships**: BelongsTo User
- **Fillable Fields**: `user_id`, `name`, `account_balance`
- **Casts**: `account_balance` as decimal with 2 decimal places
- **Scopes**:
  - `withPositiveBalance()`: Filters brokers with positive balances
  - `byUser($userId)`: Filters brokers by specific user
- **Methods**:
  - `addToBalance($amount)`: Adds amount to account balance
  - `getFormattedBalanceAttribute()`: Returns formatted balance with currency

#### User Model Updates (`app/Models/User.php`)
- **New Relationships**: HasMany Brokers
- **New Methods**:
  - `isBroker()`: Checks if user role is broker
  - `isAdmin()`: Checks if user role is admin
  - `getTotalBrokerBalance()`: Calculates total balance across all user's brokers
- **New Scopes**:
  - `brokers()`: Filters users with broker role
  - `admins()`: Filters users with admin role

### 2. Database

#### Migration (`database/migrations/2025_01_27_000000_create_brokers_table.php`)
- **Table**: `brokers`
- **Fields**:
  - `id`: Primary key
  - `user_id`: Foreign key to users table (with cascade delete)
  - `name`: Broker name
  - `account_balance`: Decimal field for balance (10,2) with default 0.00
  - `timestamps`: Created and updated timestamps
- **Indexes**: Added on `user_id` and `account_balance` for performance

#### Seeder (`database/seeders/BrokerSeeder.php`)
- Creates 10 broker users with associated broker records
- Generates random account balances
- Includes both individual brokers and company brokers
- Updates DatabaseSeeder to include BrokerSeeder

#### Factory (`database/factories/BrokerFactory.php`)
- Provides factory methods for testing
- Includes states for different balance levels (high, low, zero)

### 3. Validation

#### UserRequest (`app/Http/Requests/UserRequest.php`)
- **Validation Rules**:
  - `name`: Required, string, 2-255 characters
  - `email`: Required, valid email, unique (ignores current user on update)
  - `password`: Required on creation, min 8 characters, confirmed
  - `address`: Optional, max 500 characters
  - `role`: Required, must be 'admin', 'broker', or 'user'
- **Custom Messages**: User-friendly validation messages
- **Custom Attributes**: Readable field names for error messages

### 4. Controller

#### BrokerController (`app/Http/Controllers/BrokerController.php`)
- **CRUD Operations**: Full resource controller
- **Additional Features**:
  - Filtering by balance range
  - Search by name or user details
  - Sorting options
  - Pagination
  - Statistics endpoint
  - Sales addition functionality
- **Database Transactions**: Used for data integrity
- **Error Handling**: Comprehensive error responses

### 5. API Routes

#### Available Endpoints (`routes/api.php`)
```
GET    /api/brokers                     # List all brokers with filtering/search
POST   /api/brokers                     # Create new broker
GET    /api/brokers/{broker}            # Show specific broker
PUT    /api/brokers/{broker}            # Update broker
DELETE /api/brokers/{broker}            # Delete broker
POST   /api/brokers/{broker}/add-sales  # Add sales to broker balance
GET    /api/users/{user}/brokers        # Get brokers for specific user
GET    /api/brokers-statistics          # Get broker statistics
```

## Usage Examples

### 1. Creating a Broker
```php
// Via API
POST /api/brokers
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "address": "123 Main St",
    "account_balance": 1000.00
}
```

### 2. Adding Sales to Broker
```php
// Via API
POST /api/brokers/1/add-sales
{
    "amount": 500.00,
    "description": "Monthly sales commission"
}
```

### 3. Getting Broker Statistics
```php
// Via API
GET /api/brokers-statistics

// Response includes:
// - Total brokers count
// - Total balance across all brokers
// - Average balance
// - Median balance
// - Top 5 brokers by balance
// - Recent 5 brokers
```

### 4. Filtering Brokers
```php
// Via API
GET /api/brokers?min_balance=1000&max_balance=5000&search=John&sort_by=account_balance&sort_order=desc
```

## Database Seeding

To seed the database with sample brokers:

```bash
php artisan db:seed --class=BrokerSeeder
```

Or run all seeders:
```bash
php artisan db:seed
```

## Testing

The system includes a factory for creating test brokers:

```php
// Create a broker with high balance
$broker = Broker::factory()->highBalance()->create();

// Create a broker with zero balance
$broker = Broker::factory()->zeroBalance()->create();

// Create multiple brokers
$brokers = Broker::factory()->count(10)->create();
```

## Key Features

1. **User-Broker Relationship**: Each broker is linked to a user account
2. **Account Balance Management**: Track and update broker balances based on sales
3. **Comprehensive Validation**: Robust validation rules with custom messages
4. **Advanced Querying**: Scopes and methods for complex database queries
5. **API-First Design**: RESTful API endpoints with filtering and pagination
6. **Database Integrity**: Foreign key constraints and transaction handling
7. **Performance Optimization**: Database indexes on frequently queried fields
8. **Flexible Seeding**: Comprehensive seeder with realistic test data

## Security Considerations

1. **Authentication**: All API routes protected with Sanctum middleware
2. **Validation**: All inputs validated through FormRequest classes
3. **Database Transactions**: Ensure data consistency during multi-step operations
4. **Soft Constraints**: Foreign key relationships with cascade delete protection

## Future Enhancements

1. **Sales Tracking**: Detailed sales history and commission calculations
2. **Performance Metrics**: Advanced analytics and reporting
3. **Role-Based Permissions**: Fine-grained access control
4. **Audit Logging**: Track changes to broker accounts and balances
5. **Notification System**: Alerts for balance thresholds and important events