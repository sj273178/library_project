USE library_db;

-- Books currently on loan and their borrowers
SELECT b.title, b.isbn, m.full_name AS member, l.date_issued, l.due_date
FROM loans l JOIN books b ON b.book_id = l.book_id
JOIN members m ON m.member_id = l.member_id
WHERE l.date_returned IS NULL ORDER BY l.due_date;

-- Overdue loans
SELECT m.member_number, m.full_name, b.title, l.due_date, DATEDIFF(CURDATE(), l.due_date) AS days_overdue
FROM loans l JOIN members m ON m.member_id = l.member_id
JOIN books b ON b.book_id = l.book_id
WHERE l.date_returned IS NULL AND l.due_date < CURDATE();

-- Aggregate report: loans per category
SELECT c.name AS category, COUNT(l.loan_id) AS total_loans
FROM categories c LEFT JOIN books b ON b.category_id = c.category_id
LEFT JOIN loans l ON l.book_id = b.book_id
GROUP BY c.category_id, c.name ORDER BY total_loans DESC;