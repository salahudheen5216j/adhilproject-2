# Windows Terminal Complete Installation Guide 🖥️

A complete step-by-step tutorial for installing the Todo List project using **Windows Terminal** or **Command Prompt**.

## Prerequisites

- Windows 10 or later
- Administrator access
- Internet connection
- About 500MB free disk space

## Step-by-Step Installation

### Step 1: Install Git (if not already installed)

**Download Git from:** https://git-scm.com/download/win

1. Run the installer
2. Click "Next" through all steps (use defaults)
3. Click "Install"
4. Click "Finish"

**Verify Git is installed:**
```cmd
git --version
```

### Step 2: Install XAMPP

**Download XAMPP from:** https://www.apachefriends.org/download.html
- Choose the PHP version you want (8.0+ recommended)

**Installation steps:**
1. Run the installer `xampp-windows-x64-*.exe`
2. Click "Next"
3. Keep the default path: `C:\xampp`
4. On "Select Components", make sure these are checked:
   - ✅ Apache
   - ✅ MySQL
   - ✅ PHP
5. Click "Next" → "Install" → "Finish"

**Verify XAMPP installation:**
```cmd
C:\xampp\apache\bin\httpd.exe -v
```

### Step 3: Open Windows Terminal (Command Prompt)

**How to open:**
- Press `Win + R`
- Type `cmd` and press Enter
- Or search for "Command Prompt" in Start Menu

### Step 4: Navigate to Project Directory

Copy and paste this command into Command Prompt:

```cmd
cd C:\xampp\htdocs
```

Press Enter.

### Step 5: Clone the Project

**Option A: Using Git (Recommended)**

```cmd
git clone https://github.com/salahudheen5216j/adhilproject-2.git
cd adhilproject-2
```

**Option B: Using Curl (if Git not available)**

```cmd
curl -L https://github.com/salahudheen5216j/adhilproject-2/archive/main.zip -o project.zip
tar -xf project.zip
cd adhilproject-2-main
```

**Option C: Manual Download**

1. Go to: https://github.com/salahudheen5216j/adhilproject-2
2. Click "Code" → "Download ZIP"
3. Extract to: `C:\xampp\htdocs\adhilproject-2`
4. Open Command Prompt and run:
   ```cmd
   cd C:\xampp\htdocs\adhilproject-2
   ```

### Step 6: Start XAMPP Services

**Open XAMPP Control Panel:**

1. Press `Win + R`
2. Type: `C:\xampp\xampp-control.exe`
3. Click OK (Run as Administrator if prompted)

**In XAMPP Control Panel:**
1. Find "Apache" and click "Start" button
   - Wait until it shows "Running" in green
2. Find "MySQL" and click "Start" button
   - Wait until it shows "Running" in green

**Or start from Command Prompt (as Administrator):**

```cmd
cd C:\xampp\apache\bin
httpd.exe
```

Then open another Command Prompt and run:
```cmd
cd C:\xampp\mysql\bin
mysqld.exe
```

### Step 7: Create Database Using Command Prompt

In your Command Prompt window, run:

```cmd
cd C:\xampp\mysql\bin
mysql -u root
```

You should see the MySQL prompt: `mysql>`

Now copy and paste these commands one by one:

```sql
CREATE DATABASE todo_list;
USE todo_list;
```

Press Enter after each command.

Then exit MySQL:
```sql
EXIT;
```

### Step 8: Import Database Schema

**From Command Prompt (in the project directory):**

First, navigate to the project folder:
```cmd
cd C:\xampp\htdocs\adhilproject-2
```

Then import the schema:
```cmd
cd C:\xampp\mysql\bin
mysql -u root todo_list < "C:\xampp\htdocs\adhilproject-2\schema.sql"
```

When prompted for password, just press Enter (no password by default).

**Or use phpMyAdmin (Easier - No terminal needed):**

1. Open browser: `http://localhost/phpmyadmin`
2. Click "todo_list" database in left sidebar
3. Click "Import" tab
4. Click "Choose File"
5. Select: `C:\xampp\htdocs\adhilproject-2\schema.sql`
6. Click "Import" button
7. You should see "Import has been successfully finished"

### Step 9: Configure Database

**Using Notepad:**

```cmd
notepad C:\xampp\htdocs\adhilproject-2\config\database.php
```

Verify these lines exist:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'todo_list');
define('BASE_URL', 'http://localhost/adhilproject-2/public/');
```

If they look correct, save and close (Ctrl+S, then Ctrl+Q).

### Step 10: Enable mod_rewrite (Usually Pre-enabled)

**Check if already enabled:**
1. Open browser: `http://localhost`
2. If you see the XAMPP page, it's working
3. Try accessing: `http://localhost/adhilproject-2/public/`

**If you get 404 errors, enable mod_rewrite:**

```cmd
notepad C:\xampp\apache\conf\httpd.conf
```

Press Ctrl+F to search for: `rewrite_module`

You should find this line:
```
#LoadModule rewrite_module modules/mod_rewrite.so
```

Remove the `#` at the beginning so it looks like:
```
LoadModule rewrite_module modules/mod_rewrite.so
```

Save the file (Ctrl+S) and close (Ctrl+Q).

Then restart Apache:
1. Go to XAMPP Control Panel
2. Click "Stop" next to Apache
3. Wait 2 seconds
4. Click "Start" next to Apache

### Step 11: Access Your Application

Open your web browser and go to:

```
http://localhost/adhilproject-2/public/
```

You should see the Todo List dashboard! 🎉

---

## Common Commands Reference

