{{-- @if(isset($selected_buildings))
    <input type="hidden" id="check_selected" value="1">
    @foreach ($selected_buildings as $key => $s_building)
        <div class="">
            <span class="mb-1 h5" style="color: #4f00d2;">{{ $buildings[$key] }}</span>
        </div>
        @foreach ($s_building as $key2 => $s_floor)
            <div class="ms-3">
                <span class="mb-2 h6" style="color: #c66300;">{{ $floors[$key2] }}</span>
            </div>
                <div class="ms-4 mt-1">
                    @foreach ($s_floor as $key3 => $s_room)
                        <span class="mb-0 h6" style="color: black;">{{ $rooms[$s_room] }}</span> &nbsp; &nbsp;
                    @endforeach
                </div>
        @endforeach
        <hr>
    @endforeach
@else
<input type="hidden" id="check_selected" value="0">
<h5 class="text-warning">! โปรดเลือกห้องเช่า</h5>
@endif --}}
@if(isset($structure['buildings']))

@foreach ($structure['buildings'] as $buildingId => $floorsData)
    <div>
        <strong style="color: purple;">{{ $buildings[$buildingId] ?? 'ตึก ' . $buildingId }}</strong>
        @foreach ($floorsData as $floorId => $roomIds)
            <div style="color: orange;">{{ $floors[$floorId] ?? $floorId }}</div>
            <div style="margin-left: 10px;">
                @foreach ($roomIds as $roomId)
                    <b> {{ $rooms[$roomId] ?? 'ห้อง ' . $roomId }} &nbsp;</b>
                @endforeach
            </div>
        @endforeach
        <hr>
    </div>
@endforeach

@else
<input type="hidden" id="check_selected" value="0">
<h5 class="text-warning">! โปรดเลือกห้องเช่า</h5>
@endif