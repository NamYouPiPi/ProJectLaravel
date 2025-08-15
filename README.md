### Dependencies when u clone project and need to inntall 
After you clone a Laravel project from Git, follow these steps to set it up:

Install dependencies
Run Composer to install PHP dependencies:

1 , composer install


//

Run npm to install frontend dependencies (if used):

Copy .env.example to .env
// create .env file
  cp .env.example .env

Generate application key
  php artisan key:generate


Edit .env for your database and other settings.

Run migrations
php artisan migrate
(Optional) Seed the database

Start the development server



### Router Alll in Cinema System + Innventory System

## 🏛 1. CINEMAS Routes

### Basic CRUD Operations
// GET Routes
GET /api/cinemas                    // Get all cinemas
GET /api/cinemas/:id                // Get specific cinema
GET /api/cinemas/active             // Get only active cinemas
GET /api/cinemas/search?name=value  // Search cinemas by name
GET /api/cinemas/:id/halls          // Get all halls in a cinema

// POST Routes
POST /api/cinemas                   // Create new cinema
POST /api/cinemas/bulk              // Create multiple cinemas

// PUT Routes
PUT /api/cinemas/:id                // Update entire cinema record
PUT /api/cinemas/:id/status         // Update cinema status (active/inactive)

// PATCH Routes
PATCH /api/cinemas/:id              // Partial update cinema
PATCH /api/cinemas/:id/location     // Update only location info

// DELETE Routes
DELETE /api/cinemas/:id             // Delete cinema (soft delete)
DELETE /api/cinemas/:id/force       // Permanent delete (admin only)

### Business Logic Routes
GET /api/cinemas/:id/analytics          // Cinema performance analytics
GET /api/cinemas/:id/revenue            // Revenue by date range
GET /api/cinemas/nearby?lat=x&lng=y     // Find nearby cinemas
GET /api/cinemas/:id/capacity           // Total seating capacity
POST /api/cinemas/:id/maintenance       // Schedule maintenance


## 🎭 2. HALLS Routes

### Basic CRUD Operations
// GET Routes
GET /api/halls                      // Get all halls
GET /api/halls/:id                  // Get specific hall
GET /api/halls/cinema/:cinemaId     // Get halls by cinema
GET /api/halls/:id/seats            // Get all seats in hall
GET /api/halls/:id/layout           // Get seat layout

// POST Routes
POST /api/halls                     // Create new hall
POST /api/halls/:id/seats/generate  // Auto-generate seats for hall

// PUT/PATCH Routes
PUT /api/halls/:id                  // Update hall
PATCH /api/halls/:id/capacity       // Update capacity

// DELETE Routes
DELETE /api/halls/:id               // Delete hall

### Business Logic Routes
GET /api/halls/:id/availability?date=YYYY-MM-DD    // Check hall availability
GET /api/halls/:id/showtimes                       // Get all showtimes for hall
GET /api/halls/:id/occupancy                       // Current occupancy rate
POST /api/halls/:id/block                          // Block hall for maintenance


## 💺 3. SEATS Routes

### Basic CRUD Operations
// GET Routes
GET /api/seats                      // Get all seats
GET /api/seats/:id                  // Get specific seat
GET /api/seats/hall/:hallId         // Get seats by hall
GET /api/seats/hall/:hallId/available?showtimeId=x  // Available seats for showtime

// POST Routes
POST /api/seats                     // Create new seat
POST /api/seats/bulk                // Create multiple seats

// PUT/PATCH Routes
PUT /api/seats/:id                  // Update seat
PATCH /api/seats/:id/type           // Change seat type
PATCH /api/seats/:id/status         // Update seat status

// DELETE Routes
DELETE /api/seats/:id               // Delete seat

### Business Logic Routes
POST /api/seats/:id/reserve         // Reserve seat temporarily
POST /api/seats/:id/release         // Release reserved seat
GET /api/seats/hall/:hallId/map     // Get visual seat map
POST /api/seats/hall/:hallId/optimize  // Optimize seat layout


## 🎬 4. MOVIES Routes

