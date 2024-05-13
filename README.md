    
**XAMPP/ZIP FILE INSTALLATION:**
You need to download XAMPP with Apache and MYSQL services both online, then head to your local directory, example:
C:\xampp\htdocs\
And you'll unpack the zip file there, named crud (note that everything in this program is case sensitive, so make sure not to make too many changes)

Once you place the folder, open XAMPP and go click ADMIN on MySQL, this will lead you to PhPMyAdmin, click on new on the left, and create a database with the name 'crudoperation', once you create it, click on it and create a table named 'crud', the tables contents are as follows:

ID Primary	int(11)
Name	varchar(100)
EMAIL	varchar(100)
Mobile	varchar(20)
Password	varchar(255)
(PLEASE MAKE SURE YOU COPY WORD FOR WORD)

Navigation of the program should be simple, you have your own database to test, attempt creation, deletion, editing, logging in and out of different users, etc.

**As for the code, here is a quick rundown of every file and its task:**

connect.php is our way of connecting php to MYSQL, if you want to test if the website connects correctly, uncomment the echo and it should show in the login page


User.php:  This code implements a user registration form in PHP along with HTML for the front-end;
Input validation and sanitization are performed using filter_var() to ensure that the data meets expected formats and to prevent potential security vulnerabilities like XSS attacks.
The password provided by the user is hashed using the password_hash() function before storing it in the database. This ensures that passwords are securely stored, even if the database is compromised.
Prepared statements are used for interacting with the database (mysqli_prepare(), mysqli_stmt_bind_param()) to prevent SQL injection attacks.
Parameters are bound to the prepared statement to separate user input from SQL commands, enhancing security.


Login.php, used to login and create a session for the user to enter the database
The logLoginAttempt function logs login attempts. It takes two parameters: $username (the username attempted to log in) and $success (a boolean indicating whether the login attempt was successful or not). 
It then generates a log message containing the username, success status, and the current date/time, and then writes this message to a log file named login_log.txt.
When the user submits the login form, the code validates and sanitizes the user input ($login_name and $login_password). It then prepares a SQL statement to fetch the user's data based on the provided username. 
If a matching user is found, it verifies the password using password_verify.
(Security here is: Sanitization, Password Hashing, Error logging, Prepared Statements)

Display.php is the heart of this operation, has all the users and their data aside from their passwords for security reasons.
It uses session authentication to not allow anyone but logged in users to access it. You can delete and edit the users that were registered in the SQL database.
It leads to both edit_user.php and delete_user.php, which do both their tasks accordingly, following the same access control of display.php, and the user who performs these actions will be logged, and what they've changed will be logged aswell.


**General security overview:**
-User input is sanitized using filter_var() to prevent XSS attacks.
-Passwords are hashed using password_hash() before storing them in the database, and when a user logs in, their input is hashed and compared with the database.
-Prepared statements separate the SQL code from the data, preventing the database from interpreting user input as SQL commands. This makes it impossible for attackers to inject malicious SQL code into the query.
-Error messages are logged instead of being displayed to the user for security reasons. 
-Audits are created to read through when users logged in, and when they interact with the system in any way, this includes operations to show what was deleted by who and etc.
-Sessions are made to prevent users from entering into the system via url without having login permissions. This also helps us track each user and what they are doing in the system.
