-- Create database
CREATE DATABASE IF NOT EXISTS bharathi_surgicals;
USE bharathi_surgicals;

-- Create contact_submissions table
CREATE TABLE IF NOT EXISTS contact_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255),
    message TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    ip_address VARCHAR(45)
);

-- Create locations table
CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    display_order INT DEFAULT 0
);

-- Create company_info table
CREATE TABLE IF NOT EXISTS company_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(50),
    email VARCHAR(255),
    address TEXT
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2),
    category VARCHAR(100),
    stock INT DEFAULT 0,
    image VARCHAR(255),
    specifications TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



-- Insert default company information
INSERT INTO company_info (phone, email, address) VALUES
('+91-97909 72432', 'cs@bharathi.co.in', 'Rajapalayam, Tamil Nadu, India');

-- Insert default locations
INSERT INTO locations (title, address, display_order) VALUES
('Head Office', 'Bharathi Surgicals\n151/9 New Street,\nChatrapatti - 626 102.\nVia Rajapalayam,\nVirudhunagar Dist.\nTamil Nadu, India.', 1),
('Branch Office', 'Bharathi Surgicals,\nHouse No 145, Lane No. 6,\nGitanjali City Phase # 1,\nBhatauri Road,\nBilaspur - 495 006.\nChhattisgarh, India.', 2),
('Branch Office', 'Bharathi Surgicals,\nS. Thiruvalluvar Street,\nKattankudathur,\nChengalput - 603203.\nTamil Nadu, India.', 3);

INSERT INTO products (name, description, category, image, specifications) VALUES
('Gauze Bandage Cloth', 'High-quality gauze bandage cloth for medical use.', 'Absorbent Gauze', '../assets/Gauze_Bandage_Cloth.jpg', 'Size: 10m rolls|Material: 100% Cotton|Sterile: Yes'),
('Absorbent Gauze Sponge', 'Highly absorbent gauze sponges for wound care.', 'Absorbent Gauze', '../assets/Absorbent_Gauze_Sponge.jpg', 'Size: 4x4 inches|Ply: 8-12|Sterile: Yes'),
('Cotton Roller Bandage', 'Soft cotton roller bandage for comfortable support.', 'Roller Bandage', '../assets/Cotton_Roller_Bandage.jpg', 'Width: 2-6 inches|Material: Cotton|Elastic: No'),
('Elastic Roller Bandage', 'Elastic roller bandage for compression and support.', 'Roller Bandage', '../assets/gaus.jpeg', 'Width: 3-6 inches|Material: Cotton+Elastic|Compression: Medium');