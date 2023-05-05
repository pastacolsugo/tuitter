<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Like;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Signor Test',
            'username' => 'antani',
            'email' => 'test@example.com',
            'password' => '$2y$10$fVwvOInh8ZOj8tSP2o3Z3.Ab6qu0/WvYNUwq7k2Yi0kMFDsg5ZFIW', // 12341234
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        \App\Models\User::factory(20)->create();
        \App\Models\Post::factory(50)->create();
        \App\Models\Follow::factory(50)->create();
        \App\Models\Reply::factory(200)->create();

        \App\Models\Like::factory(100)->create();
        // cleanup possible like dups
        $duplicate_likes = DB::select(DB::raw('select user_id, post_id, count(*) as count_ from likes group by user_id, post_id having count_ > 1')
            ->getValue(DB::connection()->getQueryGrammar()));

        $this->command->info('Deleting duplicate like records');
        foreach ($duplicate_likes as $dl) {
            Like::where('user_id', $dl->user_id)->where('post_id', $dl->post_id)->take($dl->count_)->delete();
        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $imgs_folder = 'database/seeders/imgs/';
        $imgs = [
            'cat_0.jpeg',
            'cat_1.jpeg',
            'cat_2.jpeg',
            'cat_3.jpeg',
            'cat_4.jpeg',
            'cat_5.jpeg',
            'cat_6.jpeg',
            'cat_7.jpeg',
            'default.svg',
            'gumball.jpeg',
            'harold.jpeg',
            'hasbulla.jpeg',
            'leo.jpeg',
            'paperinoh.jpeg',
            'pepe.jpeg',
            'pickachu.jpeg',
            'spongebob.jpeg',
            'will_shrek.jpeg',
        ];

        foreach ($imgs as $img) {
            File::copy($imgs_folder . $img, Storage::path("profile_pictures/" . $img));
        }
    }
}
