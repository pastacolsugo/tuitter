<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use \App\Models\User;
use \App\Models\Follow;
use \App\Models\Like;
use \App\Models\Reply;
use \App\Models\Post;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('account.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request) {
        $user = User::where('id', Auth::id())->first();

        $user->name = $request->name;
        $user->bio = $request->bio;

        if ($user->bio == null) {
            $user->bio = '';
        }

        $file = $request->file('image_upload');

        if ($request->hasFile('image_upload')) {
            $file = $request->file('image_upload')->store('profile_pictures');
            $user->profile_pic_asset = $file;
        }

        $user->save();

        return Redirect::route('account.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Follow::where('follower', $user->id)->delete();
        Follow::where('followee', $user->id)->delete();
        Reply::where('author_id', $user->id)->delete();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
