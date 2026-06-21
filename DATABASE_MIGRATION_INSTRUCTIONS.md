# Database Migration Setup

## Required SQL to Run in PHPMyAdmin

Execute the following SQL commands in your database (via PHPMyAdmin or MySQL command line):

```sql
-- Add payment_method and payment_status columns to events table
ALTER TABLE events ADD COLUMN payment_method VARCHAR(50) DEFAULT NULL AFTER coordinator_status;
ALTER TABLE events ADD COLUMN payment_status VARCHAR(50) DEFAULT 'pending' AFTER payment_method;

-- Set default payment method to 'cash' for existing events
UPDATE events SET payment_method = 'cash' WHERE payment_method IS NULL;
```

## Steps to Apply:

1. **Open PHPMyAdmin**
   - Go to: http://localhost/phpmyadmin
   - Select your database (copyeventintel or similar)

2. **Go to SQL Tab**
   - Click on "SQL" tab at the top

3. **Paste and Execute**
   - Copy the SQL commands above
   - Paste into the SQL editor
   - Click "Go" to execute

4. **Verify Changes**
   - Go to Structure tab of the `events` table
   - Should see two new columns:
     - `payment_method` (VARCHAR 50)
     - `payment_status` (VARCHAR 50)

## Verification Query

To verify the columns were created correctly, run this query:

```sql
DESCRIBE events;
```

Look for these rows in the output:
- `payment_method | varchar(50) | YES | | NULL |`
- `payment_status | varchar(50) | YES | | pending |`

That's it! The system is now ready to use.
