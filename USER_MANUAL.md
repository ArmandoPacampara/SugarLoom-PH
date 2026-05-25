# SugarLoom PH User Manual

Version: 1.0  
Developer: SugarLoom PH Development Team  
Date Published: May 24, 2026

## Table of Contents
1. [Introduction](#1-introduction)
2. [System Requirements](#2-system-requirements)
3. [Website Overview](#3-website-overview)
4. [User Account Guide](#4-user-account-guide)
5. [Product Browsing and Search](#5-product-browsing-and-search)
6. [Shopping Cart Function](#6-shopping-cart-function)
7. [Checkout Process](#7-checkout-process)
8. [Payment Guide](#8-payment-guide)
9. [Order Management](#9-order-management)
10. [Admin Module](#10-admin-module)
11. [Security and Privacy](#11-security-and-privacy)
12. [Troubleshooting](#12-troubleshooting)
13. [FAQs](#13-faqs)
14. [Contact and Support Information](#14-contact-and-support-information)
15. [Appendices](#15-appendices)

## 1. Introduction
SugarLoom PH is an e-commerce website where customers can browse products, add items to cart, place orders, pay online, and track delivery progress.

### Purpose
Provide a convenient online ordering platform for SugarLoom products.

### Scope
The system covers:
- Customer account registration and login
- Product browsing and ordering
- Promo code and reward point redemption
- Online payment and order tracking
- Admin inventory and order management

### Intended Users
- Customers: place and track orders
- Admin: manage products, inventory, and order statuses
- Staff/Sellers: not configured as separate roles in this version; admin performs operational tasks

## 2. System Requirements
- Supported browsers: latest Chrome, Edge, Firefox, or Safari
- Internet: stable broadband/mobile data connection
- Device compatibility: desktop and mobile browsers
- Required software: none (web-based system)

## 3. Website Overview
Main pages/modules:
- Homepage (`/`): main landing page and highlights
- Catalog (`/catalog`): available products
- Cart and Checkout (`/cart`): cart summary, shipping details, payment method
- Rewards (`/cart/rewards`): rewards overview and redemption context
- Track Order (`/track-order`): order status timeline via order number
- User Profile (`/profile`): update account and password
- Admin Dashboard (`/admin`): sales/operations overview
- Admin Inventory (`/admin/inventory`): product CRUD and stock control
- Admin Orders (`/admin/orders`): order list and status updates
- Admin Users (`/admin/users`): list of registered accounts and roles

## 4. User Account Guide
### Create an Account
1. Open the registration page.
2. Enter required details (name, email, password, and profile fields).
3. Submit registration and verify email if prompted.

### Log In / Log Out
- Log in using registered email and password.
- Log out from the account menu/navigation area.

### Reset Password
1. Open `Forgot Password`.
2. Enter account email.
3. Use reset link/code sent to email.
4. Set a new password.

### Update Profile
From `Profile`:
- Update name, phone, shipping address, city, and postal code
- Change password
- Delete account (optional)

## 5. Product Browsing and Search
- Browse products from `Catalog`.
- View product details such as name, price, description, image, and availability.
- Only active products are displayed for purchase.
- Product review/rating is available after successful delivery of an order.

## 6. Shopping Cart Function
### Add to Cart
- Click add-to-cart on a product.
- Stock validation prevents adding out-of-stock or over-quantity items.

### Update Quantity
- Increase/decrease quantity from cart.
- Quantity limits and stock checks are applied.

### Remove Items
- Remove individual items from cart.
- Clear cart to remove all items and promo code.

### Totals
Cart displays:
- Subtotal
- Promo discount (if valid code is applied)
- Estimated delivery fee
- Grand total

## 7. Checkout Process
1. Open cart/checkout page.
2. Fill shipping information:
- Full name
- Email
- Phone
- Shipping address
- Metro Manila city
- Postal code
3. Select payment method (`Card` or `GCash`).
4. Optionally apply:
- Promo code (example: `SWEET10`)
- Reward points (logged-in users)
5. Review order summary and total.
6. Click `Confirm Order`.
7. Complete payment on the secure payment page.
8. After success, you are redirected to order tracking.

## 8. Payment Guide
### Supported Payment Methods
- Card
- GCash

### How Payment Works
- The system creates a secure checkout session via PayMongo.
- You are redirected to the payment gateway.
- On successful payment, order status updates to `Preparing`.
- On failed/cancelled payment, order is marked `Cancelled` and stock is restored.

### Payment Confirmation
- Customer is redirected to tracking page with a confirmation message.
- Payment status becomes `Paid` after successful flow.

### Security Reminders
- Do not share card/OTP details with anyone.
- Use trusted networks when transacting.
- Confirm you are on legitimate checkout pages before entering credentials.

## 9. Order Management
### View/Track Orders
- Use `/track-order` and enter the order number (example format: `SL-YYYYMMDD-HHMMSS-###`).

### Order Statuses
- Pending
- Preparing
- Out for Delivery
- Delivered
- Cancelled

### Courier Tracking
- If available, Lalamove tracking number is shown on track-order page.

### Cancel / Return / Refund
- Customer self-cancel and return/refund workflows are not exposed in this version.
- Contact support/admin for assistance on cancellations and refund concerns.

### Ratings and Reviews
- Logged-in customers can rate delivered orders (1 to 5 stars) and leave a comment.
- Review rewards currently grant points (default: 25 points).

## 10. Admin Module
Admin-only routes require authenticated `admin` role.

### Admin Capabilities
- Dashboard analytics:
- Total sales
- Active orders
- Low-stock items
- Revenue and product trends
- Product management:
- Add product
- Edit product details/category/image
- Activate/hide products
- Delete product
- Inventory monitoring:
- Search and filter by category/status
- Track low and out-of-stock items
- Order management:
- View paginated orders
- Create walk-in orders
- Update order status (`Pending`, `Preparing`, `Out for Delivery`, `Delivered`, `Cancelled`)
- Add Lalamove tracking number when order is out for delivery
- User management:
- View all registered users
- See role, contact details, reward points, and account creation date

## 11. Security and Privacy
- Account passwords are securely stored (hashed).
- Authenticated routes protect profile and admin functions.
- Role-based middleware restricts admin pages.
- Checkout uses secure payment gateway integration.
- Collect only required customer details for fulfillment and support.

## 12. Troubleshooting
### Cannot Log In
- Verify email/password.
- Use Forgot Password flow.
- Check if caps lock is on.

### Payment Failed
- Retry payment from checkout.
- Confirm account balance/card limits.
- Ensure stable connection.

### Order Not Found in Tracking
- Recheck order number format.
- Confirm payment completed successfully.
- Wait briefly and refresh if order was just placed.

### Item Cannot Be Added to Cart
- Product may be out of stock.
- Requested quantity may exceed available stock.

### Website Loading Issues
- Refresh browser and clear cache.
- Try another browser/device.
- Check internet stability.

## 13. FAQs
Q: Do I need an account to place an order?  
A: You can place an order as guest, but login is required to redeem points and submit order ratings.

Q: What cities are supported for delivery fee estimation?  
A: Metro Manila cities configured in the system (for example, Pasig, Manila, Makati, Taguig, and others).

Q: Can I use promo code and reward points together?  
A: Yes, subject to eligibility and max redeemable point limits.

Q: How do I earn reward points?  
A: By submitting a review on delivered orders (default points configured by admin/system).

Q: Can I track my order without logging in?  
A: Yes, as long as you have the correct order number.

## 14. Contact and Support Information
Update this section with your official channels before publishing:
- Email: `support@sugarloom.ph`
- Phone: `+63 XXX XXX XXXX`
- Social Media: `@sugarloomph`
- Support Hours: `Mon-Sat, 9:00 AM - 6:00 PM (PHT)`

## 15. Appendices
### Glossary
- Promo Code: discount code applied at checkout
- Reward Points: points earned/redeemed by eligible users
- Order Number: unique tracking code per order
- Out for Delivery: order has been dispatched to courier

### Sample Order Timeline
1. Pending: Order received
2. Preparing: Product preparation in progress
3. Out for Delivery: Courier has the package
4. Delivered: Order completed

### Recommended Future Additions
- Annotated screenshots per page
- Customer cancellation workflow
- Formal returns/refunds SOP
- Data privacy policy summary page
