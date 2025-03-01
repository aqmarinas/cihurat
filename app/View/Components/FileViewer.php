<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileViewer extends Component
{
    public $title;
    public $file;
    public $route;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $file, $route)
    {
        $this->title = $title;
        $this->file = $file;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('partials.components.file-viewer');
    }
}
