<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Models\Follow;
use App\Models\Reply;
use App\Events\NewFollow;
use App\Events\NewLike;
use App\Events\NewReply;

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
    $follow = Follow::where('follower', Auth::id())->get();
    $followed_users_ids = [];

    foreach ($follow as $f) {
        array_push($followed_users_ids, $f->followee);
    }

    // TODO: complete home with posts from followed people.

    $raw_posts = Post::where('author_id', )->random(20);
    $posts = [];

    foreach ($raw_posts as $rp) {
        array_push($posts, $rp->id);
    }

    return view('home', [
        'showPublish' => true,
        'isEditPost' => false,
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
})->middleware(['auth', 'verified'])->name('like.get');

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
    NewLike::dispatch(Auth::user(), Post::where('id', $post_id)->first());

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
    $raw_posts = Post::where('author_id', $profile_user->id)->orderByDesc('created_at')->take(20)->get();
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
        'settings_enabled' => ($id == $viewing_user_id),
        'isEditPost' => false,
    ]);
})->middleware(['auth', 'verified'])->name('profile');

Route::get('/profile', function (Request $req) {
    $id = Auth::id();
    return to_route('profile', ['id' => $id]);
})->middleware(['auth', 'verified'])->name('myprofile');

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

    $follower = User::where('id', $user_id)->first();
    $followee = User::where('id', $followee_id)->first();

    $count = Follow::where('follower', $user_id)->where('followee', $followee_id)->count();
    if ($count > 0) {
        return;
    }
    $follow = new Follow;
    $follow->follower = $user_id;
    $follow->followee = $followee_id;
    $follow->save();

    NewFollow::dispatch($follower, $followee);
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

    NewReply::dispatch(Auth::user(), Post::where('id', $post_id)->first());
})->middleware(['auth', 'verified'])->name('reply');

Route::get('/post/{id}', function(Request $request, string $id) {
    if (Auth::id() === null) {
        return Response('User not logged in', 401);
    }
    if ($id === '') {
        return redirect('home');
    }

    return view('home', [
        'showPublish' => false,
        'posts' => [ intval($id) ],
    ]);
})->middleware(['auth', 'verified'])->name('post');

Route::get('/profile_pic/{id}', function(Request $request, $id){
    if ($id == null) {
        return Response('Image not found', 404);
    }

    $image = User::where("id", $id)->first()->profile_pic_asset;

    if ($image == null) {
        $image = 'profile_pictures/default.svg';
    }

    $response = Storage::response($image);
    $response->headers->set('Cache-Control', 'public, max-age=2628000');

    return $response;
})->middleware(['auth', 'verified'])->name('profile_pic');

Route::get('/notifications', function(Request $request) {
    $notifications = auth()->user()->unreadNotifications;

    return view('notifications', [
        'unread' => $notifications,
    ]);
})->middleware(['auth', 'verified'])->name('notifications');

Route::post('/notifications/mark-as-read/{id}', function(Request $request, $id) {
    if ($id == 'all'){
        auth()->user()->unreadNotifications->markAsRead();
    } else {
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
    }
    return redirect('notifications');
})->middleware(['auth', 'verified'])->name('mark_notifications');

Route::get('/notification/{id}', function(Request $request, $id){
    if (Auth::user()->unreadNotifications->where('id', $id)->count() == 0) {
        return abort(404);
    }
    $notification = Notification::where('id', $id)->first();
    $notification->markAsRead();
    $notification->save();

    switch ($notification) {
        case '\App\Notifications\NewFollow':
            return redirect('profile', $notification->data->follower);
        case '\App\Notifications\NewLike':
            return redirect('post', $notification->data->post_id);
        case '\App\notifications\NewReply':
            return redirect('post', $notification->data->post_id);
        default:
            return redirect('home');
    }
})->middleware(['auth', 'verified'])->name('view-notification');

Route::get('/search', function(Request $request) {
    $results = null;

    if($query = $request->get('query')){
        $results = User::search($query)->paginate(8);
    }

    return view('search', ['query' => $query, 'results' => $results]);
})->middleware(['auth', 'verified'])->name('search');

Route::get('/followers/{id}', function(Request $request, $id) {
    $follows = Follow::where('followee', $id)->get();
    $followers = [];

    foreach($follows as $f) {
        array_push($followers, User::where('id', $f->follower)->first());
    }

    $user = User::where('id', $id)->first();

    return view('followers', [
        'user' => $user,
        'followers' => $followers,
    ]);
})->middleware(['auth', 'verified'])->name('followers');

Route::get('/following/{id}', function(Request $request, $id) {
    $followees = Follow::where('follower', $id)->get();
    $following = [];

    foreach($followees as $f) {
        array_push($following, User::where('id', $f->followee)->first());
    }

    $user = User::where('id', $id)->first();
    return view('following', [
        'user' => $user,
        'following' => $following,
    ]);

})->middleware(['auth', 'verified'])->name('following');

Route::post('/post', function(Request $request) {
    $userId = Auth::id();

    $post = new Post();
    $post->author_id = $userId;

    if (!$request->has('content')) {
        return Response("Error, missing content", 401);
    }

    $post->content = $request->content;

    if ($request->has('image_upload')) {
        if (!$request->has('image_description')) {
            return Response("Error, missing image description", 401);
        }
        if ($request->has('image_description') && $request->image_description == '') {
            return Response("Error, image description can't be empty", 401);
        }
        $file = $request->file('image_upload')->store('images');
        $post->image = $file;
        $post->image_description = $request->image_description;
    }

    $post->save();

    return redirect()->route('profile', $userId);
})->middleware(['auth', 'verified'])->name('create-post');

Route::get('post/image/{post_id}', function(Request $request, $post_id) {
    if ($post_id == null) {
        return Response('Image not found', 404);
    }

    $image = Post::where("id", $post_id)->first()->image;

    $response = Storage::response($image);
    $response->headers->set('Cache-Control', 'public, max-age=2628000');

    return $response;
})->middleware(['auth', 'verified'])->name('post-image');

Route::get('/edit-post/{id}', function (Request $request, $id) {
    $post = Post::where('id', $id)->first();
    if ($post == null) {
        return abort(404);
    }
    if ($post->author_id != Auth::id()) {
        return abort(401);
    }

    return view('home', [
        'showPublish' => false,
        'isEditPost' => true,
        'posts' => [ $post->id ],
    ]);
})->middleware(['auth', 'verified'])->name('edit-post');

Route::post('/edit-post/{id}', function (Request $request, $id) {
    $post = Post::where('id', $id)->first();
    if ($post == null) {
        return abort(404);
    }
    if ($post->author_id != Auth::id()) {
        return abort(401);
    }

    if (!$request->has('content')) {
        return Response('Errore: post vuoto.');
    }

    $post->content = $request->content;
    $post->save();

    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('edit-post');

Route::get('/delete-post/{id}', function(Request $request, $id) {
    $post = Post::where('id', $id)->first();
    if ($post == null) {
        return abort(404);
    }
    if ($post->author_id != Auth::id()) {
        return abort(401);
    }

    $post->delete();

    return redirect()->route('profile', Auth::id());
})->middleware(['auth', 'verified'])->name('delete-post');

Route::middleware('auth')->group(function () {
    Route::get('/account', [ProfileController::class, 'edit'])->name('account.edit');
    Route::post('/account', [ProfileController::class, 'update'])->name('account.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');
});

require __DIR__.'/auth.php';
