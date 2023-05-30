<thead>
    <tr>
        <th>No</th>
        <th>Location</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Action</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th>No</th>
        <th>Location</th>
        <th>Type</th>
        <th>Amount</th>
        <th>Action</th>
    </tr>
</tfoot>
<tbody>
@if(count($data))
    @php
        $i = 1;
    @endphp
    @foreach($data as $d)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$d->location_name}}</td>
            <td>@if($d->location_type == 1) {{'Country'}} @elseif($d->location_type == 2) {{"Division"}}@elseif($d->location_type == 3) {{"District"}}@elseif($d->location_type == 4) {{"Upazila"}}@elseif($d->location_type == 5){{"Union"}}@else {{"Unknown"}} @endif</td>
            <td>{{$d->amount}}</td>
            <td></td>
        </tr>
    @endforeach
@endif
</tbody>

