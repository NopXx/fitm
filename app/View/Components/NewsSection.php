<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NewsSection extends Component
{
    public $title;
    public $news;
    public $typeId;
    public $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $news, $typeId, $link = '#')
    {
        $this->title = $title;
        $this->news = $news;
        $this->typeId = $typeId;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.news-section');
    }
}
