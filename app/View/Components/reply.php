<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Models\Follow;

class Reply extends Component
{
    public $author_username, $author_name, $author_id, $post_id, $reply_id, $author_profile_picture_asset, $date, $content;
    /**
     * Create a new component instance.
     */
    public function __construct($reply)
    {
        $this->reply_id = $reply['id'];
        $this->date = $reply['created_at'];
        $this->author_id = $reply['author_id'];
        $this->content = $reply['content'];

        $author = User::where('id', $this->author_id)->take(1)->get()[0];
        $this->author_profile_picture_asset = $author->profile_pic_asset;
        $this->author_username = $author->username;
        $this->author_name = $author->name;
        $this->post_id = 'post_id not set in reply component constructor';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reply');
    }
}
