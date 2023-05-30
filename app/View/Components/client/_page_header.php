<?php

namespace App\View\Components\client;

use Illuminate\View\Component;

class _page_header extends Component
{
    public $pageInfo;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pageInfo)
    {
        $this->pageInfo = $pageInfo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.client._page_header');
    }
}
