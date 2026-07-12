<?php
session_start();

require_once '../config/database.php';
require_once '../src/Database.php';
require_once '../src/Validator.php';

$database = new Database($conn);
$validator = new Validator();

$todo_id = $_GET['id'] ?? null;
if (!$todo_id) {
    header('Location: index.php');
    exit;
}

$todo = $database->getTodoById($todo_id);
if (!$todo) {
    $_SESSION['error'] = 'Todo not found';
    header('Location: index.php');
    exit;
}

$categories = $database->getAllCategories();
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');
    $category_id = $_POST['category_id'] ?? null;
    $priority = $_POST['priority'] ?? 'medium';
    $due_date = $_POST['due_date'] ?? '';
    $reminder_date = $_POST['reminder_date'] ?? '';
    $is_completed = isset($_POST['is_completed']) ? 1 : 0;
    
    if ($validator->validateTodo($title, $category_id, $priority)) {
        if ($database->updateTodo($todo_id, $title, $description, $category_id, $priority, $due_date, $reminder_date, $is_completed)) {
            $success_message = 'Todo updated successfully!';
            $todo = $database->getTodoById($todo_id);
        }
    } else {
        $error_message = implode(', ', $validator->getErrors());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Todo - Todo List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <a href="index.php" class="back-link">← Back to Todos</a>
            <h1>✏️ Edit Task</h1>
        </header>

        <?php if ($success_message): ?>
            <div class="alert alert-success">✓ <?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-error">✗ <?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="edit-form-container">
            <form method="POST" class="todo-form">
                <div class="form-group">
                    <label for="title">Task Title *</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($todo['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($todo['description']); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id">
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $todo['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo $cat['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority">
                            <option value="low" <?php echo ($todo['priority'] == 'low') ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?php echo ($todo['priority'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?php echo ($todo['priority'] == 'high') ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="datetime-local" id="due_date" name="due_date" value="<?php echo $todo['due_date'] ? date('Y-m-d\TH:i', strtotime($todo['due_date'])) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="reminder_date">Reminder Date</label>
                        <input type="datetime-local" id="reminder_date" name="reminder_date" value="<?php echo $todo['reminder_date'] ? date('Y-m-d\TH:i', strtotime($todo['reminder_date'])) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_completed" <?php echo $todo['is_completed'] ? 'checked' : ''; ?>>
                        Mark as completed
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>