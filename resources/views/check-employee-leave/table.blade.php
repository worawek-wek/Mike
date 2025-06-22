
<table class="table table-report -mt-2">
    <thead>
        <tr>
            <th class="whitespace-nowrap">#</th>
            <th class="whitespace-nowrap">ประเภท</th>
            <th class="whitespace-nowrap">ชื่อ - สกุล</th>
            <th class="text-center whitespace-nowrap">สาเหตุ</th>
            <th class="text-center whitespace-nowrap">ไฟล์แนบ</th>
            <th class="text-center whitespace-nowrap">วันที่ลา</th>
            <th class="text-center whitespace-nowrap">สถานะ(หัวหน้า)</th>
            <th class="text-center whitespace-nowrap">สถานะ(ฝ่ายบุคคล)</th>
        </tr>
    </thead>
    <tbody>
        @php
            $num = 1;
        @endphp
        @foreach ($list_data as $row)
            <tr class="intro-x">
                <td>
                    <span>{!! $row->leave->icon !!}</span>
                </td>
                <td>
                    <span>{{@$row->leave->leave_name}}</span>
                </td>
                <td>
                    {{@$row->user->name}}
                </td>
                <td class="text-center">{{$row->detail}}</td>
                <td class="text-center">
                    @if(!empty($row->file_name))
                        <a href="{{ asset('upload/leave/'.$row->file_name) }}">
                            <i class="fa fa-paperclip" aria-hidden="true" style="font-size: 20px"></i>
                        </a>
                    @endif
                </td>
                <td class="text-center">
                    @if($row->from_time == "00:00:00")
                        {{ date("d/m/Y", strtotime($row->from_date)).' - '.date("d/m/Y", strtotime($row->to_date)) }}
                    @else
                        {{ date("H:i", strtotime($row->from_time)).' - '.date("H:i", strtotime($row->to_time)) }}
                        <br>
                        {{date("d/m/Y", strtotime($row->from_date))}}
                    @endif
                </td>
                <td class="text-center text-{{ $row->boss_status->color }}">
                    @if ($row->ref_boss_status_id == 0 && Auth::user()->ref_position_id != 1)
                        
                        <div class="dropdown">
                            <button 
                            @if (Auth::user()->ref_position_id == 1)
                                disabled
                            @endif
                            class="dropdown-toggle btn btn-warning" aria-expanded="false" data-tw-toggle="dropdown" style="color: white;">รออนุมัติ</button>
                            <div class="dropdown-menu w-48">
                                <ul class="dropdown-content" id="dropdown{{$row->id}}">
                                    <li>
                                        <a href="javascript:;" class="dropdown-item text-success " onclick="change_boss_status({{$row->id}},1)">
                                            <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> <span id="loading{{$row->id}}" style="display: none;">กำลังดำเนินการ</span> <span id="approve{{$row->id}}">อนุมัติ</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="dropdown-item text-danger" onclick="change_boss_status({{$row->id}},2)">
                                            <i data-lucide="trash" class="w-4 h-4 mr-2"></i> ไม่อนุมัติ
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    @else
                        @if($row->ref_boss_status_id == 1 && Auth::user()->ref_position_id != 1)
                            @if($row->ref_status_id != 1)
                                <a href="javascript:;" class="dropdown-item text-success" data-tw-toggle="modal" data-tw-target="#change_boss_status-confirmation-modal" onclick="modal_confirm_change_boss_status({{$row->id}},2)">
                                    <i class="fa fa-pen"></i>&nbsp;
                                </a>
                            @endif
                        @endif

                        {{ $row->boss_status->status_name }}
                    @endif

                </td>
                <td class="text-center text-{{ $row->status->color }}">
                    @if ($row->ref_status_id == 0 && Auth::user()->ref_position_id == 3)
                        
                        <div class="dropdown">
                            <button class="dropdown-toggle btn btn-warning" aria-expanded="false" data-tw-toggle="dropdown" style="color: white;"
                                @if ($row->ref_boss_status_id != 1)
                                    disabled
                                @endif
                                >รออนุมัติ
                            </button>
                            <div class="dropdown-menu w-48">
                                <ul class="dropdown-content" id="dropdown{{$row->id}}">
                                    <li>
                                        <a href="javascript:;" class="dropdown-item text-success" onclick="change_status({{$row->id}},1)">
                                            <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> อนุมัติ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="dropdown-item text-danger" onclick="change_status({{$row->id}},2)">
                                            <i data-lucide="trash" class="w-4 h-4 mr-2"></i> ไม่อนุมัติ
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        @if($row->ref_status_id == 1)
                            <a href="javascript:;" class="dropdown-item text-success" data-tw-toggle="modal" data-tw-target="#change_status-confirmation-modal" onclick="modal_confirm_change_status({{$row->id}},2)">
                                <i class="fa fa-pen"></i>&nbsp;
                            </a>
                        @endif

                        {{ $row->status->status_name }}
                    @endif

                </td>
                
            </tr>
        @endforeach
        
    <div id="change_boss_status-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">แน่ใจ?</div>
                        <div class="text-slate-500 mt-2">คุณต้องการเปลี่ยนเป็น สถานะไม่อนุมัติ ?</div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" onclick="change_boss_status('n','n')" class="btn btn-danger w-24">ยืนยัน</button>
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </div><div id="change_status-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">แน่ใจ?</div>
                        <div class="text-slate-500 mt-2">คุณต้องการเปลี่ยนเป็น สถานะไม่อนุมัติ ?</div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" onclick="change_status('n','n')" class="btn btn-danger w-24">ยืนยัน</button>
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </tbody>
</table>
@include('layout/pagination')
