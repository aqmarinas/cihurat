<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $count;
    public $title;
    public $description;

    public function __construct($count, $title, $description)
    {
        $this->count = $count;
        $this->title = $title;
        $this->description = $description;
    }

    public function render()
    {
        return view('client.components.card');
    }
}
