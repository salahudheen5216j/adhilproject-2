<?php

class Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Todos Methods
    public function getAllTodos() {
        $query = "SELECT t.*, c.name as category_name, c.color 
                  FROM todos t 
                  LEFT JOIN categories c ON t.category_id = c.id 
                  ORDER BY t.is_completed ASC, t.due_date ASC";
        
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTodoById($id) {
        $query = "SELECT t.*, c.name as category_name, c.color 
                  FROM todos t 
                  LEFT JOIN categories c ON t.category_id = c.id 
                  WHERE t.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }

    public function createTodo($title, $description, $category_id, $priority, $due_date, $reminder_date) {
        $query = "INSERT INTO todos (title, description, category_id, priority, due_date, reminder_date) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssisss', $title, $description, $category_id, $priority, $due_date, $reminder_date);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    public function updateTodo($id, $title, $description, $category_id, $priority, $due_date, $reminder_date, $is_completed) {
        $query = "UPDATE todos 
                  SET title = ?, description = ?, category_id = ?, priority = ?, due_date = ?, reminder_date = ?, is_completed = ?
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssisssii', $title, $description, $category_id, $priority, $due_date, $reminder_date, $is_completed, $id);
        
        return $stmt->execute();
    }

    public function deleteTodo($id) {
        $query = "DELETE FROM todos WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        
        return $stmt->execute();
    }

    public function toggleTodoComplete($id) {
        $query = "UPDATE todos SET is_completed = NOT is_completed WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        
        return $stmt->execute();
    }

    // Categories Methods
    public function getAllCategories() {
        $query = "SELECT * FROM categories ORDER BY name ASC";
        
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createCategory($name, $color) {
        $query = "INSERT INTO categories (name, color) VALUES (?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $name, $color);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    public function deleteCategory($id) {
        $query = "DELETE FROM categories WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        
        return $stmt->execute();
    }

    // Reminders Methods
    public function getPendingReminders() {
        $query = "SELECT r.*, t.title, t.due_date 
                  FROM reminders r 
                  JOIN todos t ON r.todo_id = t.id 
                  WHERE r.is_sent = FALSE AND r.reminder_time <= NOW()
                  ORDER BY r.reminder_time ASC";
        
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function markReminderSent($reminder_id) {
        $query = "UPDATE reminders SET is_sent = TRUE, sent_at = NOW() WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $reminder_id);
        
        return $stmt->execute();
    }

    public function createReminder($todo_id, $reminder_type, $reminder_time) {
        $query = "INSERT INTO reminders (todo_id, reminder_type, reminder_time) VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('iss', $todo_id, $reminder_type, $reminder_time);
        
        return $stmt->execute();
    }

    public function getTodoReminders($todo_id) {
        $query = "SELECT * FROM reminders WHERE todo_id = ? ORDER BY reminder_time DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $todo_id);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getUpcomingReminders($days = 7) {
        $query = "SELECT t.*, r.reminder_time, r.id as reminder_id
                  FROM reminders r
                  JOIN todos t ON r.todo_id = t.id
                  WHERE r.is_sent = FALSE 
                  AND r.reminder_time BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL ? DAY)
                  ORDER BY r.reminder_time ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $days);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_todos,
                    SUM(CASE WHEN is_completed = 1 THEN 1 ELSE 0 END) as completed_todos,
                    SUM(CASE WHEN is_completed = 0 THEN 1 ELSE 0 END) as pending_todos,
                    SUM(CASE WHEN is_completed = 0 AND due_date < NOW() THEN 1 ELSE 0 END) as overdue_todos
                  FROM todos";
        
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }
}
?>