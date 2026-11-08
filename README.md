# Library Management System

GitHub repository: <https://github.com/sj273178/library_project>.

This PHP and MySQL Library Management System was built for DBMS-II CAT 2. An authenticated librarian can manage books, members, authors, categories, and loans from the browser. The system enforces copy availability, member status, duplicate-loan prevention, automatic fourteen-day due dates, and safe book returns.

## Group members and responsibilities

| Student     | Main responsibility                     |
| ----------- | --------------------------------------- |
| Mwaka       | Shared includes and project integration |
| Milly       | Authentication                          |
| Jeslor      | Configuration, database, and categories |
| Esther M    | Books                                   |
| Suban       | Loans                                   |
| Tukamushaba | Index page and dashboard                |
| Abdirizak   | Authors                                 |
| Swaburah    | Members                                 |

## Requirements

Install XAMPP with Apache, MySQL, and PHP enabled. The project uses PHP PDO with MySQL or MariaDB. No Composer packages are required.

## Installation and running on XAMPP

1. Download and install XAMPP from [Apache Friends](https://www.apachefriends.org/). The normal Windows installation folder is `C:\xampp`.
2. Open the XAMPP Control Panel and start both Apache and MySQL. If Apache does not start, close the program using port 80 or 443, or change the Apache port in its configuration.
3. Copy this complete project folder into `C:\xampp\htdocs\` and name the folder `library-system`.
4. Open `http://localhost/phpmyadmin` in a browser. Create a database named `library_db` with collation `utf8mb4_general_ci` if phpMyAdmin asks for one. The supplied SQL file also recreates the database from scratch.
5. Select the database in phpMyAdmin, choose **Import**, select `database/library_db.sql`, then click **Import**. This creates all tables, relationships, constraints, and sample data.
6. Check `config/database.php`. A new XAMPP installation normally uses host `localhost`, username `root`, and an empty password. Update the values only if your local MySQL configuration is different.
7. Open `http://localhost/library-system` in the browser. Sign in with username `admin` and password `password`.

## Test accounts

| Username  | Password | Role      |
| --------- | -------- | --------- |
| admin     | password | admin     |
| librarian | password | librarian |

These are deliberately fake demonstration accounts. Passwords in the database are stored as `password_hash()` values and login uses `password_verify()`.

## Database files

`database/library_db.sql` creates the database and inserts sample data, including more than ten books, five authors, five categories, ten members, and ten loans. `database/queries.sql` contains the required JOIN and aggregate reports. `database/erd.png` shows the Entity Relationship Diagram.

## Security and application notes

All pages other than the sign-in page require an active PHP session. Database operations that receive input use PDO prepared statements. Server-side validation is applied before records are saved, database values are escaped before display, and user-facing messages do not expose database errors. Issuing and returning a book each use a database transaction so that the loan record and available-copy count always change together.

## Suggested demonstration flow

Sign in, add a book and a member, search for them, edit them, issue a book, return it, then delete records that have no loan history. During the demonstration, attempt to issue an unavailable book, issue the same book twice to one member, issue to a suspended member, and delete a book or member with an active loan. The system should display a clear message for each rejected action.
