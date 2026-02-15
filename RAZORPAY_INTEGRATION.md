# Razorpay Payment Gateway Integration

This document explains how to set up and use Razorpay payment gateway in the E-commerce Portal.

## Features

- **Online Payments**: Accept UPI and Card payments through Razorpay
- **Cash on Delivery**: Continue supporting COD orders
- **Payment Verification**: Secure payment signature verification
- **Order Tracking**: Store payment IDs and status with orders

## Setup Instructions

### 1. Get Razorpay API Credentials

1. Sign up for a Razorpay account at [https://razorpay.com](https://razorpay.com)
2. Go to your Razorpay Dashboard
3. Navigate to **Settings** → **API Keys**
4. Generate API Keys (you'll get a Key ID and Key Secret)
5. Use **Test Mode** for development, **Live Mode** for production

### 2. Configure Environment Variables

Add the following to your `.env` file:

```env
RAZORPAY_KEY_ID=your_key_id_here
RAZORPAY_KEY_SECRET=your_key_secret_here
```

**Important**: Never commit your `.env` file to version control!

### 3. Run Database Migration

Execute the migration to add Razorpay fields to the orders table:

```bash
php artisan migrate
```

This will add the following columns to the `orders` table:
- `razorpay_payment_id` - Stores the Razorpay payment ID
- `razorpay_order_id` - Stores the Razorpay order ID
- `payment_status` - Stores payment status (Paid/Pending)

### 4. Clear Configuration Cache

After adding environment variables, clear the config cache:

```bash
php artisan config:clear
php artisan config:cache
```

## How It Works

### Payment Flow

1. **Customer selects payment method**:
   - UPI
   - Credit/Debit Card
   - Cash on Delivery (COD)

2. **For Online Payments (UPI/Card)**:
   - System creates a Razorpay order via backend
   - Razorpay payment popup opens
   - Customer completes payment
   - Payment is verified using signature
   - Order is placed with payment details

3. **For COD**:
   - Order is placed directly without payment processing

### Security

- Payment signature is verified server-side
- Razorpay credentials are stored securely in environment variables
- CSRF protection on all payment endpoints

## Testing

### Test Mode Credentials

When using Razorpay test mode, use these test card details:

**Test Card Number**: `4111 1111 1111 1111`  
**Expiry**: Any future date  
**CVV**: Any 3 digits  
**Name**: Any name

**Test UPI ID**: `success@razorpay`

### Test Scenarios

1. **Successful Payment**:
   - Use test card or UPI above
   - Complete payment flow
   - Verify order is created with payment status "Paid"

2. **Failed Payment**:
   - Use card number `4000 0000 0000 0002`
   - Payment should fail gracefully
   - Order should not be created

3. **Cancelled Payment**:
   - Close Razorpay popup without completing payment
   - User should be able to retry

## API Endpoints

### Create Razorpay Order
**POST** `/razorpay-create-order`

Request:
```json
{
  "amount": 1000,
  "cart": [...]
}
```

Response:
```json
{
  "success": true,
  "order_id": "order_xxx",
  "amount": 100000,
  "currency": "INR",
  "key_id": "rzp_test_xxx"
}
```

### Place Order
**POST** `/place-order`

Request (COD):
```json
{
  "payment_mode": "COD",
  "cart": [...]
}
```

Request (Online):
```json
{
  "payment_mode": "UPI",
  "cart": [...],
  "razorpay_payment_id": "pay_xxx",
  "razorpay_order_id": "order_xxx",
  "razorpay_signature": "signature_xxx"
}
```

Response:
```json
{
  "success": true,
  "order_id": 123
}
```

## Troubleshooting

### "Razorpay credentials not configured"
- Ensure `RAZORPAY_KEY_ID` and `RAZORPAY_KEY_SECRET` are set in `.env`
- Run `php artisan config:clear`

### "Payment verification failed"
- Check that your Key Secret is correct
- Ensure you're not mixing test/live mode credentials

### Razorpay popup doesn't open
- Check browser console for JavaScript errors
- Ensure Razorpay script is loaded: `https://checkout.razorpay.com/v1/checkout.js`
- Verify CORS settings if needed

### Order created but payment not recorded
- Check logs in `storage/logs/laravel.log`
- Verify migration was run successfully
- Check Order model fillable fields include Razorpay columns

## Going Live

Before going live:

1. Switch from Test Mode to Live Mode in Razorpay Dashboard
2. Generate new Live API credentials
3. Update `.env` with live credentials
4. Test thoroughly with real payments (small amounts)
5. Set up webhooks for payment notifications (optional)
6. Enable payment methods you want to accept
7. Configure settlement account in Razorpay

## Support

- Razorpay Documentation: [https://razorpay.com/docs](https://razorpay.com/docs)
- Razorpay Support: [https://razorpay.com/support](https://razorpay.com/support)
