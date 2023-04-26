<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;

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
    $raw_posts = Post::all()->random(20);
    $posts = [];
    foreach ($raw_posts as $rp) {
        array_push($posts, $rp->id);
    }
    // foreach ($raw_posts as $p) {
    //     $user = User::where('id', $p->author_id)->take(1)->get()[0];
    //     $profile_picture_asset = $user->profile_pic_asset;
    //     $author = $user->username;
    //     $post = array(
    //         'author' => $author,
    //         'content' => $p->content,
    //         'date' => $p->created_at->toDateTimeString(),
    //         'profilepictureasset' => $profile_picture_asset,
    //     );
    //     array_push($posts, $post);
    // }

    return view('home', [
        'posts' => $posts,
    ]);
})->middleware(['auth', 'verified'])->name('home');

Route::get('/like', function(Request $request) {
    if (Auth::id() === null) {
        return Response('User not logged in', 401);
    }
    if (!$request->has('post_id')){
        return Response('Missing `post_id` parameter', 422);
    }
    $user_id = Auth::id();
    $post_id = $request->post_id;

    $like_count = Like::where('user_id', $user_id)->where('post_id', $post_id)->count();

    if ($like_count > 0) {
        $likes = Like::where('user_id', $user_id)->where('post_id', $post_id)->get();
        foreach ($likes as $like) {
            $like->delete();
        }
        return Response('unliked', 200);
    }

    $like = new Like;
    $like->post_id = $post_id;
    $like->user_id = $user_id;
    $like->save();
    return Response('liked', 200);
})->middleware(['auth', 'verified'])->name('like');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
