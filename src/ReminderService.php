<?php

class ReminderService {
    private $database;
    private $notification_log = [];

    public function __construct(Database $database) {
        $this->database = $database;
    }

    /**
     * Check and send pending reminders
     */
    public function sendPendingReminders() {
        $reminders = $this->database->getPendingReminders();
        
        foreach ($reminders as $reminder) {
            $this->sendReminder($reminder);
        }
        
        return count($reminders);
    }

    /**
     * Send a single reminder
     */
    private function sendReminder($reminder) {
        $reminder_type = $reminder['reminder_type'];
        
        if ($reminder_type === 'notification' || $reminder_type === 'both') {
            $this->sendNotification($reminder);
        }
        
        if ($reminder_type === 'email' || $reminder_type === 'both') {
            $this->sendEmail($reminder);
        }
        
        // Mark as sent
        $this->database->markReminderSent($reminder['id']);
    }

    /**
     * Send notification (stored in session/file)
     */
    private function sendNotification($reminder) {
        $message = "Reminder: {$reminder['title']} is due!";
        $this->logNotification($message, $reminder);
        
        // Store in session for display
        if (!isset($_SESSION['notifications'])) {
            $_SESSION['notifications'] = [];
        }
        
        $_SESSION['notifications'][] = [
            'type' => 'reminder',
            'message' => $message,
            'todo_id' => $reminder['todo_id'],
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * Send email reminder (simulated)
     */
    private function sendEmail($reminder) {
        $subject = "Todo Reminder: {$reminder['title']}";
        $message = "Your task '{$reminder['title']}' is due at {$reminder['due_date']}.\n\nDon't forget!";
        
        // In production, use proper email service
        $this->logNotification($message, $reminder, 'email');
        
        // Simulated email sending (would use PHPMailer or similar in production)
        // mail($email, $subject, $message);
    }

    /**
     * Log notification to file
     */
    private function logNotification($message, $reminder, $type = 'notification') {
        $log_dir = __DIR__ . '/../logs';
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        
        $log_file = $log_dir . '/reminders.log';
        $log_entry = date('Y-m-d H:i:s') . " [" . strtoupper($type) . "] " . $message . "\n";
        
        file_put_contents($log_file, $log_entry, FILE_APPEND);
    }

    /**
     * Get upcoming reminders for dashboard
     */
    public function getUpcomingReminders($days = 7) {
        return $this->database->getUpcomingReminders($days);
    }
}
?>