// GET Routes
GET /api/movies                     // Get all movies
GET /api/movies/:id                 // Get specific movie
GET /api/movies/active              // Get currently showing movies
GET /api/movies/upcoming            // Get upcoming movies
GET /api/movies/search?q=title      // Search movies

// POST Routes
POST /api/movies                    // Add new movie
POST /api/movies/:id/media          // Upload poster/trailer

// PUT/PATCH Routes
PUT /api/movies/:id                 // Update movie
PATCH /api/movies/:id/status        // Update movie status

// DELETE Routes
DELETE /api/movies/:id              // Remove movie

### Business Logic Routes

GET /api/movies/:id/showtimes           // Get all showtimes for movie
GET /api/movies/:id/analytics           // Movie performance analytics
GET /api/movies/genre/:genre            // Get movies by genre
GET /api/movies/:id/revenue             // Movie revenue data
POST /api/movies/:id/rating             // Submit movie rating
GET /api/movies/popular                 // Get popular movies

## 🏢 5. DISTRIBUTORS Routes

### Basic CRUD Operations
// GET Routes
GET /api/distributors               // Get all distributors
GET /api/distributors/:id           // Get specific distributor
GET /api/distributors/:id/movies    // Get movies from distributor

// POST Routes
POST /api/distributors              // Add new distributor
POST /api/distributors/:id/contract // Create distribution contract

// PUT/PATCH Routes
PUT /api/distributors/:id           // Update distributor
PATCH /api/distributors/:id/status  // Update distributor status

// DELETE Routes
DELETE /api/distributors/:id        // Remove distributor

### Business Logic Routes
GET /api/distributors/:id/revenue       // Revenue sharing data
GET /api/distributors/:id/performance   // Distributor performance metrics
POST /api/distributors/:id/negotiate    // Contract negotiation

---

## 💰 6. MOVIE_PURCHASES Routes

### Basic CRUD Operations
// GET Routes
GET /api/movie-purchases            // Get all movie purchases
GET /api/movie-purchases/:id        // Get specific purchase
GET /api/movie-purchases/movie/:movieId  // Purchases for specific movie

// POST Routes
POST /api/movie-purchases           // Create new movie purchase
POST /api/movie-purchases/:id/approve    // Approve purchase

// PUT/PATCH Routes
PUT /api/movie-purchases/:id        // Update purchase
PATCH /api/movie-purchases/:id/status    // Update purchase status

// DELETE Routes
DELETE /api/movie-purchases/:id     // Cancel purchase

### Business Logic Routes
GET /api/movie-purchases/:id/payments       // Get payment history
POST /api/movie-purchases/:id/payment       // Make payment
GET /api/movie-purchases/pending            // Get pending purchases
GET /api/movie-purchases/:id/contract       // Get purchase contract

---

## 💳 7. MOVIE_PURCHASE_PAYMENTS Routes

### Basic CRUD Operations
// GET Routes
GET /api/movie-purchase-payments    // Get all payments
GET /api/movie-purchase-payments/:id // Get specific payment
GET /api/movie-purchase-payments/purchase/:purchaseId // Payments for purchase

// POST Routes
POST /api/movie-purchase-payments   // Record new payment
POST /api/movie-purchase-payments/:id/verify // Verify payment

// PUT/PATCH Routes
PATCH /api/movie-purchase-payments/:id/status // Update payment status

// DELETE Routes
DELETE /api/movie-purchase-payments/:id // Reverse payment

## ⏰ 8. SHOWTIMES Routes
### Basic CRUD Operations
// GET Routes
GET /api/showtimes                  // Get all showtimes
GET /api/showtimes/:id              // Get specific showtime
GET /api/showtimes/movie/:movieId   // Showtimes for specific movie
GET /api/showtimes/hall/:hallId     // Showtimes for specific hall
GET /api/showtimes/today            // Today's showtimes

// POST Routes
POST /api/showtimes                 // Create new showtime
POST /api/showtimes/bulk            // Create multiple showtimes

// PUT/PATCH Routes
PUT /api/showtimes/:id              // Update showtime
PATCH /api/showtimes/:id/price      // Update showtime pricing

// DELETE Routes
DELETE /api/showtimes/:id           // Cancel showtime

