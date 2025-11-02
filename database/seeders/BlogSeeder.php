<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🧑‍💼 Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@blog.com',
            'role' => 'admin', // ✅ added
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // 👤 Create regular user
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'rs@gmail.com',
            'role' => 'user', // ✅ added
            'password' => bcrypt('rs123456'),
            'email_verified_at' => now(),
        ]);

        // 🏷️ Create categories
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Latest technology news and insights'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle', 'description' => 'Lifestyle tips and advice'],
            ['name' => 'Travel', 'slug' => 'travel', 'description' => 'Travel guides and experiences'],
            ['name' => 'Food', 'slug' => 'food', 'description' => 'Delicious recipes and food reviews'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // 📝 Create posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel',
                'slug' => 'getting-started-with-laravel',
                'excerpt' => 'Learn the basics of Laravel framework and how to build amazing web applications.',
                'content' => '<p>Laravel is a powerful PHP framework that makes web development enjoyable and creative...</p>',
                'status' => 'published',
                'user_id' => $admin->id,
                'category_id' => Category::where('name', 'Technology')->first()->id,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Healthy Living Tips',
                'slug' => 'healthy-living-tips',
                'excerpt' => 'Simple and effective tips for maintaining a healthy lifestyle in today\'s busy world.',
                'content' => '<p>Maintaining a healthy lifestyle doesn\'t have to be complicated...</p>',
                'status' => 'published',
                'user_id' => $user->id,
                'category_id' => Category::where('name', 'Lifestyle')->first()->id,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Best Travel Destinations for 2024',
                'slug' => 'best-travel-destinations-2024',
                'excerpt' => 'Discover the most amazing travel destinations to visit in 2024.',
                'content' => '<p>2024 is shaping up to be an exciting year for travel enthusiasts...</p>',
                'status' => 'published',
                'user_id' => $admin->id,
                'category_id' => Category::where('name', 'Travel')->first()->id,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Delicious Homemade Pizza Recipe',
                'slug' => 'delicious-homemade-pizza-recipe',
                'excerpt' => 'Learn how to make the perfect homemade pizza with this easy-to-follow recipe.',
                'content' => '<p>Making pizza at home is easier than you might think...</p>',
                'status' => 'published',
                'user_id' => $user->id,
                'category_id' => Category::where('name', 'Food')->first()->id,
                'published_at' => now()->subHours(6),
            ],
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }

        // 💬 Create some comments
        $posts = Post::all();
        $comments = [
            [
                'content' => 'Great article! Very informative and well-written.',
                'author_name' => 'Sarah Johnson',
                'author_email' => 'sarah@example.com',
                'status' => 'approved',
            ],
            [
                'content' => 'Thanks for sharing these tips. I found them very helpful.',
                'author_name' => 'Mike Wilson',
                'author_email' => 'mike@example.com',
                'status' => 'approved',
            ],
            [
                'content' => 'I have a question about the implementation. Can you provide more details?',
                'author_name' => 'Alex Brown',
                'author_email' => 'alex@example.com',
                'status' => 'pending',
            ],
        ];

        foreach ($posts as $index => $post) {
            if (isset($comments[$index])) {
                Comment::create([
                    'content' => $comments[$index]['content'],
                    'author_name' => $comments[$index]['author_name'],
                    'author_email' => $comments[$index]['author_email'],
                    'status' => $comments[$index]['status'],
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}
