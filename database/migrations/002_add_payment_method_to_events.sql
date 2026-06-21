-- Add payment_method and payment_status columns to events table
ALTER TABLE events ADD COLUMN payment_method VARCHAR(50) DEFAULT NULL AFTER coordinator_status;
ALTER TABLE events ADD COLUMN payment_status VARCHAR(50) DEFAULT 'pending' AFTER payment_method;

-- Existing events default to 'cash' if null
UPDATE events SET payment_method = 'cash' WHERE payment_method IS NULL;
