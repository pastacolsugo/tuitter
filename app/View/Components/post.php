<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;
use App\Models\Like;

class Post extends Component
{
    public $post_id,
        $author_username,
        $author_name,
        $date,
        $content,
        $profilePictureAsset,
        $liked;
    /**
     * Create a new component instance.
     */
    public function __construct($id)
    {
        $this->post_id = $id;
        $post = \App\Models\Post::where('id', $id)->take(1)->get()[0];
        if ($post == null) {
            return null;
        }
        $user = User::where('id', $post->author_id)->take(1)->get()[0];
        $liked_count = Like::where('user_id', $user->id)->where('post_id', $id)->count();
        $this->liked = $liked_count > 0;
        $this->author_username = $user->username;
        $this->author_name = $user->name;
        $this->date = $post->created_at->toDateTimeString();
        $this->content = $post->content;
        $this->profilePictureAsset = $user->profile_pic_asset;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post');
    }
}
