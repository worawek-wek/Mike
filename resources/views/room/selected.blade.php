@if(isset($structure['buildings']))
    @foreach ($structure['buildings'] as $buildingId => $floorsData)
        <input type="hidden" id="checkHasRoom" value="1">
        <div>
            <strong style="color: purple;">{{ $buildings[$buildingId] ?? 'ตึก ' . $buildingId }}</strong>
            @foreach ($floorsData as $floorId => $roomIds)
                <div style="color: orange;">{{ $floors[$floorId] ?? $floorId }}</div>
                <div style="margin-left: 10px;">
                    @foreach ($roomIds as $roomId)
                        <b> {{ $rooms[$roomId] ?? 'ห้อง ' . $roomId }} &nbsp;</b>
                        <input type="hidden" class="date_data">
                {{-- <div style="margin-left: 10px;">
                    <label for="bs-datepicker-format2" class="form-label">วันที่เข้าพัก</label>
                    <input type="text" name="booking_date" value="24/04/2025" class="form-control" id="bs-datepicker-format2" placeholder="วัน/เดือน/ปี" required value="24/04/2025"/>
                </div>
                <div class="mt-2" style="margin-left: 10px;">
                    <label for="bs-datepicker-format2" class="form-label">วันที่สิ้นสุดสัญญา</label>
                    <input type="text" name="booking_date" value="24/04/2025" class="form-control" id="bs-datepicker-format2" placeholder="วัน/เดือน/ปี" required value="24/04/2025"/>
                </div>
                <div class="mb-4 mt-2" style="margin-left: 10px;">
                    <label for="bs-datepicker-format2" class="form-label">วันที่แจ้งเตือนล่วงหน้า</label>
                    <input type="text" name="booking_date" value="24/04/2025" class="form-control" id="bs-datepicker-format2" placeholder="วัน/เดือน/ปี" required value="24/04/2025"/>
                </div> --}}
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