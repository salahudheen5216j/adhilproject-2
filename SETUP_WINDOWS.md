# Todo List with Reminders 📋 - Windows Setup Guide

A beautiful, feature-rich todo list application built with PHP and MySQL that helps you organize your tasks and never miss important deadlines with smart reminders.

## Features ✨

- **Task Management**
  - ✅ Create, edit, and delete tasks
  - 📝 Add detailed descriptions to tasks
  - 🏷️ Categorize tasks (Work, Personal, Shopping, Health, etc.)
  - ⭐ Set task priority (Low, Medium, High)
  - ✓ Mark tasks as completed

- **Due Dates & Reminders**
  - 📅 Set due dates for tasks
  - 🔔 Create reminders before due dates
  - 📨 Automatic reminder notifications
  - 📊 Track overdue tasks
  - 🏃 Get upcoming reminders dashboard

- **Dashboard & Analytics**
  - 📈 Statistics showing total, completed, pending, and overdue tasks
  - 🔔 Upcoming reminders widget
  - 📱 Responsive design for mobile and desktop
  - 🎨 Beautiful modern UI with smooth animations

- **User Experience**
  - 🌈 Color-coded categories and priorities
  - ⚡ Quick task toggling
  - 🔍 Easy task filtering
  - 💾 Persistent storage
  - 🚀 Fast and responsive interface

## Requirements for Windows

- PHP 7.2 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled
- XAMPP or WAMP (recommended)

## Windows Installation Guide

### Step 1: Install XAMPP

1. Download XAMPP from: https://www.apachefriends.org/download.html
2. Run the installer
3. Install to default location: `C:\xampp`
4. Choose Apache, MySQL, and PHP components
5. Complete the installation

### Step 2: Start Services

1. Open **XAMPP Control Panel** (Run as Administrator)
2. Click **Start** next to:
   - Apache
   - MySQL
3. Wait for both to show as running (green indicators)

### Step 3: Clone/Download Project

**Using Git Bash:**
```cmd
cd C:\xampp\htdocs
git clone https://github.com/salahudheen5216j/adhilproject-2.git
cd adhilproject-2
```

**Or manually:**
1. Download the project as ZIP
2. Extract to `C:\xampp\htdocs\adhilproject-2`

### Step 4: Create Database

**Option A: Using phpMyAdmin (GUI - Easier)**

1. Open browser: `http://localhost/phpmyadmin`
2. Click on "New" in the left sidebar
3. Enter database name: `todo_list`
4. Click "Create"

**Option B: Using Command Prompt**

```cmd
cd C:\xampp\mysql\bin
mysql -u root -p
```

Then paste:
```sql
CREATE DATABASE todo_list;
USE todo_list;
```

Press Enter and type `exit` to close MySQL.

### Step 5: Import Database Schema

**Option A: Using phpMyAdmin (Easier)**

1. Go to: `http://localhost/phpmyadmin`
2. Click on the `todo_list` database in the left sidebar
3. Click on "Import" tab
4. Click "Choose File" and select `C:\xampp\htdocs\adhilproject-2\schema.sql`
5. Click "Import" button

**Option B: Using Command Prompt**

```cmd
cd C:\xampp\mysql\bin
mysql -u root -p todo_list < "C:\xampp\htdocs\adhilproject-2\schema.sql"
```

When prompted for password, leave it empty (just press Enter) and press Enter.

### Step 6: Configure Database Connection

1. Open: `C:\xampp\htdocs\adhilproject-2\config\database.php`
2. Verify the settings:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');                          // Leave empty if no password
define('DB_NAME', 'todo_list');
define('BASE_URL', 'http://localhost/adhilproject-2/public/');
```

3. Save the file

### Step 7: Enable mod_rewrite (Usually Pre-enabled)

**If `.htaccess` doesn't work:**

1. Open: `C:\xampp\apache\conf\httpd.conf` with Notepad
2. Find the line: `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Remove the `#` at the beginning to uncomment it
4. Save the file
5. Go back to XAMPP Control Panel
6. Click "Stop" next to Apache
7. Wait 2 seconds, then click "Start" again

### Step 8: Access the Application

Open your web browser and go to:

```
http://localhost/adhilproject-2/public/
```

You should see the Todo List dashboard! 🎉

## Usage

### Creating a Task

1. Fill in the task title (required)
2. Add optional description
3. Select a category and priority
4. Set a due date (optional)
5. Set a reminder date/time (optional)
6. Click "➕ Add Task"

### Managing Tasks

- **Complete Task**: Click the circle checkbox next to a task
- **Edit Task**: Click the "Edit" button on a task card
- **Delete Task**: Click the "Delete" button (with confirmation)

### Reminders

- Set a reminder date/time for any task
- The system will show reminders automatically
- Completed reminders are marked as sent
- View upcoming reminders in the dashboard widget

### Dashboard

- **Statistics**: See total, completed, pending, and overdue task counts
- **Upcoming Reminders**: View tasks with upcoming reminders
- **Color Coding**: Tasks are colored by priority and category

## Project Structure

```
C:\xampp\htdocs\adhilproject-2\
├── config\
│   ├── database.php          # Database configuration
│   └── .htaccess             # Security for config directory
├── src\
│   ├── Database.php          # Database operations class
│   ├── ReminderService.php   # Reminder handling logic
│   └── Validator.php         # Input validation
├── public\
│   ├── index.php             # Main dashboard
│   ├── edit.php              # Task editing page
│   ├── .htaccess             # URL rewriting
│   ├── css\
│   │   └── style.css         # Styling
│   └── js\
│       └── script.js         # Client-side functionality
├── logs\
│   └── reminders.log         # Reminder activity log
├── schema.sql                # Database schema
└── README.md                 # Main documentation
```