### Business Logic Routes
GET /api/showtimes/:id/availability     // Check seat availability
GET /api/showtimes/:id/bookings         // Get all bookings for showtime
POST /api/showtimes/:id/book            // Quick booking
GET /api/showtimes/schedule?date=YYYY-MM-DD // Get schedule for date
GET /api/showtimes/:id/revenue          // Showtime revenue
POST /api/showtimes/:id/start           // Mark showtime as started

---

## 👥 9. CUSTOMERS Routes

### Basic CRUD Operations
// GET Routes
GET /api/customers                  // Get all customers (admin only)
GET /api/customers/:id              // Get specific customer
GET /api/customers/:id/profile      // Get customer profile
GET /api/customers/search?email=x   // Search customers

// POST Routes
POST /api/customers                 // Register new customer
POST /api/customers/login           // Customer login
POST /api/customers/forgot-password // Password reset

// PUT/PATCH Routes
PUT /api/customers/:id              // Update customer profile
PATCH /api/customers/:id/password   // Change password
PATCH /api/customers/:id/preferences // Update preferences

// DELETE Routes
DELETE /api/customers/:id           // Delete customer account

### Business Logic Routes
GET /api/customers/:id/bookings         // Customer booking history
GET /api/customers/:id/payments         // Customer payment history
GET /api/customers/:id/loyalty          // Loyalty points and rewards
POST /api/customers/:id/loyalty/redeem  // Redeem loyalty points
GET /api/customers/:id/recommendations  // Movie recommendations
POST /api/customers/:id/feedback        // Submit feedback
GET /api/customers/:id/analytics        // Customer behavior analytics

---

## 🎫 10. BOOKINGS Routes

### Basic CRUD Operations
// GET Routes
GET /api/bookings                   // Get all bookings (admin)
GET /api/bookings/:id               // Get specific booking
GET /api/bookings/customer/:customerId // Customer's bookings
GET /api/bookings/reference/:ref    // Get booking by reference

// POST Routes
POST /api/bookings                  // Create new booking
POST /api/bookings/:id/confirm      // Confirm booking

// PUT/PATCH Routes
PATCH /api/bookings/:id/status      // Update booking status
PATCH /api/bookings/:id/seats       // Modify seat selection

// DELETE Routes
DELETE /api/bookings/:id            // Cancel booking

### Business Logic Routes
GET /api/bookings/:id/tickets           // Generate tickets
POST /api/bookings/:id/checkin          // Check-in for showtime
GET /api/bookings/:id/receipt           // Get booking receipt
POST /api/bookings/:id/modify           // Modify booking
GET /api/bookings/showtime/:showtimeId  // Bookings for showtime
POST /api/bookings/:id/refund           // Process refund

---

## 🪑 11. BOOKING_SEATS Routes

### Basic CRUD Operations
// GET Routes
GET /api/booking-seats/booking/:bookingId // Seats for specific booking
GET /api/booking-seats/seat/:seatId       // Bookings for specific seat

// POST Routes
POST /api/booking-seats             // Add seats to booking
POST /api/booking-seats/bulk        // Add multiple seats

// DELETE Routes
DELETE /api/booking-seats/:id       // Remove seat from booking
DELETE /api/booking-seats/booking/:bookingId // Remove all seats from booking

---

## 👨‍💼 12. EMPLOYEES Routes

### Basic CRUD Operations
// GET Routes
GET /api/employees                  // Get all employees
GET /api/employees/:id              // Get specific employee
GET /api/employees/role/:role       // Get employees by role
GET /api/employees/cinema/:cinemaId // Get employees by cinema

// POST Routes
POST /api/employees                 // Add new employee
POST /api/employees/login           // Employee login

// PUT/PATCH Routes
PUT /api/employees/:id              // Update employee
PATCH /api/employees/:id/role       // Change employee role
PATCH /api/employees/:id/status     // Update employee status

// DELETE Routes
DELETE /api/employees/:id           // Remove employee

### Business Logic Routes
GET /api/employees/:id/schedule         // Employee work schedule
POST /api/employees/:id/clockin         // Clock in/out
GET /api/employees/:id/performance      // Performance metrics
GET /api/employees/:id/bookings         // Bookings processed by employee
POST /api/employees/:id/training        // Training records

