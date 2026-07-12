// Auto-close alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + Enter to submit form
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            const form = document.querySelector('.todo-form');
            if (form) {
                form.submit();
            }
        }
    });

    // Set default reminder date to 1 hour before due date
    const dueDateInput = document.getElementById('due_date');
    const reminderInput = document.getElementById('reminder_date');

    if (dueDateInput) {
        dueDateInput.addEventListener('change', function() {
            if (this.value && !reminderInput.value) {
                const dueDate = new Date(this.value);
                const reminderDate = new Date(dueDate.getTime() - 60 * 60 * 1000); // 1 hour before
                
                const year = reminderDate.getFullYear();
                const month = String(reminderDate.getMonth() + 1).padStart(2, '0');
                const day = String(reminderDate.getDate()).padStart(2, '0');
                const hours = String(reminderDate.getHours()).padStart(2, '0');
                const minutes = String(reminderDate.getMinutes()).padStart(2, '0');
                
                reminderInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        });
    }
});

// Utility function to format date
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

// Utility function to check if date is overdue
function isOverdue(dateString) {
    return new Date(dateString) < new Date();
}

// Add visual indicators for overdue tasks
function updateOverdueIndicators() {
    const badges = document.querySelectorAll('.due-date-badge');
    badges.forEach(badge => {
        const dateText = badge.textContent;
        const match = dateText.match(/\d{4}-\d{2}-\d{2}/);
        if (match && isOverdue(match[0])) {
            badge.style.backgroundColor = '#e74c3c';
            badge.style.color = 'white';
        }
    });
}

updateOverdueIndicators();