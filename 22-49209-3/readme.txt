HOW TO RUN THE PROJECT (Smart Restaurant System)
================================================

STEP 1: START SERVER
--------------------
1. Open XAMPP Control Panel.
2. Start "Apache" and "MySQL".
3. Open your browser.

STEP 2: DATABASE SETUP (First Time Only)
----------------------------------------
Because this project follows strict MVC, we use a controller to set up the database.

1. Go to this URL to open Admin Tools:
   http://localhost/BACHAO PROJECT/public/index.php?controller=admin

2. Click the link that says "HARD RESET (Drop Table)".
   - This will create the database tables.
   - It creates the default admin user.

3. Click the link that says "Fix Missing Coupons (Seed)".
   - This adds coupons like WELCOME50.

STEP 3: LOGIN
-------------
1. Go to the main page:
   http://localhost/BACHAO PROJECT/public/index.php

2. Use these credentials:
   Username: admin
   Password: admin123

TROUBLESHOOTING
---------------
- If you see "Database Error", make sure XAMPP MySQL is running.
- If Login fails, go back to Step 2 and run "HARD RESET" again.