---

## 🏭 13. SUPPLIERS Routes

### Basic CRUD Operations
// GET Routes
GET /api/suppliers                  // Get all suppliers
GET /api/suppliers/:id              // Get specific supplier
GET /api/suppliers/category/:cat    // Suppliers by category

// POST Routes
POST /api/suppliers                 // Add new supplier
POST /api/suppliers/:id/contact     // Add contact person

// PUT/PATCH Routes
PUT /api/suppliers/:id              // Update supplier
PATCH /api/suppliers/:id/status     // Update supplier status

// DELETE Routes
DELETE /api/suppliers/:id           // Remove supplier

### Business Logic Routes
GET /api/suppliers/:id/orders           // Orders from supplier
GET /api/suppliers/:id/performance      // Supplier performance metrics
POST /api/suppliers/:id/quote           // Request quote
GET /api/suppliers/:id/catalog          // Supplier catalog

---

## 📦 14. INVENTORY_ITEMS Routes

### Basic CRUD Operations
// GET Routes
GET /api/inventory-items            // Get all inventory items
GET /api/inventory-items/:id        // Get specific item
GET /api/inventory-items/category/:cat // Items by category
GET /api/inventory-items/low-stock  // Low stock items

// POST Routes
POST /api/inventory-items           // Add new item
POST /api/inventory-items/:id/restock // Restock item

// PUT/PATCH Routes
PUT /api/inventory-items/:id        // Update item
PATCH /api/inventory-items/:id/price // Update pricing
PATCH /api/inventory-items/:id/stock // Update stock levels

// DELETE Routes
DELETE /api/inventory-items/:id     // Remove item

### Business Logic Routes
GET /api/inventory-items/:id/sales      // Sales history for item
POST /api/inventory-items/:id/sale      // Record sale
GET /api/inventory-items/analytics      // Inventory analytics
POST /api/inventory-items/audit         // Inventory audit
GET /api/inventory-items/forecast       // Demand forecast

---

## 📋 15. PURCHASE_ORDERS Routes

### Basic CRUD Operations
// GET Routes
GET /api/purchase-orders            // Get all purchase orders
GET /api/purchase-orders/:id        // Get specific order
GET /api/purchase-orders/supplier/:supplierId // Orders by supplier
GET /api/purchase-orders/pending    // Pending orders

// POST Routes
POST /api/purchase-orders           // Create new order
POST /api/purchase-orders/:id/approve // Approve order

// PUT/PATCH Routes
PUT /api/purchase-orders/:id        // Update order
PATCH /api/purchase-orders/:id/status // Update order status

// DELETE Routes
DELETE /api/purchase-orders/:id     // Cancel order

### Business Logic Routes
POST /api/purchase-orders/:id/receive   // Mark order as received
GET /api/purchase-orders/:id/tracking   // Track order status
POST /api/purchase-orders/:id/return    // Return items
GET /api/purchase-orders/analytics      // Purchase analytics

---

## 💳 16. PAYMENTS Routes

Nam You, [8/4/2025 10:51 PM]
### Basic CRUD Operations
// GET Routes
GET /api/payments                   // Get all payments
GET /api/payments/:id               // Get specific payment
GET /api/payments/booking/:bookingId // Payments for booking
GET /api/payments/customer/:customerId // Customer payment history

// POST Routes
POST /api/payments                  // Process new payment
POST /api/payments/:id/verify       // Verify payment

// PATCH Routes
PATCH /api/payments/:id/status      // Update payment status

// DELETE Routes
DELETE /api/payments/:id/refund     // Process refund

### Business Logic Routes
POST /api/payments/gateway/webhook      // Payment gateway webhook
GET /api/payments/analytics             // Payment analytics
POST /api/payments/:id/receipt          // Generate receipt
GET /api/payments/failed                // Failed payments
POST /api/payments/:id/retry            // Retry failed payment

---

## 🎁 17. PROMOTIONS Routes

### Basic CRUD Operations
// GET Routes
GET /api/promotions                 // Get all promotions
GET /api/promotions/:id             // Get specific promotion
GET /api/promotions/active          // Get active promotions
GET /api/promotions/code/:code      // Get promotion by code

