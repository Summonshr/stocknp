<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Report extends Component
{

    public $previous_year;

    public $previous_quarter;

    public $current_quarter;

    public $earning_per_share;

    public $company;

    public $report;

    public function updated()
    {
        $this->report->save();
    }

    public function mount()
    {
        $this->company = \App\Company::whereSymbol(request('company'))->first();
        $this->report = $this->company->report;
        $this->previous_quarter = $this->report->previous_quarter;
        $this->current_quarter = $this->report->current_quarter;
        $this->earning_per_share = $this->report->earning_per_share;
        $this->previous_year = $this->report->previous_year;
    }

    public function updatedPreviousYear($value)
    {
        $this->report->previous_year = $value;
    }

    public function updatedPreviousQuarter($value)
    {
        $this->report->previous_quarter = $value;
    }

    public function updatedCurrentQuarter($value)
    {
        $this->report->current_quarter = $value;
    }

    public function updatedEarningPerShare($value)
    {
        $this->report->earning_per_share = $value;
    }

    public function render()
    {
        return view('livewire.report');
    }
}
