DROP DATABASE IF EXISTS library_db;
CREATE DATABASE library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE library_db;



CREATE TABLE authors (
    author_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE,
    country VARCHAR(100) NOT NULL
) ENGINE=InnoDB;



CREATE TABLE categories (
    category_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(255) NOT NULL
) ENGINE=InnoDB;



CREATE TABLE users (
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    user_role ENUM('admin', 'librarian') NOT NULL DEFAULT 'librarian'
) ENGINE=InnoDB;



CREATE TABLE members (
    member_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    member_number VARCHAR(30) NOT NULL UNIQUE,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(30) NOT NULL,
    status ENUM('active', 'suspended') NOT NULL DEFAULT 'active',
    date_joined DATE NOT NULL
) ENGINE=InnoDB;



CREATE TABLE books (
    book_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    title VARCHAR(200) NOT NULL,
    author_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    publisher VARCHAR(150) NOT NULL,
    year_published SMALLINT UNSIGNED NOT NULL,
    total_copies INT UNSIGNED NOT NULL DEFAULT 1,
    available_copies INT UNSIGNED NOT NULL DEFAULT 1,

    CONSTRAINT fk_book_author
    FOREIGN KEY (author_id)
    REFERENCES authors(author_id)
    ON DELETE RESTRICT,

    CONSTRAINT fk_book_category
    FOREIGN KEY (category_id)
    REFERENCES categories(category_id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;



CREATE TABLE loans (
    loan_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    member_id INT UNSIGNED NOT NULL,
    book_id INT UNSIGNED NOT NULL,
    date_issued DATE NOT NULL,
    due_date DATE NOT NULL,
    date_returned DATE NULL,

    CONSTRAINT fk_loan_member
    FOREIGN KEY (member_id)
    REFERENCES members(member_id)
    ON DELETE RESTRICT,

    CONSTRAINT fk_loan_book
    FOREIGN KEY (book_id)
    REFERENCES books(book_id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;


INSERT INTO authors (name, country) VALUES
('Chimamanda Ngozi Adichie', 'Nigeria'),
('Ngugi wa Thiong''o', 'Kenya'),
('George Orwell', 'United Kingdom'),
('J K Rowling', 'United Kingdom'),
('Paulo Coelho', 'Brazil'),


('Alan Dennis', 'United States'),
('John W. Satzinger', 'United States'),


('C. Thomas Wu', 'United States'),
('Paul Deitel', 'United States'),


('Avi Silberschatz', 'United States'),
('Elvis C. Foster', 'United States'),


('Jennifer Niederst Robbins', 'United States'),
('Mark J. Collins', 'United States');



INSERT INTO categories (name, description) VALUES
('Fiction', 'Literary and popular fiction'),
('Science Fiction', 'Speculative and futuristic stories'),
('Biography', 'Life stories and memoirs'),
('Technology', 'Computing and information technology'),
('Education', 'Learning resources'),

('System Analysis and Design',
 'System development, requirements analysis, modelling and system design'),

('Object-Oriented Programming',
 'Classes, objects, inheritance, polymorphism and programming'),

('Database Management Systems',
 'Database design, SQL, database administration and management'),

('Advanced Web Design',
 'Advanced HTML, CSS, JavaScript and modern web development');



INSERT INTO users (username, password_hash, full_name, user_role) VALUES
('admin',
 '$2y$12$qlQ8.jMzWFWMCyjIw.WoSODCA/bpNZGncJ5oYEoyUjEMD/Mb8iD02',
 'System Administrator',
 'admin'),

('librarian',
 '$2y$12$qlQ8.jMzWFWMCyjIw.WoSODCA/bpNZGncJ5oYEoyUjEMD/Mb8iD02',
 'Grace Librarian',
 'librarian');



INSERT INTO members
(member_number, full_name, email, phone, status, date_joined)
VALUES

('MEM001','Esther Musiime','esther@example.com','0700000001','active','2026-01-10'),

('MEM002','SUBAN Mohamed','suban@example.com','0700000002','active','2026-01-12'),

('MEM003','Swabulah Namirimbe','swabulah@example.com','0700000003','active','2026-01-14'),

('MEM004','Mwaka John','mwaka@example.com','0700000004','suspended','2026-01-16'),

('MEM005','Abdirizak Dahir','abdirizak@example.com','0700000005','active','2026-01-18'),

('MEM006','Tukamushaba Ruth','ruth@example.com','0700000006','active','2026-01-20'),

('MEM007','Jeslor Ssozi','jeslor@example.com','0700000007','active','2026-01-22'),

('MEM008','Milly Kyamanywa','milly@example.com','0700000008','active','2026-01-24'),

('MEM009','Eva Nanyonjo','eva@example.com','0700000009','active','2026-01-26'),

('MEM010','Stephen Kajjoba','stephen@example.com','0700000010','active','2026-01-28');



INSERT INTO books
(isbn,title,author_id,category_id,publisher,year_published,total_copies,available_copies)
VALUES

('9780000000001','Half of a Yellow Sun',1,1,'Fourth Estate',2006,4,3),

('9780000000002','Americanah',1,1,'Fourth Estate',2013,3,2),

('9780000000003','Weep Not Child',2,1,'Heinemann',1964,3,2),

('9780000000004','Decolonising the Mind',2,5,'James Currey',1986,2,1),

('9780000000005','Animal Farm',3,1,'Secker and Warburg',1945,5,4),

('9780000000006','Nineteen Eighty Four',3,2,'Secker and Warburg',1949,4,3),

('9780000000007','Harry Potter and the Philosophers Stone',4,1,'Bloomsbury',1997,5,4),

('9780000000008','The Alchemist',5,1,'HarperOne',1988,4,3),

('9780000000009','The Zahir',5,1,'HarperCollins',2005,2,1),

('9780000000010','Digital Literacy',2,4,'East Africa Press',2020,3,3);



INSERT INTO books
(isbn,title,author_id,category_id,publisher,year_published,total_copies,available_copies)
VALUES

('9780000000011',
 'Systems Analysis and Design',
 (SELECT author_id FROM authors WHERE name = 'Alan Dennis'),
 (SELECT category_id FROM categories WHERE name = 'System Analysis and Design'),
 'Wiley',2021,3,3),

('9780000000012',
 'Systems Analysis and Design in a Changing World',
 (SELECT author_id FROM authors WHERE name = 'John W. Satzinger'),
 (SELECT category_id FROM categories WHERE name = 'System Analysis and Design'),
 'Cengage Learning',2016,3,3);



INSERT INTO books
(isbn,title,author_id,category_id,publisher,year_published,total_copies,available_copies)
VALUES

('9780000000013',
 'An Introduction to Object-Oriented Programming with Java',
 (SELECT author_id FROM authors WHERE name = 'C. Thomas Wu'),
 (SELECT category_id FROM categories WHERE name = 'Object-Oriented Programming'),
 'McGraw-Hill',2010,3,3),

('9780000000014',
 'Java How to Program',
 (SELECT author_id FROM authors WHERE name = 'Paul Deitel'),
 (SELECT category_id FROM categories WHERE name = 'Object-Oriented Programming'),
 'Pearson',2017,3,3);



INSERT INTO books
(isbn,title,author_id,category_id,publisher,year_published,total_copies,available_copies)
VALUES

('9780000000015',
 'Database System Concepts',
 (SELECT author_id FROM authors WHERE name = 'Avi Silberschatz'),
 (SELECT category_id FROM categories WHERE name = 'Database Management Systems'),
 'McGraw-Hill',2019,4,4),

('9780000000016',
 'Database Systems: A Pragmatic Approach',
 (SELECT author_id FROM authors WHERE name = 'Elvis C. Foster'),
 (SELECT category_id FROM categories WHERE name = 'Database Management Systems'),
 'Apress',2016,3,3);


INSERT INTO books
(isbn,title,author_id,category_id,publisher,year_published,total_copies,available_copies)
VALUES

('9780000000017',
 'Learning Web Design',
 (SELECT author_id FROM authors WHERE name = 'Jennifer Niederst Robbins'),
 (SELECT category_id FROM categories WHERE name = 'Advanced Web Design'),
 'O Reilly Media',2018,3,3),

('9780000000018',
 'Pro HTML5 with CSS, JavaScript, and Multimedia',
 (SELECT author_id FROM authors WHERE name = 'Mark J. Collins'),
 (SELECT category_id FROM categories WHERE name = 'Advanced Web Design'),
 'Apress',2017,3,3);


INSERT INTO loans
(member_id,book_id,date_issued,due_date,date_returned)
VALUES

(1,1,'2026-10-20','2026-11-03',NULL),

(2,2,'2026-10-25','2026-11-08',NULL),

(3,3,'2026-10-01','2026-10-15',NULL),

(5,4,'2026-10-15','2026-10-29',NULL),

(6,5,'2026-10-01','2026-10-15','2026-10-10'),

(7,6,'2026-10-02','2026-10-16',NULL),

(8,7,'2026-09-01','2026-09-15','2026-09-12'),

(9,8,'2026-09-05','2026-09-19','2026-09-18'),

(10,9,'2026-10-03','2026-10-17',NULL),

(1,10,'2026-08-01','2026-08-15','2026-08-10');