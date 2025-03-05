<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FitmNewsCard extends Component
{
    /**
     * The news item.
     *
     * @var object
     */
    public $item;

    /**
     * Whether the card is displayed in mobile view.
     *
     * @var bool
     */
    public $isMobile;

    /**
     * Create a new component instance.
     *
     * @param  object  $item
     * @param  bool  $isMobile
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
        return view('components.fitm-news-card');
    }
}
