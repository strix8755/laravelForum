<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        // Check if specific posts already exist
        if (!Post::where('title', 'Welcome to our Forum!')->exists()) {
            // Create example posts
            $posts = [
                [
                    'title' => 'Welcome to our Forum!',
                    'content' => 'This is the official welcome post. Feel free to introduce yourself in the comments!',
                    'user_id' => $users->first()->id,
                ],
                [
                    'title' => 'Forum Rules and Guidelines',
                    'content' => 'Please be respectful to other users. No spam, offensive content, or advertisements are allowed.',
                    'user_id' => $users->first()->id,
                ],
            ];
            
            foreach ($posts as $post) {
                Post::create($post);
            }
        }
        
        // Create additional random posts only if we have fewer than 15 total posts
        if (Post::count() < 15) {
            foreach ($users as $user) {
                $postsCount = rand(0, 3);  // Each user creates 0-3 posts
                
                Post::factory($postsCount)->create([
                    'user_id' => $user->id,
                ]);
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
