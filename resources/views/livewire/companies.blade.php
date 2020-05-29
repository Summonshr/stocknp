<div>
    <table>
        <thead>
            <tr>
                <td><input placeholder="name" wire:model="search"></td>
                <td><select wire:model="sector">
                        @foreach($sectors as $sector)
                        <option value="{{$sector}}">
                            {{$sector}}
                        </option>
                        @endforeach
                    </select></td>
                <td><select wire:model="type">
                        @foreach($types as $type)
                        <option value="{{$type}}">
                            {{$type}}
                        </option>
                        @endforeach
                    </select></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
            <tr>
                <td title="{{$company->name}}"><a href="{{route('company', $company->symbol)}}">{{$company->symbol}}</a></td>
                <td>{{$company->sector_name}}</td>
                <td>{{$company->type}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $companies->links() }}
</div>