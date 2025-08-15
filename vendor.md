-- Cinema Vendor/Supplier Database Script
-- This script creates and populates a comprehensive vendor table for cinema management

-- Create the database
CREATE DATABASE IF NOT EXISTS cinema_management;
USE cinema_management;

-- Create the vendors table
DROP TABLE IF EXISTS vendors;
CREATE TABLE vendors (
    vendor_id VARCHAR(10) PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL,
    vendor_type ENUM('Equipment Supplier', 'Food & Beverage', 'Cleaning & Maintenance', 
                     'Technology Provider', 'Furniture Supplier', 'Security Services', 
                     'Marketing Materials', 'Software Provider', 'Insurance Provider', 
                     'Utilities & Maintenance', 'Construction', 'Legal Services',
                     'Financial Services', 'Transportation', 'Waste Management') NOT NULL,
    contact_person VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    services TEXT NOT NULL,
    contract_start DATE NOT NULL,
    contract_end DATE NOT NULL,
    status ENUM('Active', 'Inactive', 'Pending', 'Expired') DEFAULT 'Active',
    rating DECIMAL(2,1) CHECK (rating >= 1.0 AND rating <= 5.0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert 50+ vendor records
INSERT INTO vendors (vendor_id, company_name, vendor_type, contact_person, phone, email, address, services, contract_start, contract_end, status, rating) VALUES

-- Equipment Suppliers
('V001', 'MovieTech Solutions', 'Equipment Supplier', 'John Smith', '+1-555-0123', 'john@movietech.com', '123 Cinema Ave, Hollywood, CA 90028', 'Digital Projectors, Sound Systems, Audio Equipment', '2024-01-15', '2026-01-15', 'Active', 4.8),
('V002', 'CinemaMax Equipment', 'Equipment Supplier', 'David Rodriguez', '+1-555-0234', 'david@cinemamax.com', '456 Equipment St, Los Angeles, CA 90012', 'IMAX Projectors, Premium Sound Systems', '2023-08-01', '2025-08-01', 'Active', 4.9),
('V003', 'ProjectorPro Inc.', 'Equipment Supplier', 'Michelle Turner', '+1-555-0345', 'michelle@projectorpro.com', '789 Tech Blvd, Burbank, CA 91501', 'Laser Projectors, Maintenance Services', '2024-03-01', '2027-03-01', 'Active', 4.7),
('V004', 'AudioVision Systems', 'Equipment Supplier', 'Robert Kim', '+1-555-0456', 'robert@audiovision.com', '321 Sound Ave, Nashville, TN 37201', 'Surround Sound, Speaker Systems, Amplifiers', '2023-11-15', '2025-11-15', 'Active', 4.6),
('V005', 'DigitalCinema Corp', 'Equipment Supplier', 'Sarah Chen', '+1-555-0567', 'sarah@digitalcinema.com', '654 Digital Dr, San Francisco, CA 94102', 'Digital Cinema Servers, Storage Solutions', '2024-02-01', '2026-02-01', 'Active', 4.8),

-- Food & Beverage Suppliers
('V006', 'Snack Masters Inc.', 'Food & Beverage', 'Sarah Johnson', '+1-555-0678', 'sarah@snackmasters.com', '789 Food Court Blvd, Los Angeles, CA 90015', 'Popcorn, Candy, Beverages, Nachos', '2023-06-01', '2025-06-01', 'Active', 4.4),
('V007', 'PopcornPlus Distribution', 'Food & Beverage', 'Mike Williams', '+1-555-0789', 'mike@popcornplus.com', '987 Snack St, Chicago, IL 60601', 'Gourmet Popcorn, Specialty Seasonings', '2024-01-01', '2025-01-01', 'Active', 4.3),
('V008', 'BeverageBoss Suppliers', 'Food & Beverage', 'Lisa Garcia', '+1-555-0890', 'lisa@beverageboss.com', '147 Drink Ave, Atlanta, GA 30301', 'Soft Drinks, Coffee, Energy Drinks', '2023-09-15', '2024-09-15', 'Expired', 4.2),
('V009', 'CandyLand Distributors', 'Food & Beverage', 'James Wilson', '+1-555-0901', 'james@candyland.com', '258 Sweet St, Denver, CO 80201', 'Movie Theater Candy, Chocolate, Gummies', '2024-04-01', '2026-04-01', 'Active', 4.5),
('V010', 'FreshTreats Supply', 'Food & Beverage', 'Amanda Lopez', '+1-555-1012', 'amanda@freshtreats.com', '369 Fresh Blvd, Miami, FL 33101', 'Hot Dogs, Pizza, Pretzels, Ice Cream', '2023-12-01', '2025-12-01', 'Active', 4.1),

-- Technology Providers
('V011', 'TechCinema Solutions', 'Technology Provider', 'Kevin Park', '+1-555-1123', 'kevin@techcinema.com', '741 Innovation Dr, Austin, TX 78701', 'Digital Projection Systems, Network Infrastructure', '2024-01-01', '2027-01-01', 'Active', 4.9),
('V012', 'SmartTheater Systems', 'Technology Provider', 'Rachel Green', '+1-555-1234', 'rachel@smarttheater.com', '852 Tech Park, Seattle, WA 98101', 'Automation Systems, Climate Control', '2023-10-15', '2025-10-15', 'Active', 4.7),
('V013', 'CinemaCloud Services', 'Technology Provider', 'Daniel Brown', '+1-555-1345', 'daniel@cinemacloud.com', '963 Cloud Ave, Portland, OR 97201', 'Content Delivery, Digital Distribution', '2024-02-15', '2026-02-15', 'Active', 4.8),
('V014', 'AudioTech Innovations', 'Technology Provider', 'Jessica Martinez', '+1-555-1456', 'jessica@audiotech.com', '159 Sound Tech Blvd, Las Vegas, NV 89101', 'Immersive Audio, Dolby Atmos Systems', '2023-07-01', '2025-07-01', 'Active', 4.6),

-- Software Providers
('V015', 'TicketFlow Systems', 'Software Provider', 'Kevin Thompson', '+1-555-1567', 'kevin@ticketflow.com', '369 Software Lane, Austin, TX 78702', 'Ticketing System, POS Integration, Mobile Apps', '2024-04-01', '2027-04-01', 'Active', 4.9),
('V016', 'CinemaManager Pro', 'Software Provider', 'Maria Rodriguez', '+1-555-1678', 'maria@cinemamanager.com', '753 Management St, San Jose, CA 95101', 'Theater Management Software, Scheduling', '2023-08-15', '2025-08-15', 'Active', 4.7),
('V017', 'MovieMetrics Analytics', 'Software Provider', 'Thomas Anderson', '+1-555-1789', 'thomas@moviemetrics.com', '951 Analytics Ave, Boston, MA 02101', 'Business Intelligence, Analytics Dashboard', '2024-03-01', '2026-03-01', 'Active', 4.5),
('V018', 'PaymentPro Cinema', 'Software Provider', 'Jennifer White', '+1-555-1890', 'jennifer@paymentpro.com', '357 Payment Blvd, New York, NY 10001', 'Payment Processing, Credit Card Systems', '2023-11-01', '2025-11-01', 'Active', 4.6),

-- Furniture Suppliers
('V019', 'ComfortSeats Plus', 'Furniture Supplier', 'Robert Davis', '+1-555-1901', 'robert@comfortseats.com', '987 Furniture Way, Phoenix, AZ 85001', 'Theater Seating, Recliners, VIP Chairs', '2024-02-01', '2027-02-01', 'Active', 4.4),
('V020', 'LuxuryChairs Inc.', 'Furniture Supplier', 'Patricia Johnson', '+1-555-2012', 'patricia@luxurychairs.com', '741 Comfort Dr, Dallas, TX 75201', 'Premium Leather Seating, Custom Designs', '2023-09-01', '2025-09-01', 'Active', 4.8),
('V021', 'TheaterFurniture Pro', 'Furniture Supplier', 'Michael Chang', '+1-555-2123', 'michael@theaterfurniture.com', '852 Seating Blvd, Minneapolis, MN 55401', 'Stadium Seating, Accessibility Chairs', '2024-01-15', '2026-01-15', 'Active', 4.3),

-- Security Services
('V022', 'SecureWatch Systems', 'Security Services', 'Amanda Brown', '+1-555-2234', 'amanda@securewatch.com', '654 Security Blvd, Las Vegas, NV 89102', 'CCTV Systems, Access Control, Security Guards', '2023-12-01', '2025-12-01', 'Active', 4.7),
('V023', 'GuardianSecurity Pro', 'Security Services', 'Carlos Rivera', '+1-555-2345', 'carlos@guardian.com', '159 Protection St, Houston, TX 77001', 'Armed Security, Surveillance, Emergency Response', '2024-03-15', '2026-03-15', 'Active', 4.6),
('V024', 'SafeTheater Solutions', 'Security Services', 'Nicole Taylor', '+1-555-2456', 'nicole@safetheater.com', '753 Safety Ave, Philadelphia, PA 19101', 'Fire Safety Systems, Emergency Protocols', '2023-10-01', '2024-10-01', 'Expired', 4.4),

-- Cleaning & Maintenance
('V025', 'CleanScreen Services', 'Cleaning & Maintenance', 'Mike Wilson', '+1-555-2567', 'mike@cleanscreen.com', '456 Service St, Burbank, CA 91502', 'Theater Cleaning, Equipment Maintenance, Carpet Care', '2024-03-01', '2025-03-01', 'Active', 4.2),
('V026', 'MaintainMax Solutions', 'Cleaning & Maintenance', 'Linda Adams', '+1-555-2678', 'linda@maintainmax.com', '258 Clean Blvd, San Diego, CA 92101', 'Deep Cleaning, Restroom Maintenance, HVAC Cleaning', '2023-07-15', '2024-07-15', 'Expired', 4.1),
('V027', 'ProfessionalClean Corp', 'Cleaning & Maintenance', 'David Martinez', '+1-555-2789', 'david@professionalclean.com', '369 Maintenance Dr, Tampa, FL 33601', 'Janitorial Services, Floor Care, Window Cleaning', '2024-01-01', '2025-01-01', 'Active', 4.3),

-- Utilities & Maintenance
('V028', 'PowerUp Electrical', 'Utilities & Maintenance', 'Steven Garcia', '+1-555-2890', 'steven@powerup.com', '258 Electric Ave, Denver, CO 80202', 'Electrical Systems, HVAC, Plumbing Services', '2024-01-01', '2025-01-01', 'Active', 4.0),
('V029', 'EnergyEfficient Systems', 'Utilities & Maintenance', 'Rebecca Miller', '+1-555-2901', 'rebecca@energyefficient.com', '147 Power St, Cleveland, OH 44101', 'LED Lighting, Energy Management, Solar Solutions', '2023-08-01', '2025-08-01', 'Active', 4.5),
('V030', 'UtilityMaster Services', 'Utilities & Maintenance', 'Jason Wong', '+1-555-3012', 'jason@utilitymaster.com', '951 Utility Blvd, Kansas City, MO 64101', 'Water Systems, Waste Management, Emergency Repairs', '2024-02-01', '2026-02-01', 'Active', 4.2),

-- Marketing Materials
('V031', 'MovieMag Distributors', 'Marketing Materials', 'Jennifer White', '+1-555-3123', 'jennifer@moviemag.com', '147 Marketing St, New York, NY 10002', 'Movie Posters, Standees, Digital Displays', '2023-08-15', '2024-08-15', 'Expired', 4.1),
('V032', 'PromoMax Cinema', 'Marketing Materials', 'Brian Cooper', '+1-555-3234', 'brian@promomax.com', '753 Promo Ave, Chicago, IL 60602', 'Promotional Materials, Banners, Lobby Displays', '2024-04-01', '2025-04-01', 'Active', 4.3),
('V033', 'DigitalSignage Pro', 'Marketing Materials', 'Melissa Turner', '+1-555-3345', 'melissa@digitalsignage.com', '852 Display Dr, Los Angeles, CA 90013', 'LED Displays, Digital Menus, Interactive Kiosks', '2023-11-01', '2025-11-01', 'Active', 4.6),

-- Insurance Providers
('V034', 'FilmShield Insurance', 'Insurance Provider', 'Rachel Garcia', '+1-555-3456', 'rachel@filmshield.com', '852 Insurance Plaza, Chicago, IL 60603', 'Property Insurance, Liability Coverage, Equipment Protection', '2024-01-01', '2025-01-01', 'Active', 4.4),
('V035', 'CinemaGuard Insurance', 'Insurance Provider', 'Mark Johnson', '+1-555-3567', 'mark@cinemaguard.com', '159 Coverage St, Hartford, CT 06101', 'General Liability, Workers Compensation, Cyber Security', '2023-09-15', '2024-09-15', 'Expired', 4.2),

-- Construction Services
('V036', 'TheaterBuild Construction', 'Construction', 'Anthony Rodriguez', '+1-555-3678', 'anthony@theaterbuild.com', '741 Construction Ave, Phoenix, AZ 85002', 'Theater Renovation, New Construction, Acoustics', '2024-05-01', '2025-05-01', 'Active', 4.7),
('V037', 'CinemaDesign Builders', 'Construction', 'Laura Thompson', '+1-555-3789', 'laura@cinemadesign.com', '963 Builder Blvd, Orlando, FL 32801', 'Interior Design, Custom Theater Builds', '2023-06-01', '2024-06-01', 'Expired', 4.5),

-- Legal Services
('V038', 'EntertainmentLaw Partners', 'Legal Services', 'Jonathan Smith', '+1-555-3890', 'jonathan@entertainmentlaw.com', '357 Legal St, Los Angeles, CA 90014', 'Contract Review, Licensing, Compliance', '2024-01-01', '2024-12-31', 'Active', 4.8),
('V039', 'CorporateLegal Solutions', 'Legal Services', 'Diana Martinez', '+1-555-3901', 'diana@corporatelegal.com', '258 Attorney Ave, New York, NY 10003', 'Business Law, Employment Law, Litigation', '2023-10-15', '2024-10-15', 'Expired', 4.6),

-- Financial Services
('V040', 'CinemaFinance Corp', 'Financial Services', 'Robert Anderson', '+1-555-4012', 'robert@cinemafinance.com', '753 Finance Blvd, Charlotte, NC 28201', 'Equipment Financing, Business Loans, Accounting', '2024-02-01', '2027-02-01', 'Active', 4.5),
('V041', 'TheaterCapital Group', 'Financial Services', 'Sandra Wilson', '+1-555-4123', 'sandra@theatercapital.com', '951 Capital Dr, Nashville, TN 37202', 'Investment Services, Financial Planning', '2023-12-01', '2025-12-01', 'Active', 4.3),

-- Transportation Services
('V042', 'MovieTransport LLC', 'Transportation', 'Carlos Lopez', '+1-555-4234', 'carlos@movietransport.com', '147 Transport St, Atlanta, GA 30302', 'Equipment Transport, Film Reel Delivery', '2024-03-01', '2025-03-01', 'Active', 4.1),
('V043', 'LogisticsPro Cinema', 'Transportation', 'Emily Chen', '+1-555-4345', 'emily@logisticspro.com', '369 Logistics Ave, Memphis, TN 38101', 'Supply Chain Management, Freight Services', '2023-11-01', '2024-11-01', 'Expired', 4.0),

-- Waste Management
('V044', 'EcoClean Waste', 'Waste Management', 'Michael Davis', '+1-555-4456', 'michael@ecoclean.com', '258 Waste Blvd, Portland, OR 97202', 'Waste Disposal, Recycling Programs, Composting', '2024-01-15', '2025-01-15', 'Active', 4.2),
('V045', 'GreenTheater Solutions', 'Waste Management', 'Patricia Brown', '+1-555-4567', 'patricia@greentheater.com', '741 Green St, San Francisco, CA 94103', 'Sustainable Waste Management, Environmental Compliance', '2023-08-01', '2024-08-01', 'Expired', 4.4),

-- Additional Equipment Suppliers
('V046', 'AudioMax Pro Systems', 'Equipment Supplier', 'William Taylor', '+1-555-4678', 'william@audiomax.com', '852 Audio Dr, Nashville, TN 37203', 'Professional Audio Equipment, Mixing Consoles', '2024-04-15', '2026-04-15', 'Active', 4.6),
('V047', 'VideoTech Solutions', 'Equipment Supplier', 'Catherine Kim', '+1-555-4789', 'catherine@videotech.com', '159 Video Ave, Las Vegas, NV 89103', 'Video Processors, Display Calibration', '2023-07-01', '2025-07-01', 'Active', 4.7),

-- Additional Food & Beverage
('V048', 'PremiumSnacks Inc.', 'Food & Beverage', 'George Rodriguez', '+1-555-4890', 'george@premiumsnacks.com', '753 Premium St, Dallas, TX 75202', 'Artisan Popcorn, Gourmet Treats, Healthy Options', '2024-05-01', '2026-05-01', 'Active', 4.3),
('V049', 'DrinkMaster Distributors', 'Food & Beverage', 'Helen Martinez', '+1-555-4901', 'helen@drinkmaster.com', '963 Beverage Blvd, Phoenix, AZ 85003', 'Specialty Beverages, Craft Sodas, Smoothies', '2023-12-15', '2024-12-15', 'Active', 4.2),

-- Additional Technology
('V050', 'NextGen Cinema Tech', 'Technology Provider', 'Alexander Wong', '+1-555-5012', 'alexander@nextgencinema.com', '357 Future Dr, San Jose, CA 95102', 'VR Systems, AR Experiences, Interactive Technology', '2024-06-01', '2027-06-01', 'Pending', 4.8);

-- Create indexes for better performance
CREATE INDEX idx_vendor_type ON vendors(vendor_type);
CREATE INDEX idx_status ON vendors(status);
CREATE INDEX idx_contract_end ON vendors(contract_end);
CREATE INDEX idx_rating ON vendors(rating);

-- Create a view for active vendors only
CREATE VIEW active_vendors AS
SELECT * FROM vendors 
WHERE status = 'Active'
ORDER BY rating DESC;

-- Create a view for vendors with expiring contracts (within 90 days)
CREATE VIEW expiring_contracts AS
SELECT vendor_id, company_name, contact_person, phone, email, contract_end,
       DATEDIFF(contract_end, CURDATE()) as days_until_expiry
FROM vendors 
WHERE status = 'Active' 
AND contract_end <= DATE_ADD(CURDATE(), INTERVAL 90 DAY)
ORDER BY contract_end ASC;

-- Summary query to show vendor statistics
SELECT 
    vendor_type,
    COUNT(*) as total_vendors,
    SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) as active_vendors,
    AVG(rating) as average_rating
FROM vendors 
GROUP BY vendor_type
ORDER BY total_vendors DESC;
<!-- Test table vendor -->