### Navigate to XAMPP
```cmd
cd C:\xampp
```

### Navigate to Project
```cmd
cd C:\xampp\htdocs\adhilproject-2
```

### Start MySQL from Terminal
```cmd
cd C:\xampp\mysql\bin
mysql -u root
```

### List Databases
```cmd
mysql -u root -e "SHOW DATABASES;"
```

### Stop Apache from Terminal
```cmd
cd C:\xampp\apache\bin
httpd.exe -k stop
```

### Stop MySQL from Terminal
```cmd
cd C:\xampp\mysql\bin
mysqladmin -u root shutdown
```

### Check Project Files
```cmd
cd C:\xampp\htdocs\adhilproject-2
dir
```

### View Database Config
```cmd
type C:\xampp\htdocs\adhilproject-2\config\database.php
```

### View Schema File
```cmd
type C:\xampp\htdocs\adhilproject-2\schema.sql
```

---

## Troubleshooting Commands

### Test MySQL Connection
```cmd
cd C:\xampp\mysql\bin
mysql -u root -e "SELECT 1;"
```

**Expected result:** Shows `1` with no errors

### Check if Database Exists
```cmd
cd C:\xampp\mysql\bin
mysql -u root -e "SHOW DATABASES;"
```

**Expected result:** Lists `todo_list` database

### Check if Tables Exist
```cmd
cd C:\xampp\mysql\bin
mysql -u root todo_list -e "SHOW TABLES;"
```

**Expected result:** Lists tables (categories, todos, reminders)

### View All Database Contents
```cmd
cd C:\xampp\mysql\bin
mysql -u root todo_list
```

Then:
```sql
SHOW TABLES;
DESC categories;
DESC todos;
DESC reminders;
SELECT * FROM categories;
EXIT;
```

### Check Apache Status
```cmd
netstat -ano | findstr :80
```

**Expected result:** Shows what's using port 80

### Find XAMPP Control Panel
```cmd
cd C:\xampp
start xampp-control.exe
```

### Open Project Folder from Terminal
```cmd
cd C:\xampp\htdocs\adhilproject-2
start .
```

This opens Windows Explorer in the project folder.

---

## Full Installation Script (Copy & Paste)

**Save this as `install.bat` and double-click to run everything:**

```batch
@echo off
echo Starting Todo List Installation...
cd C:\xampp\htdocs
git clone https://github.com/salahudheen5216j/adhilproject-2.git
cd adhilproject-2
echo.
echo Project cloned successfully!
echo.
echo Opening XAMPP Control Panel...
echo Please start Apache and MySQL services
start C:\xampp\xampp-control.exe
echo.
pause
echo Starting database setup...
cd C:\xampp\mysql\bin
mysql -u root < "C:\xampp\htdocs\adhilproject-2\schema.sql"
echo.
echo Installation complete!
echo Open this URL in your browser:
echo http://localhost/adhilproject-2/public/
echo.
pause
```

---

## Step-by-Step Checklist ✅

- [ ] Installed Git
- [ ] Installed XAMPP in C:\xampp
- [ ] Opened Command Prompt
- [ ] Navigated to C:\xampp\htdocs
- [ ] Cloned project using git
- [ ] Started Apache and MySQL in XAMPP Control Panel
- [ ] Created database using `mysql -u root`
- [ ] Imported schema.sql
- [ ] Verified config/database.php settings
- [ ] Enabled mod_rewrite if needed
- [ ] Opened browser to http://localhost/adhilproject-2/public/
- [ ] Saw the Todo List dashboard ✅

---

## Getting Help

### If Database Connection Fails:

1. Check MySQL is running:
   ```cmd
   cd C:\xampp\mysql\bin
   mysql -u root
   ```
   Should show `mysql>` prompt

2. Check database exists:
   ```cmd
   mysql -u root -e "SHOW DATABASES;"
   ```
   Should list `todo_list`

3. Check database has tables:
   ```cmd
   mysql -u root todo_list -e "SHOW TABLES;"
   ```
   Should list: categories, todos, reminders

### If Website Shows 404:

1. Check Apache is running (green in XAMPP Panel)
2. Check .htaccess exists:
   ```cmd
   dir C:\xampp\htdocs\adhilproject-2\public\.htaccess
   ```
3. Enable mod_rewrite (see Step 10 above)

### If Port 80 is in Use:

1. Find what's using it:
   ```cmd
   netstat -ano | findstr :80
   ```

2. Stop it or change Apache port in httpd.conf

### Get Apache Version:
```cmd
C:\xampp\apache\bin\httpd.exe -v
```

### Get PHP Version:
```cmd
C:\xampp\php\php.exe -v
```

### Get MySQL Version:
```cmd
C:\xampp\mysql\bin\mysql.exe --version
```

---

## Useful Links

- XAMPP Download: https://www.apachefriends.org/
- Git Download: https://git-scm.com/
- Project GitHub: https://github.com/salahudheen5216j/adhilproject-2
- PHP Documentation: https://www.php.net/
- MySQL Documentation: https://dev.mysql.com/

---

## Next Steps

After installation:

1. **Create your first task** in the dashboard
2. **Set a reminder** for an upcoming date
3. **Mark tasks as complete** to track progress
4. **Explore categories** to organize your tasks
5. **Check statistics** to monitor productivity

---

**Happy task managing! 🚀**

For **GUI installation without terminal**, see: **[SETUP_WINDOWS.md](SETUP_WINDOWS.md)**

For **Linux installation**, see: **[SETUP_LINUX.md](SETUP_LINUX.md)**
