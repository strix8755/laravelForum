document.addEventListener('DOMContentLoaded', function() {
    // Comment editing functionality
    document.querySelectorAll('.edit-comment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const contentElement = document.getElementById(`comment-content-${commentId}`);
            const formElement = document.getElementById(`comment-edit-form-${commentId}`);
            
            // Show the edit form and hide the content
            contentElement.classList.add('hidden');
            formElement.classList.remove('hidden');
        });
    });
    
    // Cancel edit button functionality
    document.querySelectorAll('.cancel-edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const formElement = this.closest('.comment-edit-form');
            const commentId = formElement.id.split('-').pop();
            const contentElement = document.getElementById(`comment-content-${commentId}`);
            
            // Hide the edit form and show the content
            formElement.classList.add('hidden');
            contentElement.classList.remove('hidden');
        });
    });
    
    // AJAX form submission for updating comments
    document.querySelectorAll('.update-comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const commentId = this.closest('.comment-edit-form').id.split('-').pop();
            const contentElement = document.getElementById(`comment-content-${commentId}`);
            const formElement = document.getElementById(`comment-edit-form-${commentId}`);
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the comment content and toggle visibility
                    contentElement.textContent = data.comment.content;
                    formElement.classList.add('hidden');
                    contentElement.classList.remove('hidden');
                    
                    // Show success notification
                    Toast.success('Comment updated successfully');
                } else {
                    Toast.error('Error updating comment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Toast.error('An error occurred');
            });
        });
    });
    
    // AJAX form submission for deleting comments
    document.querySelectorAll('.delete-comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to delete this comment?')) {
                return;
            }
            
            const commentElement = this.closest('.comment');
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'DELETE'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the comment from DOM with a fade out effect
                    commentElement.style.transition = 'opacity 0.3s ease';
                    commentElement.style.opacity = '0';
                    
                    setTimeout(() => {
                        commentElement.remove();
                        
                        // Show success notification
                        Toast.success('Comment deleted successfully');
                    }, 300);
                } else {
                    Toast.error('Error deleting comment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Toast.error('An error occurred');
            });
        });
    });
    
    // Reply toggling functionality
    document.querySelectorAll('.reply-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const replyForm = document.querySelector(`.reply-form-${commentId}`);
            replyForm.classList.toggle('hidden');
        });
    });
    
    // Cancel reply button functionality
    document.querySelectorAll('.cancel-reply-btn').forEach(button => {
        button.addEventListener('click', function() {
            const replyForm = this.closest('[class^="reply-form-"]');
            replyForm.classList.add('hidden');
        });
    });
});
