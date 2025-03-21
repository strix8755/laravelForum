<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some users if none exist
        if (User::count() === 0) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            
            User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            
            User::create([
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }
        
        $users = User::all();
        
        // Create example posts
        $posts = [
            [
                'title' => 'Welcome to our Community Forum!',
                'content' => "This is the first post in our community forum. Feel free to join the discussion and share your thoughts!\n\nHere are some community guidelines:\n- Be respectful to others\n- No spam or self-promotion\n- Use proper formatting for code snippets\n- Have fun and engage with others",
                'user_id' => $users->first()->id,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
            [
                'title' => 'What programming language should I learn first?',
                'content' => "I'm new to programming and trying to decide where to start. Should I learn JavaScript, Python, or something else? What are the pros and cons of each for beginners?",
                'user_id' => $users->random()->id,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'Best resources for learning web development in 2023',
                'content' => "I've compiled a list of the best resources I've found for learning web development this year:\n\n1. freeCodeCamp - Completely free curriculum\n2. The Odin Project - Full stack path\n3. MDN Web Docs - Best reference for HTML/CSS/JS\n4. Frontend Mentor - Practice with real-world projects\n\nWhat other resources would you add to this list?",
                'user_id' => $users->random()->id,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'title' => 'How to optimize database queries in Laravel',
                'content' => "I've noticed my Laravel application is running slowly, especially on pages with lots of database queries. What are some techniques to optimize database performance in Laravel?\n\nSo far I've tried:\n- Adding indexes to frequently queried columns\n- Using eager loading with with()\n- Implementing caching\n\nAny other tips would be appreciated!",
                'user_id' => $users->random()->id,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'title' => 'Share your home office setup!',
                'content' => "Working from home has become more common, so I thought it would be fun to share our home office setups!\n\nMy setup:\n- Standing desk from Fully\n- Ergonomic chair\n- 27\" dual monitors\n- Mechanical keyboard\n- Logitech MX Master mouse\n\nWhat's your setup like? Any recommendations for must-have items?",
                'user_id' => $users->random()->id,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
        ];
        
        // Create posts and add comments and votes
        foreach ($posts as $postData) {
            $post = Post::create($postData);
            
            // Add 2-5 comments per post
            $commentCount = rand(2, 5);
            for ($i = 0; $i < $commentCount; $i++) {
                $comment = Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                    'content' => $this->getRandomComment(),
                    'created_at' => now()->subDays(rand(0, 2))->subHours(rand(1, 23)),
                    'updated_at' => now()->subDays(rand(0, 2))->subHours(rand(1, 23)),
                ]);
                
                // 50% chance to add a reply to this comment
                if (rand(0, 1) === 1) {
                    Comment::create([
                        'post_id' => $post->id,
                        'user_id' => $users->random()->id,
                        'parent_id' => $comment->id,
                        'content' => $this->getRandomReply(),
                        'created_at' => $comment->created_at->addHours(rand(1, 5)),
                        'updated_at' => $comment->created_at->addHours(rand(1, 5)),
                    ]);
                }
            }
            
            // Add random votes
            foreach ($users as $user) {
                // 70% chance to vote on a post
                if (rand(1, 10) <= 7) {
                    $vote = rand(0, 1) ? 1 : -1; // Randomly upvote or downvote
                    Vote::create([
                        'user_id' => $user->id,
                        'votable_id' => $post->id,
                        'votable_type' => Post::class,
                        'vote' => $vote,
                    ]);
                }
            }
        }
    }
    
    /**
     * Get a random comment for seeding
     */
    private function getRandomComment(): string
    {
        $comments = [
            "This is really interesting. Thanks for sharing!",
            "I've been thinking about this topic recently too. Great post!",
            "I disagree with some points, but overall this is a good discussion starter.",
            "Has anyone else experienced similar issues? I'd love to hear more perspectives.",
            "This is exactly what I needed to read today. Very helpful information.",
            "I've bookmarked this for future reference. Really valuable content here.",
            "Could you elaborate more on the second point? I'm not sure I fully understand.",
            "I tried this approach last week and it worked perfectly. Highly recommend!",
            "This reminds me of an article I read recently that said something similar.",
            "I think there are some alternative approaches worth considering as well."
        ];
        
        return $comments[array_rand($comments)];
    }
    
    /**
     * Get a random reply for seeding
     */
    private function getRandomReply(): string
    {
        $replies = [
            "Good point! I hadn't thought about it that way.",
            "I agree with what you're saying. Very insightful comment.",
            "Let me share my experience with this as well...",
            "Thanks for your perspective! That makes a lot of sense.",
            "I had a similar experience and found that...",
            "Have you tried looking into this alternative solution?",
            "That's an interesting approach. How did it work out for you?",
            "I see what you mean, but have you considered this aspect?",
            "Thanks for sharing your experience! Very helpful.",
            "I'll definitely try your suggestion. Thanks!"
        ];
        
        return $replies[array_rand($replies)];
    }
}
