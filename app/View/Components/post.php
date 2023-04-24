<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class post extends Component
{
    public $author, $date, $content;
    /**
     * Create a new component instance.
     */
    public function __construct($author, $date, $content)
    {
        $this->author = $author;
        $this->date = $date;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post');
    }
}
