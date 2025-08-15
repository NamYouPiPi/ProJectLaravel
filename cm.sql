-- Cinema System Database - Corrected Version
CREATE DATABASE IF NOT EXISTS cinema_system;
USE cinema_system;

-- Drop tables if they exist (for clean setup)
DROP TABLE IF EXISTS booking_seats;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS showtimes;
DROP TABLE IF EXISTS seats;
DROP TABLE IF EXISTS cinema_halls;
DROP TABLE IF EXISTS hall_location;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS inventory;
DROP TABLE IF EXISTS suppliers;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS user_accounts;

-- USER ACCOUNTS (Added for authentication)
CREATE TABLE user_accounts (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               username VARCHAR(50) UNIQUE NOT NULL,
                               email VARCHAR(100) UNIQUE NOT NULL,
                               password_hash VARCHAR(255) NOT NULL,
                               account_type ENUM('customer', 'employee', 'admin') NOT NULL,
                               is_active BOOLEAN DEFAULT TRUE,
                               last_login TIMESTAMP NULL,
                               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                               updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ROLES
CREATE TABLE roles (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       role_name VARCHAR(100) NOT NULL UNIQUE,
                       description TEXT,
                       permissions JSON,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- EMPLOYEES
CREATE TABLE employees (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           user_account_id INT,
                           name VARCHAR(100) NOT NULL,
                           email VARCHAR(100) UNIQUE,
                           phone VARCHAR(20),
                           gender ENUM('male', 'female', 'other'),
                           dob DATE,
                           role_id INT,
                           hire_date DATE,
                           address VARCHAR(255),
                           is_active BOOLEAN DEFAULT TRUE,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                           FOREIGN KEY (role_id) REFERENCES roles(id),
                           FOREIGN KEY (user_account_id) REFERENCES user_accounts(id)
);

-- EMPLOYEE SALARY (Separate table for security)
CREATE TABLE employee_salary (
                                 id INT AUTO_INCREMENT PRIMARY KEY,
                                 employee_id INT,
                                 salary DECIMAL(10,2) NOT NULL,
                                 effective_date DATE NOT NULL,
                                 created_by INT,
                                 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                 FOREIGN KEY (employee_id) REFERENCES employees(id),
                                 FOREIGN KEY (created_by) REFERENCES employees(id)
);

-- CUSTOMERS
CREATE TABLE customers (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           user_account_id INT,
                           name VARCHAR(100) NOT NULL,
                           email VARCHAR(100) UNIQUE,
                           phone VARCHAR(20),
                           gender ENUM('male', 'female', 'other'),
                           dob DATE,
                           address VARCHAR(255),
                           loyalty_points INT DEFAULT 0,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                           FOREIGN KEY (user_account_id) REFERENCES user_accounts(id)
);

-- SUPPLIERS
CREATE TABLE suppliers (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           name VARCHAR(100) NOT NULL,
                           contact_person VARCHAR(100),
                           phone VARCHAR(20),
                           email VARCHAR(100),
                           address VARCHAR(255),
                           product_type VARCHAR(100),
                           is_active BOOLEAN DEFAULT TRUE,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- MOVIES
CREATE TABLE movies (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(150) NOT NULL,
                        description TEXT,
                        duration_minutes INT CHECK (duration_minutes > 0),
                        genre VARCHAR(100),
                        rating VARCHAR(10),
                        language VARCHAR(50),
                        poster_url VARCHAR(255),
                        trailer_url VARCHAR(255),
                        release_date DATE,
                        is_active BOOLEAN DEFAULT TRUE,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        UNIQUE KEY unique_movie (title, release_date)
);

-- HALL LOCATION (Fixed syntax)
CREATE TABLE hall_location (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               name VARCHAR(50) NOT NULL,
                               address VARCHAR(255),
                               city VARCHAR(50),
                               state VARCHAR(50),
                               postal_code VARCHAR(20),
                               phone VARCHAR(20),
                               is_active BOOLEAN DEFAULT TRUE,
                               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                               updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- CINEMA HALLS (Fixed foreign key)
CREATE TABLE cinema_halls (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              name VARCHAR(100) NOT NULL,
                              hall_location_id INT,
                              total_seats INT CHECK (total_seats > 0),
                              hall_type VARCHAR(50) DEFAULT 'standard',
                              is_active BOOLEAN DEFAULT TRUE,
                              created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                              updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                              FOREIGN KEY (hall_location_id) REFERENCES hall_location(id),
                              UNIQUE KEY unique_hall_per_location (name, hall_location_id)
);

-- SEATS (Added unique constraint)
CREATE TABLE seats (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       hall_id INT,
                       seat_number VARCHAR(10) NOT NULL,
                       row_number VARCHAR(5) NOT NULL,
                       seat_type VARCHAR(50) DEFAULT 'regular',
                       is_active BOOLEAN DEFAULT TRUE,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                       FOREIGN KEY (hall_id) REFERENCES cinema_halls(id),
                       UNIQUE KEY unique_seat_per_hall (hall_id, seat_number)
);

-- SHOWTIMES (Added validation)
CREATE TABLE showtimes (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           movie_id INT,
                           hall_id INT,
                           start_time DATETIME NOT NULL,
                           end_time DATETIME NOT NULL,
                           base_price DECIMAL(8,2) NOT NULL CHECK (base_price > 0),
                           is_active BOOLEAN DEFAULT TRUE,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                           FOREIGN KEY (movie_id) REFERENCES movies(id),
                           FOREIGN KEY (hall_id) REFERENCES cinema_halls(id),
                           CHECK (end_time > start_time),
                           UNIQUE KEY unique_hall_time (hall_id, start_time)
);

-- BOOKINGS (Enhanced)
CREATE TABLE bookings (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          booking_reference VARCHAR(20) UNIQUE NOT NULL,
                          customer_id INT,
                          showtime_id INT,
                          employee_id INT,
                          booking_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          total_amount DECIMAL(10,2) NOT NULL CHECK (total_amount >= 0),
                          booking_fee DECIMAL(8,2) DEFAULT 0,
                          discount_amount DECIMAL(8,2) DEFAULT 0,
                          final_amount DECIMAL(10,2) NOT NULL CHECK (final_amount >= 0),
                          status ENUM('pending', 'confirmed', 'cancelled', 'expired') DEFAULT 'pending',
                          expires_at TIMESTAMP NULL,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                          FOREIGN KEY (customer_id) REFERENCES customers(id),
                          FOREIGN KEY (showtime_id) REFERENCES showtimes(id),
                          FOREIGN KEY (employee_id) REFERENCES employees(id)
);

-- BOOKING SEATS (Enhanced)
CREATE TABLE booking_seats (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               booking_id INT,
                               seat_id INT,
                               seat_price DECIMAL(8,2) NOT NULL CHECK (seat_price >= 0),
                               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                               FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
                               FOREIGN KEY (seat_id) REFERENCES seats(id),
                               UNIQUE KEY unique_booking_seat (booking_id, seat_id)
);

-- PAYMENTS (Enhanced)
CREATE TABLE payments (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          booking_id INT,
                          payment_reference VARCHAR(50) UNIQUE,
                          payment_method VARCHAR(50) NOT NULL,
                          payment_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          amount_paid DECIMAL(10,2) NOT NULL CHECK (amount_paid > 0),
                          transaction_id VARCHAR(100),
                          gateway_response TEXT,
                          status ENUM('pending', 'success', 'failed', 'refunded', 'cancelled') DEFAULT 'pending',
                          refund_amount DECIMAL(10,2) DEFAULT 0,
                          refund_reason TEXT,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                          FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

-- INVENTORY (Enhanced)
CREATE TABLE inventory (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           name VARCHAR(100) NOT NULL,
                           category VARCHAR(50),
                           supplier_id INT,
                           quantity INT DEFAULT 0 CHECK (quantity >= 0),
                           min_stock_level INT DEFAULT 0,
                           cost_price DECIMAL(8,2) CHECK (cost_price >= 0),
                           selling_price DECIMAL(8,2) CHECK (selling_price >= 0),
                           is_active BOOLEAN DEFAULT TRUE,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                           FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

-- CONCESSION SALES (New table)
CREATE TABLE concession_sales (
                                  id INT AUTO_INCREMENT PRIMARY KEY,
                                  booking_id INT,
                                  inventory_id INT,
                                  quantity INT NOT NULL CHECK (quantity > 0),
                                  unit_price DECIMAL(8,2) NOT NULL CHECK (unit_price >= 0),
                                  total_price DECIMAL(8,2) NOT NULL CHECK (total_price >= 0),
                                  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                  FOREIGN KEY (booking_id) REFERENCES bookings(id),
                                  FOREIGN KEY (inventory_id) REFERENCES inventory(id)
);

-- AUDIT LOG (New table for tracking changes)
CREATE TABLE audit_log (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           table_name VARCHAR(50) NOT NULL,
                           record_id INT NOT NULL,
                           action ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
                           old_values JSON,
                           new_values JSON,
                           user_id INT,
                           user_type ENUM('customer', 'employee', 'system') NOT NULL,
                           timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           ip_address VARCHAR(45),
                           user_agent TEXT,
                           FOREIGN KEY (user_id) REFERENCES user_accounts(id)
);

-- INDEXES for better performance
CREATE INDEX idx_user_accounts_email ON user_accounts(email);
CREATE INDEX idx_user_accounts_username ON user_accounts(username);
CREATE INDEX idx_employees_email ON employees(email);
CREATE INDEX idx_customers_email ON customers(email);
CREATE INDEX idx_movies_title ON movies(title);
CREATE INDEX idx_movies_release_date ON movies(release_date);
CREATE INDEX idx_showtimes_movie_hall_time ON showtimes(movie_id, hall_id, start_time);
CREATE INDEX idx_showtimes_start_time ON showtimes(start_time);
CREATE INDEX idx_bookings_customer_time ON bookings(customer_id, booking_time);
CREATE INDEX idx_bookings_showtime ON bookings(showtime_id);
CREATE INDEX idx_bookings_reference ON bookings(booking_reference);
CREATE INDEX idx_bookings_status ON bookings(status);
CREATE INDEX idx_booking_seats_booking ON booking_seats(booking_id);
CREATE INDEX idx_booking_seats_seat ON booking_seats(seat_id);
CREATE INDEX idx_payments_booking ON payments(booking_id);
CREATE INDEX idx_payments_status ON payments(status);
CREATE INDEX idx_seats_hall ON seats(hall_id);
CREATE INDEX idx_inventory_category ON inventory(category);
CREATE INDEX idx_audit_log_table_record ON audit_log(table_name, record_id);
CREATE INDEX idx_audit_log_timestamp ON audit_log(timestamp);

-- Insert sample roles
INSERT INTO roles (role_name, description) VALUES
                                               ('Admin', 'Full system access'),
                                               ('Manager', 'Theater management access'),
                                               ('Cashier', 'Booking and payment access'),
                                               ('Maintenance', 'System maintenance access');

-- Insert sample hall location
INSERT INTO hall_location (name, address, city, state, postal_code, phone) VALUES
    ('Main Theater', '123 Cinema Street', 'Movie City', 'CA', '90210', '555-0123');

-- Insert sample cinema hall
INSERT INTO cinema_halls (name, hall_location_id, total_seats, hall_type) VALUES
                                                                              ('Hall A', 1, 100, 'standard'),
                                                                              ('Hall B', 1, 150, 'premium'),
                                                                              ('Hall C', 1, 80, 'vip');

-- Triggers for audit logging (example for bookings table)
DELIMITER //
CREATE TRIGGER booking_audit_insert
    AFTER INSERT ON bookings
    FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action, new_values, user_type)
    VALUES ('bookings', NEW.id, 'INSERT', JSON_OBJECT(
        'booking_reference', NEW.booking_reference,
        'customer_id', NEW.customer_id,
        'showtime_id', NEW.showtime_id,
        'total_amount', NEW.total_amount,
        'status', NEW.status
                                          ), 'system');
END//

CREATE TRIGGER booking_audit_update
    AFTER UPDATE ON bookings
    FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action, old_values, new_values, user_type)
    VALUES ('bookings', NEW.id, 'UPDATE',
            JSON_OBJECT('status', OLD.status, 'total_amount', OLD.total_amount),
            JSON_OBJECT('status', NEW.status, 'total_amount', NEW.total_amount),
            'system');
END//
DELIMITER ;

-- Function to generate booking reference
DELIMITER //
CREATE FUNCTION generate_booking_reference()
    RETURNS VARCHAR(20)
    READS SQL DATA
    DETERMINISTIC
BEGIN
    DECLARE ref VARCHAR(20);
    DECLARE done INT DEFAULT 0;

    REPEAT
SET ref = CONCAT('BK', DATE_FORMAT(NOW(), '%Y%m%d'), LPAD(FLOOR(RAND() * 10000), 4, '0'));
        SET done = (SELECT COUNT(*) FROM bookings WHERE booking_reference = ref) = 0;
    UNTIL done END REPEAT;

RETURN ref;
END//
DELIMITER ;

-- Views for common queries
CREATE VIEW active_showtimes AS
SELECT
    s.id,
    s.start_time,
    s.end_time,
    s.base_price,
    m.title as movie_title,
    m.duration_minutes,
    m.rating,
    ch.name as hall_name,
    hl.name as location_name,
    (ch.total_seats - COALESCE(booked_seats.count, 0)) as available_seats
FROM showtimes s
         JOIN movies m ON s.movie_id = m.id
         JOIN cinema_halls ch ON s.hall_id = ch.id
         JOIN hall_location hl ON ch.hall_location_id = hl.id
         LEFT JOIN (
    SELECT
        b.showtime_id,
        COUNT(bs.seat_id) as count
    FROM bookings b
        JOIN booking_seats bs ON b.id = bs.booking_id
    WHERE b.status = 'confirmed'
    GROUP BY b.showtime_id
) booked_seats ON s.id = booked_seats.showtime_id
WHERE s.is_active = TRUE
  AND m.is_active = TRUE
  AND ch.is_active = TRUE
  AND s.start_time > NOW();

CREATE VIEW booking_summary AS
SELECT
    b.id,
    b.booking_reference,
    c.name as customer_name,
    c.email as customer_email,
    m.title as movie_title,
    s.start_time,
    ch.name as hall_name,
    b.total_amount,
    b.status,
    GROUP_CONCAT(st.seat_number ORDER BY st.seat_number) as seat_numbers
FROM bookings b
         JOIN customers c ON b.customer_id = c.id
         JOIN showtimes s ON b.showtime_id = s.id
         JOIN movies m ON s.movie_id = m.id
         JOIN cinema_halls ch ON s.hall_id = ch.id
         JOIN booking_seats bs ON b.id = bs.booking_id
         JOIN seats st ON bs.seat_id = st.id
GROUP BY b.id;
