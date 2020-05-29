<div>
    <div>{{$company->symbol}} ({{$company->name}})</div>
    <div>
        <label for="previous_year">Previous year</label>
        <input wire:model="previous_year" type="number" />
    </div>
    <div>
        <label for="previous_quarter">Previous quarter</label>
        <input wire:model="previous_quarter" type="number" />
    </div>
    <div>
        <label for="current_quarter">Current quarter</label>
        <input wire:model="current_quarter" type="number" />
    </div>
    <div>
        <label for="earning_per_share">Earning per share</label>
        <input wire:model="earning_per_share" type="number" />
    </div>
</div>