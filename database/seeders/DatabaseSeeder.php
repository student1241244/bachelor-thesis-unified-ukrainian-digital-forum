<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Packages\Threads\App\Models\Thread;
use Packages\Threads\App\Models\Comment as ThreadsComments;
use Packages\Questions\App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'test',
            'avatar' => null,
            'email' => 'test@test.com',
            'email_verified_at' => null,
            'password' => bcrypt('test'),
            'remember_token' => null,
            'is_admin' => 0,
            'role_id' => 2,
            'bonus_points' => 10,
        ]);

        User::factory(10)->create();

        Setting::factory()->create([
            'setting_name' => 'user_registration_enabled',
            'setting_status' => 'on'
        ]);
        
        Setting::factory()->create([
            'setting_name' => 'content_creation_enabled',
            'setting_status' => 'on'
        ]);
        
        Setting::factory()->create([
            'setting_name' => 'backup_frequency',
            'setting_status' => 'daily'
        ]);

        $categoryTitles = ['General', 'Programmers', 'Hackers', 'Study'];
        foreach ($categoryTitles as $title) {
            Category::create(['title' => $title]);
        }

        Question::factory(20)->create()->each(function ($question) {
            Comment::factory(rand(5, 15))->create(['question_id' => $question->id]);
        });

        $categoryTitles = ['Cars' , 'Business' , 'Books' , 'Comics' , 'Science' , 'Crypto' , 'Programmers' , 'Sport' , 'History' , 'Films' , 'Music' , 'Animals' , 'Space' , 'Education' , 'Design' , 'Photography' , 'Job' , 'Artificial Intelligence' , 'Computers' , 'Games'];
        foreach ($categoryTitles as $title) {
            Category::create(['title' => $title]);
        }

        // \Packages\Threads\App\Models\Thread::factory(20)->create();
        Thread::factory(20)->create()->each(function ($thread) {
            ThreadsComments::factory(rand(5, 15))->create(['thread_id' => $thread->id]);
        });
    }
}
