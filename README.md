# Todo List with Reminders 📋

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

## Requirements

- PHP 7.2 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled (or Nginx with rewrite rules)
- Web server (XAMPP, WAMP, LAMP, etc.)

## Installation

### Step 1: Download/Clone the Project

```bash
cd C:\xampp\htdocs  # Windows
# or
cd /var/www/html    # Linux

git clone https://github.com/salahudheen5216j/adhilproject-2.git
cd adhilproject-2
```

### Step 2: Create Database

**Using Command Line:**
```bash
mysql -u root -p
CREATE DATABASE todo_list;
USE todo_list;
```

**Using phpMyAdmin (Easier):**
1. Open `http://localhost/phpmyadmin`
2. Click "New" and create database named `todo_list`

### Step 3: Import Database Schema

**Using Command Line:**
```bash
mysql -u root -p todo_list < schema.sql
```

**Using phpMyAdmin:**
1. Select `todo_list` database
2. Go to "Import" tab
3. Select `schema.sql` file
4. Click "Import"

### Step 4: Configure Database Connection

Edit `config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');              // Leave empty if no password
define('DB_NAME', 'todo_list');
define('BASE_URL', 'http://localhost/adhilproject-2/public/');
```

### Step 5: Access the Application

Open your browser and go to:
```
http://localhost/adhilproject-2/public/
```

## Usage

### Creating a Task

1. Fill in the task title (required)
2. Add optional description
3. Select a category and priority
4. Set a due date (optional)
5. Set a reminder date/time (optional)
6. Click "+ Add Task"

### Managing Tasks

- **Complete Task**: Click the circle checkbox next to a task
- **Edit Task**: Click the "Edit" button on a task card
- **Delete Task**: Click the "Delete" button (with confirmation)

### Reminders

- Set a reminder date/time for any task
- The system will show reminders 24/7
- Completed reminders are automatically marked as sent
- View upcoming reminders in the dashboard widget

### Dashboard

- **Statistics**: See total, completed, pending, and overdue task counts
- **Upcoming Reminders**: View tasks with upcoming reminders
- **Color Coding**: Tasks are colored by priority and category

## Project Structure

```
adhilproject-2/
├── config/
│   ├── database.php          # Database configuration
│   └── .htaccess             # Security for config directory
├── src/
│   ├── Database.php          # Database operations class
│   ├── ReminderService.php   # Reminder handling logic
│   └── Validator.php         # Input validation
├── public/
│   ├── index.php             # Main dashboard
│   ├── edit.php              # Task editing page
│   ├── css/
│   │   └── style.css         # Styling
│   └── js/
│       └── script.js         # Client-side functionality
├── logs/
│   └── reminders.log         # Reminder activity log
├── .htaccess                 # URL rewriting
├── schema.sql                # Database schema
└── README.md                 # This file
```

## Database Schema

### categories Table
- id, name, color, created_at

### todos Table
- id, title, description, category_id, priority, due_date, reminder_date, reminder_sent, is_completed, created_at, updated_at

### reminders Table
- id, todo_id, reminder_type, reminder_time, is_sent, sent_at, created_at

## Features in Detail

### Smart Reminders
- Set reminders for individual tasks
- Multiple reminder types (notification, email, or both)
- Automatic reminder detection and notification
- View reminder history and logs

### Task Organization
- 5 pre-configured categories
- 3 priority levels
- Color-coded by category and priority
- Due date tracking
- Completion status

### Statistics
- Total task count
- Completed vs pending ratio
- Overdue task tracking
- Quick stats overview on dashboard

## Security Features

- ✅ SQL injection prevention with prepared statements
- ✅ XSS protection with htmlspecialchars()
- ✅ CSRF protection ready
- ✅ Input validation
- ✅ Directory access protection via .htaccess

## Troubleshooting

### Database Connection Error
**Problem:** "Connection failed"
**Solution:**
1. Ensure MySQL is running
2. Check credentials in `config/database.php`
3. Verify database `todo_list` exists

### 404 Errors
**Problem:** Pages not found
**Solution:**
1. Check mod_rewrite is enabled
2. Verify .htaccess files exist
3. Restart Apache

### mod_rewrite Not Working
**Solution:**
1. Check Apache httpd.conf for `LoadModule rewrite_module`
2. Uncomment if needed
3. Restart Apache

### Permission Issues
**Solution:**
1. Run XAMPP as Administrator
2. Set proper folder permissions

## Future Enhancements

- [ ] User authentication & accounts
- [ ] Email reminders (PHPMailer integration)
- [ ] Recurring tasks
- [ ] Task templates
- [ ] File attachments
- [ ] Task comments/notes
- [ ] Sharing tasks with others
- [ ] Dark mode
- [ ] Mobile app
- [ ] Calendar view
- [ ] Export to CSV/PDF
- [ ] Search functionality
- [ ] Advanced filtering

## Browser Support

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers

## Performance

- Fast page load times
- Optimized database queries
- Indexed database fields
- Responsive design
- Minimal dependencies

## License

MIT License - Feel free to use and modify

## Support & Feedback

For issues, questions, or suggestions:
1. Check the Troubleshooting section
2. Open an issue on GitHub
3. Review the code comments for implementation details

## Quick Tips

- 💡 Set reminders 1 hour before important deadlines
- 🏃 Use the High priority for urgent tasks
- 📊 Check statistics to track productivity
- 🔄 Review completed tasks for motivation
- 📱 Works great on mobile for on-the-go task management

---

**Happy task managing! 🚀**

*Built with ❤️ using PHP, MySQL, HTML, CSS, and JavaScript*