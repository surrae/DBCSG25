-User input is sanitized using filter_var() to prevent XSS attacks.
-Passwords are hashed using password_hash() before storing them in the database, and when a user logs in, their input is hashed and compared with the database.
-Prepared statements separate the SQL code from the data, preventing the database from interpreting user input as SQL commands. This makes it impossible for attackers to inject malicious SQL code into the query.
-Error messages are logged instead of being displayed to the user for security reasons. 
-Audits are created to read through when users logged in, and when they interact with the system in any way, this includes operations to show what was deleted by who and etc.
-Sessions are made to prevent users from entering into the system via url without having login permissions. This also helps us track each user and what they are doing in the system.
    



