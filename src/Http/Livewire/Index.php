<?php

namespace Cafesource\Option\Http\Livewire;

use Livewire\Component;

class Index extends Component
{
    public $icon = "far fa-cogs";
    public $title;
    public $breadcrumb;

    public function mount()
    {
        $this->title      = __('Settings');
        $this->breadcrumb = [
            ['title' => __('Dashboard'), 'route' => route('admin.index')],
            ['title' => __('Settings')],
        ];
    }

    public function render()
    {
        return view('option::index')->layout('admin::master');
    }
}