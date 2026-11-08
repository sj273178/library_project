USE library_db;

-- Books currently on loan with the member who borrowed each copy
SELECT b.title, b.isbn, m.full_name AS member, l.date_issued, l.due_date
FROM loans AS l
JOIN books AS b ON b.book_id = l.book_id
JOIN members AS m ON m.member_id = l.member_id
WHERE l.date_returned IS NULL
ORDER BY l.due_date;

-- Loans that are past their due date and have not been returned
SELECT m.member_number, m.full_name, b.title, l.due_date,
       DATEDIFF(CURDATE(), l.due_date) AS days_overdue
FROM loans AS l
JOIN members AS m ON m.member_id = l.member_id
JOIN books AS b ON b.book_id = l.book_id
WHERE l.date_returned IS NULL AND l.due_date < CURDATE()
ORDER BY l.due_date;

-- Aggregate report: total loans made for each category
SELECT c.name AS category, COUNT(l.loan_id) AS total_loans
FROM categories AS c
LEFT JOIN books AS b ON b.category_id = c.category_id
LEFT JOIN loans AS l ON l.book_id = b.book_id
GROUP BY c.category_id, c.name
ORDER BY total_loans DESC, c.name;
