# Database Backups

## Demo Data Backup

**File**: `demo_data.sql`  
**Created**: October 24, 2025 at 20:34:17  
**Size**: 76 KB

### What's Included:

| Data Type | Count | Details |
|-----------|-------|---------|
| **Customers** | 18 | 10 demo customers + 8 existing |
| **Suppliers** | 3 | Tech Distributors, Office Wholesale, Accessories Plus |
| **Items** | 15 | Various electronics, furniture, stationery, accessories |
| **Stock Quantity** | 1,031 | Total inventory units |
| **Sales** | 5 | Sales transactions from last 5 days |
| **Total Revenue** | $7,579.88 | All sales revenue |
| **Expenses** | 4 | Rent, utilities, marketing, salaries |
| **Total Expenses** | $7,435.00 | All business expenses |

### Restore Instructions:

To restore this backup:

```bash
mysql -u shopsuite -p'shopsuite@2024' shopsuite < database/backups/demo_data.sql
```

Or from outside the project:

```bash
cd /home/erp/ShopSuite_0d57471
mysql -u shopsuite -p'shopsuite@2024' shopsuite < database/backups/demo_data.sql
```

### Features Demonstrated:

- ✅ Customer management with various account types
- ✅ Supplier management with company details
- ✅ Inventory tracking with stock quantities
- ✅ Sales transactions with multiple payment methods
- ✅ Expense tracking with categories
- ✅ Dashboard statistics with real data

---

**Note**: This backup contains comprehensive sample data for testing all application features.
