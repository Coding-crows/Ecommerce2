# Razorpay Test Mode Guide

## ✅ You're Currently in TEST MODE

**Good News**: Your Razorpay is configured correctly for development! Test mode means **NO REAL MONEY** is charged during transactions.

### Current Configuration

```env
RAZORPAY_KEY_ID=rzp_test_SCNOaOXWgpq9En    ← Notice "test" in the key
RAZORPAY_KEY_SECRET=Qkj0yw49G1HJMltDB6Iqom6b
RAZORPAY_CURRENCY=INR
```

The `rzp_test_` prefix indicates you're in **TEST MODE**.

---

## 🧪 How to Test Payments (FREE)

### Test Credit/Debit Cards

#### ✅ Successful Payment
```
Card Number: 4111 1111 1111 1111
CVV: 123 (or any 3 digits)
Expiry: 12/28 (or any future date)
Name: Any Name
```

#### ❌ Failed Payment (To test error handling)
```
Card Number: 4000 0000 0000 0002
CVV: 123
Expiry: 12/28
Name: Any Name
```

#### Other Test Cards
- **Authorization Failed**: `4000 0025 0000 3155`
- **Insufficient Funds**: `4000 0000 0000 9995`
- **Card Expired**: `4000 0000 0000 0069`

### Test UPI IDs

- **Successful Payment**: `success@razorpay`
- **Failed Payment**: `failure@razorpay`

### Test Net Banking

When you select Net Banking in Razorpay popup:
- Select any bank
- It will show a test payment page
- Click "Success" or "Failure" to test different scenarios

---

## 🎯 Testing Checklist

Use these test scenarios to ensure everything works:

- [ ] **Place order with UPI** - Use `success@razorpay`
- [ ] **Place order with Card** - Use `4111 1111 1111 1111`
- [ ] **Test failed payment** - Use `failure@razorpay` or `4000 0000 0000 0002`
- [ ] **Cancel payment** - Close Razorpay popup during payment
- [ ] **Place COD order** - Should work without Razorpay popup
- [ ] **Check order in database** - Verify payment details are saved
- [ ] **Test on mobile device** - Ensure responsive design works

---

## 🚀 Going LIVE (Using Real Money)

When you're ready to accept real payments, follow these steps:

### Step 1: Complete KYC in Razorpay

1. Log in to [Razorpay Dashboard](https://dashboard.razorpay.com)
2. Go to **Settings** → **Business Settings**
3. Complete KYC verification (requires business documents)
4. Wait for approval (usually 24-48 hours)

### Step 2: Activate Live Mode

1. In Razorpay Dashboard, toggle to **LIVE Mode** (top-right corner)
2. Go to **Settings** → **API Keys**
3. Click **Generate Live Keys**
4. Copy your **Live Key ID** and **Live Key Secret**

### Step 3: Update .env File

Replace test credentials with live credentials:

```env
# BEFORE (Test Mode)
RAZORPAY_KEY_ID=rzp_test_SCNOaOXWgpq9En

# AFTER (Live Mode)
RAZORPAY_KEY_ID=rzp_live_YourLiveKeyHere
RAZORPAY_KEY_SECRET=YourLiveSecretHere
RAZORPAY_CURRENCY=INR
```

### Step 4: Clear Config Cache

```bash
php artisan config:clear
php artisan config:cache
```

### Step 5: Test with Small Real Payment

Before going fully live:
- Make a small test purchase (₹10-20)
- Verify payment reaches your bank account
- Check order details are saved correctly

---

## 🔐 Security Best Practices

### For Live Mode

1. **Never commit .env to version control**
   ```bash
   # Make sure .gitignore includes:
   .env
   .env.backup
   ```

2. **Secure your API Keys**
   - Never share your secret key
   - Rotate keys if compromised
   - Use environment variables only

3. **Enable Webhook Signature Verification**
   - Set up webhooks in Razorpay Dashboard
   - Verify webhook signatures in your code

4. **Use HTTPS Only**
   - Ensure your site uses SSL certificate
   - Razorpay requires HTTPS for live mode

5. **Monitor Transactions**
   - Check Razorpay Dashboard regularly
   - Enable email alerts for payments
   - Set up fraud detection rules

---

## 📊 Monitoring & Logs

### Check Payment Logs

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Check recent errors
php artisan log:recent
```

### Razorpay Dashboard

Monitor your payments at:
- **Test Mode**: https://dashboard.razorpay.com/app/test/payments
- **Live Mode**: https://dashboard.razorpay.com/app/payments

---

## ❓ Troubleshooting

### Issue: "Razorpay credentials not configured"

**Solution**: Run `php artisan config:clear`

### Issue: Payment successful but order not created

**Solution**: 
- Check `storage/logs/laravel.log`
- Verify payment signature verification
- Ensure database connection is working

### Issue: Razorpay popup doesn't open

**Solution**:
- Clear browser cache
- Check browser console for JavaScript errors
- Ensure Razorpay script is loaded: `https://checkout.razorpay.com/v1/checkout.js`

### Issue: "Payment failed" even with test card

**Solution**:
- Ensure you're using correct test card: `4111 1111 1111 1111`
- Check if test mode is enabled in Razorpay Dashboard
- Verify API keys are correct in `.env`

---

## 📞 Support

- **Razorpay Docs**: https://razorpay.com/docs/
- **Test Cards**: https://razorpay.com/docs/payments/payments/test-card-details/
- **Razorpay Support**: https://razorpay.com/support/

---

## 🎓 Summary

**Current Status**: ✅ Test Mode Active (Safe for Development)

- ✅ No real money charged
- ✅ Unlimited free testing
- ✅ All payment methods available
- ✅ Safe to experiment

**Next Steps**:
1. Test thoroughly with test cards
2. Fix any issues found
3. Complete KYC when ready
4. Switch to live credentials
5. Start accepting real payments! 🚀
