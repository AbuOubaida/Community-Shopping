@if(count($data))
    <option value="0">--Select Option--</option>
    <option value="all">All Options</option>
    @foreach($data as $d)
        <option value="{{$d->name}}">{{$d->name}}</option>
    @endforeach
@endif
