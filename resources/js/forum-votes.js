document.addEventListener('DOMContentLoaded', function() {
    // Find all vote buttons
    const voteButtons = document.querySelectorAll('.vote-button');
    
    voteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get vote data from button attributes
            const postId = this.getAttribute('data-post-id');
            const voteType = this.getAttribute('data-vote');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Send vote request
            fetch(`/posts/${postId}/vote`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    vote: parseInt(voteType)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update vote count display
                    const scoreElement = document.querySelector(`.vote-score[data-post-id="${postId}"]`);
                    scoreElement.textContent = data.score;
                    
                    // Update button states
                    const upvoteButton = document.querySelector(`.upvote-button[data-post-id="${postId}"]`);
                    const downvoteButton = document.querySelector(`.downvote-button[data-post-id="${postId}"]`);
                    
                    // Get user's previous vote
                    const previousVote = button.classList.contains('voted') ? parseInt(voteType) : 0;
                    
                    // Reset button states
                    upvoteButton.classList.remove('voted', 'text-green-600', 'dark:text-green-400');
                    downvoteButton.classList.remove('voted', 'text-red-600', 'dark:text-red-400');
                    
                    // If the same button was clicked, it toggles off
                    if (previousVote === parseInt(voteType)) {
                        // We already removed the classes, so do nothing
                    } else {
                        // Apply voted state to the clicked button
                        if (voteType === '1') {
                            upvoteButton.classList.add('voted', 'text-green-600', 'dark:text-green-400');
                        } else if (voteType === '-1') {
                            downvoteButton.classList.add('voted', 'text-red-600', 'dark:text-red-400');
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error voting:', error);
            });
        });
    });
});
