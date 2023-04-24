<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $raw_posts = Post::all()->random(10);
    $posts = [];
    foreach ($raw_posts as $p) {
        $author = User::where('id', $p->author_id)->take(1)->get()[0]->username;
        $post = array(
            'author'=>$author,
            'content'=>$p->content,
            'date'=>$p->created_at->toDateTimeString(),
        );
        array_push($posts, $post);
    }

    return view('home', [
        'posts' => $posts,
    ]);
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
