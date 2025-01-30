<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileListViewer extends Component
{
    public $title;
    public $files;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $files)
    {
        $this->title = $title;
        $this->files = $files;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('partials.components.file-list-viewer');
    }
}
