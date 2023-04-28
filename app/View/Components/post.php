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
        $author_id,
        $date,
        $content,
        $profilePictureAsset,
        $liked,
        $settings_enabled;
    /**
     * Create a new component instance.
     */
    public function __construct($id, $settings)
    {
        $this->post_id = $id;
        $post = \App\Models\Post::where('id', $id)->take(1)->get()[0];
        if ($post == null) {
            return null;
        }

        $author = User::where('id', $post->author_id)->take(1)->get()[0];
        $this->author_username = $author->username;
        $this->author_name = $author->name;
        $this->author_id = $author->id;
        $this->date = $post->created_at->toDateTimeString();
        $this->content = $post->content;
        $this->profilePictureAsset = $author->profile_pic_asset;
        $this->liked = False;
        $this->settings_enabled = false;
        if ($settings != null) {
            $this->settings_enabled = $settings;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post');
    }
}
