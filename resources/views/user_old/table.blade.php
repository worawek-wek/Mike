    {{-- {{dd($list_data['to'])}} --}}
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="whitespace-nowrap" width="1%">รหัส</th>
                <th class="whitespace-nowrap">รูปภาพ</th>
                <th class="whitespace-nowrap">ชื่อ-นามสกุล</th>
                <th class="whitespace-nowrap">หัวหน้างาน</th>
                <th class="text-center whitespace-nowrap">ตำแหน่ง</th>
                <th class="text-center whitespace-nowrap">สาขา</th>
                @if (Auth::user()->ref_position_id == 1)
                    <th class="text-center whitespace-nowrap">ดำเนินการ</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($list_data as $row)
                <tr class="intro-x">
                    <td class="w-40">
                        {{ @$row->employee_id }}
                    </td>
                    <td class="w-40">
                        <div class="flex">
                            <div class="w-10 h-10 image-fit zoom-in">
                                <img data-action="zoom" alt="View picture" class="tooltip rounded-full" @if(!empty($row->image_name)) src="{{ asset('upload/user/' . $row->image_name) }}" @else src="{{asset('dist/images/user-index.png')}}" @endif>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="/profile/{{ $row->id }}" class="block"><span class="font-medium whitespace-nowrap" style="font-size: 17px">{{ $row->name }}
                            @if (!empty($row->nickname))
                            ({{$row->nickname}})
                            @endif
                        </span>
                        <br>
                        <span class="whitespace-nowrap">{{ $row->email }}</span></a>
                    </td>
                    <td>{{ @$row->user->name }}</td>
                    <td class="text-center">{{ @$row->position->position_name }}</td>
                    <td class="w-60 text-center">
                        {{ @$row->branch->branch_name }}
                        {{-- {!! iconv_substr($row->address, 0, 30, "UTF-8") !!}
                        @if (strlen($row->address) > 30)... @endif --}}
                    </td>
                    @if (Auth::user()->ref_position_id == 1)
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a class="flex items-center mr-3" href="{{$page_url}}/{{$row->id}}/edit">
                                <i class="fa fa-pen"></i>&nbsp; แก้ไข

                            </a>
                            <a class="flex items-center text-danger" href="javascript:;" onclick='Delete({{$row->id}})' data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal">
                                <i class="fa fa-trash" aria-hidden="true"></i>&nbsp; ลบ
                            </a>
                        </div>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
@include('layout/pagination')
        