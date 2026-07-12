<?php

class Validator {
    private $errors = [];

    public function validateTodo($title, $category_id, $priority) {
        $this->errors = [];
        
        // Validate title
        if (empty($title)) {
            $this->errors[] = 'Title is required';
        } elseif (strlen($title) > 255) {
            $this->errors[] = 'Title must be less than 255 characters';
        }
        
        // Validate category
        if (!empty($category_id) && !is_numeric($category_id)) {
            $this->errors[] = 'Invalid category selected';
        }
        
        // Validate priority
        if (!in_array($priority, ['low', 'medium', 'high'])) {
            $this->errors[] = 'Invalid priority level';
        }
        
        return count($this->errors) === 0;
    }

    public function validateCategory($name) {
        $this->errors = [];
        
        if (empty($name)) {
            $this->errors[] = 'Category name is required';
        } elseif (strlen($name) > 100) {
            $this->errors[] = 'Category name must be less than 100 characters';
        }
        
        return count($this->errors) === 0;
    }

    public function validateDateTime($date_string) {
        if (empty($date_string)) {
            return true; // Optional field
        }
        
        $date = DateTime::createFromFormat('Y-m-d\TH:i', $date_string);
        return $date !== false;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return count($this->errors) > 0;
    }
}
?>