<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();
        
        foreach ($posts as $post) {
            $commentsCount = rand(0, 5);  // Add 0-5 comments to each post
            
            for ($i = 0; $i < $commentsCount; $i++) {
                $user = $users->random();
                
                // Create the comment
                $comment = Comment::create([
                    'content' => fake()->paragraph(),
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ]);
                
                // Add some replies (20% chance)
                if (rand(1, 5) == 1) {
                    $replyCount = rand(1, 3);
                    
                    for ($j = 0; $j < $replyCount; $j++) {
                        $replyUser = $users->random();
                        
                        Comment::create([
                            'content' => fake()->paragraph(),
                            'post_id' => $post->id,
                            'user_id' => $replyUser->id,
                            'parent_id' => $comment->id,
                        ]);
                    }
                }
            }
        }
    }
}
