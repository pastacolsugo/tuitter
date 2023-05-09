<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use \App\Models\User;

class Notification extends Component
{
    public User $user;
    /**
     * Create a new component instance.
     */
    public function __construct(public $dataa, public $date, public $type, public $id)
    {
        $this->user = User::where('id', $dataa['user_id'])->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notification');
    }
}
