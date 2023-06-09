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
            <td>
                <a href="{{route('edit.shipping.charge',['ID'=>\Illuminate\Support\Facades\Crypt::encryptString($d->id)])}}" class="text-success" title="Edit" onclick="return confirm('Are you sure update this data!')"><i class="fas fa-edit"></i></a>
                <form action="{{route('delete.shipping')}}" method="post" class="d-inline-block">
                    {!! method_field('delete') !!}
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{\Illuminate\Support\Facades\Crypt::encryptString($d->id)}}">
                    <button title="Delete" class="btn-style-none d-inline-block text-danger" onclick="return confirm('Are you sure delete this data? Because this data is permanently delete on database.')" type="submit"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
    @endforeach
@endif
</tbody>

