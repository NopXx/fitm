<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NewsCard extends Component
{
    public $item;
    public $isMobile;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $isMobile = false)
    {
        $this->item = $item;
        $this->isMobile = $isMobile;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.news-card');
    }
}