## Database Schema

### categories Table
- id, name, color, created_at

### todos Table
- id, title, description, category_id, priority, due_date, reminder_date, reminder_sent, is_completed, created_at, updated_at

### reminders Table
- id, todo_id, reminder_type, reminder_time, is_sent, sent_at, created_at

## Troubleshooting for Windows

### ❌ 404 Error on Short Links

**Problem:** Pages not found

**Solution:**
1. Check that `.htaccess` is in the `public` folder
2. Enable mod_rewrite in Apache configuration
3. Verify BASE_URL in `config/database.php` matches your setup
4. Restart Apache after changes

### ❌ Database Connection Error

**Problem:** "Connection failed"

**Solutions:**
1. Check if MySQL is running in XAMPP Control Panel (should be green)
2. Verify credentials in `config/database.php`
3. Make sure database `todo_list` exists:
   ```cmd
   cd C:\xampp\mysql\bin
   mysql -u root -p
   SHOW DATABASES;
   ```
4. If database doesn't exist, create it using phpMyAdmin

### ❌ "Class not found" Error

**Solution:**
1. Make sure all files are in correct folders
2. Check file paths use forward slashes `/` not backslashes `\`
3. Clear browser cache (Ctrl+Shift+Delete)
4. Restart Apache

### ❌ "Permission Denied" Error

**Solution:**
1. Right-click XAMPP Control Panel icon
2. Select "Run as Administrator"
3. For folder permissions: Right-click folder → Properties → Security

### ❌ Port 80 Already in Use

**Problem:** Apache won't start because port 80 is in use

**Solution:**
1. Open XAMPP Control Panel
2. Click "Config" button next to Apache
3. Click "Apache (httpd.conf)"
4. Find: `Listen 80`
5. Change to: `Listen 8080`
6. Save and restart Apache
7. Access the app at: `http://localhost:8080/adhilproject-2/public/`

### ❌ phpMyAdmin Not Working

**Solution:**
1. Make sure Apache is running
2. Go to: `http://localhost/phpmyadmin`
3. If still not working, restart both Apache and MySQL

### ❌ Database Import Failed

**Problem:** "Access denied" error when importing

**Solutions:**
1. Make sure you're logged in as root (no password by default)
2. Use phpMyAdmin instead of command line
3. Check that the `schema.sql` file exists in the correct location
4. Try importing a smaller SQL file first

## Windows File Locations Reference

| Component | Location |
|-----------|----------|
| XAMPP Installation | `C:\xampp` |
| Project Folder | `C:\xampp\htdocs\adhilproject-2` |
| Database Config | `C:\xampp\htdocs\adhilproject-2\config\database.php` |
| Apache Config | `C:\xampp\apache\conf\httpd.conf` |
| MySQL Binary | `C:\xampp\mysql\bin` |
| phpMyAdmin | `http://localhost/phpmyadmin` |
| XAMPP Control Panel | `C:\xampp\xampp-control.exe` |

## Quick Start Checklist ✅

- [ ] Downloaded and installed XAMPP
- [ ] Started Apache and MySQL services
- [ ] Cloned/downloaded the project to `C:\xampp\htdocs\adhilproject-2`
- [ ] Created database `todo_list` via phpMyAdmin
- [ ] Imported `schema.sql` into the database
- [ ] Updated `config/database.php` with correct credentials
- [ ] Verified mod_rewrite is enabled in Apache
- [ ] Accessed `http://localhost/adhilproject-2/public/` in browser
- [ ] Created your first task ✅

## Common Windows Issues & Solutions

### Issue: XAMPP won't start
- Make sure you're running it as Administrator
- Check Windows Firewall isn't blocking Apache

### Issue: Can't access localhost
- Make sure Apache is running (green indicator in XAMPP)
- Try: `http://localhost` to test Apache

### Issue: MySQL keeps stopping
- Close any other programs using port 3306
- Check your C: drive has enough space (at least 100MB free)
- Restart XAMPP Control Panel

## Security Features

- ✅ SQL injection prevention with prepared statements
- ✅ XSS protection with htmlspecialchars()
- ✅ CSRF protection ready
- ✅ Input validation
- ✅ Directory access protection via .htaccess

## Future Enhancements

- [ ] User authentication & accounts
- [ ] Email reminders (PHPMailer integration)
- [ ] Recurring tasks
- [ ] Task templates
- [ ] File attachments
- [ ] Task comments/notes
- [ ] Sharing tasks with others
- [ ] Dark mode
- [ ] Calendar view
- [ ] Export to CSV/PDF
- [ ] Search functionality

## Browser Support

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Internet Explorer 11+

## Performance

- Fast page load times
- Optimized database queries
- Indexed database fields
- Responsive design
- Minimal dependencies

## License

MIT License - Feel free to use and modify

## Support & Feedback

For issues or questions:
1. Check the Troubleshooting section above
2. Open an issue on GitHub
3. Review the code comments for implementation details

## Quick Tips 💡

- 💡 Set reminders 1 hour before important deadlines
- 🏃 Use the High priority for urgent tasks
- 📊 Check statistics to track productivity
- 🔄 Review completed tasks for motivation
- 📱 Works great on mobile for on-the-go task management

---

**Happy task managing! 🚀**

*Built with ❤️ using PHP, MySQL, HTML, CSS, and JavaScript*

For **Linux setup instructions**, see `SETUP_LINUX.md`
