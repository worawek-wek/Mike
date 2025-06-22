    {{-- {{dd($list_data['to'])}} --}}
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="text-center whitespace-nowrap">รายละเอียด</th>
                <th class="whitespace-nowrap" width="1%">รูปภาพ</th>
                <th class="whitespace-nowrap">ชื่อ-นามสกุล</th>
                <th class="text-center whitespace-nowrap">ตำแหน่ง</th>
                <th class="text-center whitespace-nowrap">สาขา</th>
                <th class="text-center whitespace-nowrap">สาย</th>
                <th class="text-center whitespace-nowrap">ล่วงเวลา</th>
                <th class="text-center whitespace-nowrap">กะการทำงาน</th>
                {{-- <th class="text-center whitespace-nowrap">ดำเนินการ</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($list_data as $row)
                <tr class="intro-x">
                    <td class="text-center"><a href="/user-time/{{ $row->id }}" class="block"><i class="fa fa-eye" aria-hidden="true"></i><br>ดูรายละเอียด</a></td>
                    <td class="w-40">
                        <div class="flex">
                            <div class="w-10 h-10 image-fit zoom-in">
                                <img data-action="zoom" alt="View picture" class="tooltip rounded-full" @if(!empty($row->image_name)) src="{{ asset('upload/user/' . $row->image_name) }}" @else src="{{asset('dist/images/user-index.png')}}" @endif>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap" style="font-size: 17px">{{ $row->name }} @if(!empty($row->nickname)) ({{$row->nickname}})@endif</span>
                        <br>
                        <span class="whitespace-nowrap">{{ $row->email }}</span>
                    </td>
                    <td class="text-center">{{ @$row->position->position_name }}</td>
                    <td class="w-60 text-center">
                        {{ @$row->branch->branch_name }}
                        {{-- {!! iconv_substr($row->address, 0, 30, "UTF-8") !!}
                        @if (strlen($row->address) > 30)... @endif --}}
                    </td>
                    <td class="text-center">{!! @$row->late !!}</td>
                    <td class="text-center">{!! @$row->ot !!}</td>
                    <td class="text-center">{{ date('H:i', strtotime($row->work_shift->from_time)).' - '.date('H:i', strtotime($row->work_shift->to_time)) }} น.</td>
                </tr>
            @endforeach
        </tbody>
    </table>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
@include('layout/pagination')
        