// POST Routes
POST /api/promotions                // Create new promotion
POST /api/promotions/:id/apply      // Apply promotion to booking

// PUT/PATCH Routes
PUT /api/promotions/:id             // Update promotion
PATCH /api/promotions/:id/status    // Activate/deactivate promotion

// DELETE Routes
DELETE /api/promotions/:id          // Delete promotion

### Business Logic Routes
POST /api/promotions/:id/validate       // Validate promotion code
GET /api/promotions/:id/usage           // Promotion usage statistics
GET /api/promotions/customer/:customerId // Customer eligible promotions
POST /api/promotions/bulk-create        // Create bulk promotions

---

## 📊 18. REPORTS Routes

### Dashboard Reports
GET /api/reports/dashboard              // Main dashboard data
GET /api/reports/revenue               // Revenue reports
GET /api/reports/bookings              // Booking statistics
GET /api/reports/customers             // Customer analytics
GET /api/reports/movies                // Movie performance
GET /api/reports/inventory             // Inventory reports

### Financial Reports
GET /api/reports/financial/daily       // Daily financial summary
GET /api/reports/financial/monthly     // Monthly financial report
GET /api/reports/financial/yearly      // Yearly financial report
GET /api/reports/financial/profit      // Profit & loss report
GET /api/reports/financial/tax         // Tax reports

### Operational Reports
GET /api/reports/occupancy             // Seat occupancy rates
GET /api/reports/employee-performance  // Employee performance
GET /api/reports/movie-popularity      // Movie popularity rankings
GET /api/reports/customer-satisfaction // Customer satisfaction
GET /api/reports/maintenance           // Maintenance schedules

### Custom Reports
POST /api/reports/custom               // Generate custom report
GET /api/reports/templates             // Available report templates
POST /api/reports/schedule             // Schedule automated reports
GET /api/reports/exports               // Export reports (PDF/Excel)

---

## 🔐 Authentication & Authorization Routes

### Auth Routes
POST /api/auth/login                   // User login
POST /api/auth/logout                  // User logout
POST /api/auth/refresh                 // Refresh token
POST /api/auth/forgot-password         // Password reset request
POST /api/auth/reset-password          // Reset password
POST /api/auth/verify-email            // Email verification

### Permission Routes
GET /api/auth/permissions              // Get user permissions
GET /api/auth/roles                    // Get available roles
POST /api/auth/role-assign             // Assign role to user

---

## 📱 Mobile App Specific Routes

Nam You, [8/4/2025 10:51 PM]
### Mobile Optimized
GET /api/mobile/movies/now-showing     // Mobile-optimized movie list
GET /api/mobile/cinemas/nearby         // Nearby cinemas with location
POST /api/mobile/quick-book            // Quick booking flow
GET /api/mobile/tickets/:bookingId     // Mobile ticket display

---

## 🔧 Admin Routes

### System Administration
GET /api/admin/system-health           // System health check
GET /api/admin/audit-logs              // System audit logs
POST /api/admin/backup                 // Trigger system backup
GET /api/admin/analytics               // System-wide analytics
POST /api/admin/maintenance-mode       // Enable/disable maintenance

---

## 📈 Route Usage Guidelines

### HTTP Status Codes
- 200 - Success
- 201 - Created
- 400 - Bad Request
- 401 - Unauthorized
- 403 - Forbidden
- 404 - Not Found
- 422 - Validation Error
- 500 - Server Error

### Request/Response Format
// Standard Response Format
{
"success": true,
"data": {},
"message": "Operation successful",
"pagination": {
"page": 1,
"limit": 10,
"total": 100
}
}

// Error Response Format
{
"success": false,
"error": {
"code": "VALIDATION_ERROR",
"message": "Invalid input data",
"details": []
}
}

### Query Parameters
// Pagination
?page=1&limit=10

// Filtering
?status=active&date_from=2024-01-01&date_to=2024-12-31

// Sorting
?sort_by=created_at&sort_order=desc

// Search
?search=movie_title&filter=genre:action

This comprehensive routing structure provides complete API coverage for your cinema management system with proper REST conventions and business logic integration.
