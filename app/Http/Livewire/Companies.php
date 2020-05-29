<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Companies extends Component
{
    use WithPagination;

    public $page = 1;

    public $search = '';

    public $type = 'Equity';

    public $sector = 'Commercial Banks';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingSector()
    {
        $this->resetPage();
    }


    public function render()
    {
        return view('livewire.companies', [
            'types' => \App\Company::distinct()->pluck('type'),
            'sectors' => \App\Company::distinct()->pluck('sector_name'),
            'companies' => \App\Company::when($this->search, function ($query) {
                return $query->where(function ($query) {
                    return $query
                        ->where('symbol', 'like', '%' . strtoupper($this->search) . '%')
                        ->orWhere('name', 'like', '%' . strtoupper($this->search) . '%');
                });
            })
                ->where('type', $this->type)
                ->where('sector_name', $this->sector)
                ->paginate()
        ]);
    }
}
