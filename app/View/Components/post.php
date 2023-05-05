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
        $settings_enabled,
        $has_image,
        $image_description,
        $is_edit_post;
    /**
     * Create a new component instance.
     */
    public function __construct($id, $isEditPost)
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
        $this->settings_enabled = False;
        $this->has_image = ($post->image != null);
        $this->image_description = $post->image_description;
        $this->is_edit_post = $isEditPost;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post');
    }
}
