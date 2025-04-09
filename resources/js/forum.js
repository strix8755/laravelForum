// Vote handling for forum posts and comments
document.addEventListener('DOMContentLoaded', function() {
    // Handle voting actions
    document.querySelectorAll('.vote-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const type = this.dataset.type; // 'post' or 'comment'
            const id = this.dataset.id;
            const vote = this.dataset.vote; // 1 for upvote, -1 for downvote
            const url = type === 'post' 
                ? `/posts/${id}/vote` 
                : `/comments/${id}/vote`;
            
            // Send AJAX request
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ vote: vote })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the score display
                    const scoreElement = document.querySelector(`#score-${type}-${id}`);
                    if (scoreElement) {
                        scoreElement.textContent = data.score;
                        
                        // Update colors based on score
                        if (data.score > 0) {
                            scoreElement.classList.add('text-green-600', 'dark:text-green-400');
                            scoreElement.classList.remove('text-red-600', 'dark:text-red-400', 'text-gray-600', 'dark:text-gray-400');
                        } else if (data.score < 0) {
                            scoreElement.classList.add('text-red-600', 'dark:text-red-400');
                            scoreElement.classList.remove('text-green-600', 'dark:text-green-400', 'text-gray-600', 'dark:text-gray-400');
                        } else {
                            scoreElement.classList.add('text-gray-600', 'dark:text-gray-400');
                            scoreElement.classList.remove('text-green-600', 'dark:text-green-400', 'text-red-600', 'dark:text-red-400');
                        }
                    }
                    
                    // Toggle active state for buttons
                    const upvoteButton = document.querySelector(`#upvote-${type}-${id}`);
                    const downvoteButton = document.querySelector(`#downvote-${type}-${id}`);
                    
                    // You'd need a way to know if the vote was added or removed
                    // For simplicity, we'll just toggle based on data from the server
                    updateButtonState(upvoteButton, downvoteButton, data.userVote);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
    
    function updateButtonState(upButton, downButton, userVote) {
        if (upButton && downButton) {
            // Reset both buttons
            upButton.classList.remove('text-green-600', 'dark:text-green-400');
            downButton.classList.remove('text-red-600', 'dark:text-red-400');
            
            // Set active state based on user's vote
            if (userVote === 1) {
                upButton.classList.add('text-green-600', 'dark:text-green-400');
            } else if (userVote === -1) {
                downButton.classList.add('text-red-600', 'dark:text-red-400');
            }
        }
    }
});
