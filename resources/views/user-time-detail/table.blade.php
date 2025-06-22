    {{-- {{dd($list_data['to'])}} --}}
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="text-center whitespace-nowrap" width="15%">วันที่</th>
                <th class="text-center whitespace-nowrap">กะการทำงาน</th>
                <th class="text-center whitespace-nowrap" width="10%">เข้า</th>
                <th class="text-center whitespace-nowrap" width="10%">สาย</th>
                <th class="text-center whitespace-nowrap" width="10%">ออก</th>
                <th class="text-center whitespace-nowrap" width="10%">ล่วงเวลา</th>
                {{-- <th class="text-center whitespace-nowrap">ดำเนินการ</th> --}}
            </tr>
        </thead>
        <tbody>
        @if(count($list_data) > 0)
            @foreach ($list_data as $row)
                <tr class="intro-x">
                    <td class="text-center">{{ @$row->day_date_thai_text }}</td>
                    <td class="text-center">{{ date('H:i', strtotime($row->user->work_shift->from_time)).' - '.date('H:i', strtotime($row->user->work_shift->to_time)) }} น.</td>
                    <td class="text-center">{{ date('H:i', strtotime($row->day_time_in)) }}</td>
                    <td class="text-center">{!! @$row->late !!}</td>
                    <td class="text-center">{{ date('H:i', strtotime($row->day_time_out)) }}</td>
                    <td class="text-center">{!! @$row->ot !!}</td>
                </tr>
            @endforeach
        @else
                <tr class="intro-x">
                    <th colspan="10" class="text-center">ไม่พบข้อมูล</th>
                </tr>
        @endif
        </tbody>
    </table>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
@include('layout/pagination')
        