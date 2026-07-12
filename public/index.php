<?php
session_start();

require_once '../config/database.php';
require_once '../src/Database.php';
require_once '../src/ReminderService.php';
require_once '../src/Validator.php';

$database = new Database($conn);
$reminderService = new ReminderService($database);
$validator = new Validator();

// Check pending reminders
$reminderService->sendPendingReminders();

// Get statistics
$stats = $database->getStatistics();
$categories = $database->getAllCategories();
$todos = $database->getAllTodos();
$upcoming_reminders = $reminderService->getUpcomingReminders();

// Handle form submissions
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add_todo') {
            $title = htmlspecialchars($_POST['title'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');
            $category_id = $_POST['category_id'] ?? null;
            $priority = $_POST['priority'] ?? 'medium';
            $due_date = $_POST['due_date'] ?? '';
            $reminder_date = $_POST['reminder_date'] ?? '';
            
            if ($validator->validateTodo($title, $category_id, $priority)) {
                $todo_id = $database->createTodo($title, $description, $category_id, $priority, $due_date, $reminder_date);
                if ($todo_id) {
                    $success_message = 'Todo created successfully!';
                    $todos = $database->getAllTodos();
                } else {
                    $error_message = 'Failed to create todo';
                }
            } else {
                $error_message = implode(', ', $validator->getErrors());
            }
        } elseif ($_POST['action'] === 'update_todo') {
            $id = $_POST['id'] ?? null;
            $title = htmlspecialchars($_POST['title'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');
            $category_id = $_POST['category_id'] ?? null;
            $priority = $_POST['priority'] ?? 'medium';
            $due_date = $_POST['due_date'] ?? '';
            $reminder_date = $_POST['reminder_date'] ?? '';
            $is_completed = $_POST['is_completed'] ?? 0;
            
            if ($validator->validateTodo($title, $category_id, $priority)) {
                if ($database->updateTodo($id, $title, $description, $category_id, $priority, $due_date, $reminder_date, $is_completed)) {
                    $success_message = 'Todo updated successfully!';
                    $todos = $database->getAllTodos();
                } else {
                    $error_message = 'Failed to update todo';
                }
            } else {
                $error_message = implode(', ', $validator->getErrors());
            }
        } elseif ($_POST['action'] === 'toggle_todo') {
            $id = $_POST['id'] ?? null;
            if ($database->toggleTodoComplete($id)) {
                $success_message = 'Todo status updated!';
                $todos = $database->getAllTodos();
            }
        } elseif ($_POST['action'] === 'delete_todo') {
            $id = $_POST['id'] ?? null;
            if ($database->deleteTodo($id)) {
                $success_message = 'Todo deleted successfully!';
                $todos = $database->getAllTodos();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List with Reminders</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>📋 My Todo List</h1>
            <p class="subtitle">Organize, prioritize, and get reminders for your tasks</p>
        </header>

        <?php if ($success_message): ?>
            <div class="alert alert-success">✓ <?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-error">✗ <?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="dashboard">
            <!-- Statistics -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total_todos']; ?></div>
                    <div class="stat-label">Total Tasks</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['completed_todos']; ?></div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['pending_todos']; ?></div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="stat-card stat-danger">
                    <div class="stat-number"><?php echo $stats['overdue_todos']; ?></div>
                    <div class="stat-label">Overdue</div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Add Todo Form -->
                <div class="section">
                    <h2>Add New Task</h2>
                    <form method="POST" class="todo-form">
                        <input type="hidden" name="action" value="add_todo">
                        
                        <div class="form-group">
                            <label for="title">Task Title *</label>
                            <input type="text" id="title" name="title" placeholder="Enter task title" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="Add details about your task" rows="3"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select id="category_id" name="category_id">
                                    <option value="">Select a category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select id="priority" name="priority">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="due_date">Due Date</label>
                                <input type="datetime-local" id="due_date" name="due_date">
                            </div>

                            <div class="form-group">
                                <label for="reminder_date">Reminder Date</label>
                                <input type="datetime-local" id="reminder_date" name="reminder_date">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">+ Add Task</button>
                    </form>
                </div>

                <!-- Upcoming Reminders -->
                <?php if (!empty($upcoming_reminders)): ?>
                    <div class="section reminders-section">
                        <h2>🔔 Upcoming Reminders</h2>
                        <div class="reminders-list">
                            <?php foreach ($upcoming_reminders as $reminder): ?>
                                <div class="reminder-item">
                                    <div class="reminder-content">
                                        <h4><?php echo $reminder['title']; ?></h4>
                                        <p>Reminder: <?php echo date('M d, Y H:i', strtotime($reminder['reminder_time'])); ?></p>
                                    </div>
                                    <span class="reminder-priority priority-<?php echo $reminder['priority']; ?>">
                                        <?php echo ucfirst($reminder['priority']); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Todos List -->
                <div class="section">
                    <h2>Your Tasks</h2>
                    <?php if (empty($todos)): ?>
                        <p class="empty-state">No tasks yet. Create your first task above! 🏃</p>
                    <?php else: ?>
                        <div class="todos-container">
                            <?php foreach ($todos as $todo): ?>
                                <div class="todo-card <?php echo $todo['is_completed'] ? 'completed' : ''; ?>">
                                    <form method="POST" class="todo-card-form">
                                        <input type="hidden" name="action" value="toggle_todo">
                                        <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                                        <button type="submit" class="checkbox-btn">
                                            <?php echo $todo['is_completed'] ? '✓' : ''; ?>
                                        </button>
                                    </form>

                                    <div class="todo-content">
                                        <h3 class="todo-title"><?php echo $todo['title']; ?></h3>
                                        <?php if (!empty($todo['description'])): ?>
                                            <p class="todo-description"><?php echo $todo['description']; ?></p>
                                        <?php endif; ?>
                                        
                                        <div class="todo-meta">
                                            <?php if (!empty($todo['category_name'])): ?>
                                                <span class="badge category-badge" style="background-color: <?php echo $todo['color']; ?>">
                                                    <?php echo $todo['category_name']; ?>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <span class="badge priority-badge priority-<?php echo $todo['priority']; ?>">
                                                <?php echo ucfirst($todo['priority']); ?>
                                            </span>
                                            
                                            <?php if (!empty($todo['due_date'])): ?>
                                                <span class="badge due-date-badge">
                                                    📅 <?php echo date('M d, Y', strtotime($todo['due_date'])); ?>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($todo['reminder_date'])): ?>
                                                <span class="badge reminder-badge">
                                                    🔔 <?php echo date('M d, Y H:i', strtotime($todo['reminder_date'])); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="todo-actions">
                                        <a href="edit.php?id=<?php echo $todo['id']; ?>" class="btn btn-small btn-info">Edit</a>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="action" value="delete_todo">
                                            <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                                            <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>