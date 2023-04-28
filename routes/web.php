<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Models\Follow;
use App\Models\Reply;

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

    if ($like_count === 0) {
        return Response('not liked', 200);
    }
    return Response('liked', 200);
});

Route::post('/like', function(Request $request) {
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

Route::get('/profile/{id}', function (Request $req, string $id) {
    $count = User::where('id', $id)->count();
    if ($count === 0) {
        abort(404);
    }
    $profile_user = User::where('id', $id)->get();
    $profile_user = $profile_user[0];
    $viewing_user_id = Auth::id();
    $raw_posts = Post::where('author_id', $profile_user->id)->take(20)->get();
    $post_ids = [];
    foreach ($raw_posts as $rp) {
        array_push($post_ids, $rp->id);
    }

    $followers = Follow::where('followee', $profile_user->id)->count();
    $following = Follow::where('follower', $profile_user->id)->count();
    $viewingUserIsFollowing = Follow::where('follower', $viewing_user_id)->where('followee', $profile_user->id)->count() === 1;

    return view('profile', [
        'username' => $profile_user->username,
        'name' => $profile_user->name,
        'profile_id' => $profile_user->id,
        'bio' => $profile_user->bio,
        'profilePictureAsset' => $profile_user->profile_pic_asset,
        'followers' => $followers,
        'following' => $following,
        'viewingUserIsFollowing' => $viewingUserIsFollowing,
        'posts' => $post_ids,
    ]);
})->middleware(['auth', 'verified'])->name('profile');

Route::get('/follow', function(Request $request) {
    if (Auth::id() === null) {
        return Response('User not logged in', 401);
    }
    if (!$request->has('followee_id')){
        return Response('Missing `followee_id` parameter', 422);
    }

    $user_id = Auth::id();
    $followee_id = $request->followee_id;

    $isFollowing = Follow::where('follower', $user_id)->where('followee', $followee_id)->count() > 0;
    if ($isFollowing) {
        return Response('following', 200);
    }
    return Response('not following', 200);
})->middleware(['auth', 'verified'])->name('follow.get');

Route::post('/follow', function(Request $request) {
    if (Auth::id() === null) {
        return Response('User not logged in', 401);
    }
    if (!$request->has('followee_id')){
        return Response('Missing `followee_id` parameter', 422);
    }
    $user_id = Auth::id();
    $followee_id = $request->followee_id;

    $count = Follow::where('follower', $user_id)->where('followee', $followee_id)->count();
    if ($count > 0) {
        return;
    }
    $follow = new Follow;
    $follow->follower = $user_id;
    $follow->followee = $followee_id;
    $follow->save();

    return;
})->middleware(['auth', 'verified'])->name('follow.post');

Route::post('/unfollow', function(Request $request) {
    if (Auth::id() === null) {
        return Response('User not logged in', 401);
    }
    if (!$request->has('followee_id')){
        return Response('Missing `followee_id` parameter', 422);
    }
    $user_id = Auth::id();
    $followee_id = $request->followee_id;

    Follow::where('follower', $user_id)->where('followee', $followee_id)->delete();

    return;
})->middleware(['auth', 'verified'])->name('follow.post');

Route::get('/replies', function(Request $request) {
    if (Auth::id() === null) {
        return Response('User not logged in', 401);
    }
    if (!$request->has('post_id')){
        return Response('Missing `post_id` parameter', 422);
    }
    $user_id = Auth::id();
    $user_profile_picture_asset = User::where('id', $user_id)->take(1)->get()[0]->profile_pic_asset;
    $post_id = $request->post_id;

    $replies = Reply::where('post_id', $post_id)->get()->toArray();

    return view('replies', [
        'replies' => $replies,
        'post_id' => $post_id,
        'profile_pic' => $user_profile_picture_asset,
    ]);
})->middleware(['auth', 'verified'])->name('replies');

Route::post('/reply', function(Request $request) {
    if (Auth::id() === null) {
        return Response('User not logged in', 401);
    }
    $user_id = Auth::id();
    $body = json_decode($request->getContent());
    $post_id = $body->postID;
    $content = $body->reply;

    $reply = new Reply();
    $reply->post_id = $post_id;
    $reply->author_id = $user_id;
    $reply->content = $content;
    $reply->save();
})->middleware(['auth', 'verified'])->name('reply');

Route::get('/post/{id}', function(Request $request, string $id) {
    if (Auth::id() === null) {
        return Response('User not logged in', 401);
    }
    if ($id === '') {
        return redirect('home');
    }

    return view('home', [
        'posts' => [ intval($id) ],
    ]);
})->middleware(['auth', 'verified'])->name('post');

Route::get('/letest', function(Request $req) {
    return view('letest');
})->middleware(['auth', 'verified'])->name('letest');

Route::middleware('auth')->group(function () {
    Route::get('/account', [ProfileController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [ProfileController::class, 'update'])->name('account.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');
});

require __DIR__.'/auth.php';
