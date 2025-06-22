@extends('../layout/' . $layout)

@section('subhead')
    <title>ลา</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-12">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">ลา</h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview">
                    @foreach ($leave as $lea)
                        
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" onclick="la('{{$lea->leave_name}}',{{$lea->id}})">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                                {!! $lea->icon !!}
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success tooltip cursor-pointer" style="padding-right: 7px" title="คุณลาไปแล้ว {{$leave_remaining[$lea->id]}} วัน">
                                                {{ $leave_remaining[$lea->id] .' / '. $lbu[$lea->id]." วัน"}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6"> </div>
                                    {{-- <div class="text-3xl font-medium leading-8 mt-6">4.710</div> --}}
                                    <div class="text-base text-slate-500 mt-1">{{ $lea->leave_name }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-8">
                {{-- ////////// --}}
                <div class="mt-3 ml-3 2xl:mt-0">
                    <select name="ref_leave_id" onchange="loadDataLeave(this.value)" data-search="true" class="tom-select w-full p_search">
                            <option value="0" hidden> &nbsp;เลือกประเภทการลา&nbsp; </option>
                        @foreach ($leave as $lea2)
                            <option @if($lea2->id == @$_GET['ref_leave_id']) selected @endif value="{{$lea2->id}}"> &nbsp;{{$lea2->leave_name}}  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</option>
                        @endforeach
                    </select>
                </div>
            </div>
        <div id="table-data" class="intro-y col-span-12 overflow-auto lg:overflow-visible">
 
            
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
                                @if($row->type_time == "day")
                                    @if($row->from_date == $row->to_date)
                                        {{ date("d/m/Y", strtotime($row->from_date)) }}
                                    @else
                                        {{ date("d/m/Y", strtotime($row->from_date)).' - '.date("d/m/Y", strtotime($row->to_date)) }}
                                    @endif
                                @else
                                    {{ date("H:i", strtotime($row->from_time)).' - '.date("H:i", strtotime($row->to_time)) }}
                                    <br>
                                    {{date("d/m/Y", strtotime($row->from_date))}}
                                @endif
                            </td>
                            <td class="text-center text-{{ $row->boss_status->color }}">
                            {{ $row->boss_status->status_name }}
                            </td>
                            <td class="text-center text-{{ $row->status->color }}">
                            {{ $row->status->status_name }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
</div>


<div id="large-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"><div class="modal-body">
            <form action="{{url('/leave')}}" autocomplete="off" enctype="multipart/form-data" id="formLeave" method="POST">
                @csrf
                <h5 class="mb-1">ยื่นลา</h5>
                <div class="marked">
                    <div class="form-group">
                        <input type="hidden" id="la_id" class="form-control" readonly="" name="ref_leave_id" value="2">
                        <input type="text" id="la" class="form-control" readonly="" name="subject_leave_show" value="ลาป่วย">
                        
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleTextarea">เหตุผลการลา</label>
                        <textarea class="form-control mt-2" id="detail" name="detail" rows="3" required></textarea>
                    </div>
                </div>
                
                <div class="row" id="form-other-none" style="display:block">
                    <div class="col-12">
                        <div class="form-group" style="margin-bottom:40px">
                            <label>รูปแบบการลา</label>
                            <ul class="type-leave-ul">
                                <li id="type-half">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="type_time" class="custom-control-input" id="day" value="day" checked>
                                        <label class="custom-control-label" for="day"> &nbsp;วัน</label>
                                    </div>
                                    <div>
                                        <input name="from_date" type="text" data-daterange="true" class="datepicker form-control w-56 block mx-auto">
                                    </div>
                                </li>
                                <li id="type-full">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="type_time" class="custom-control-input" id="time" value="time">
                                        <label class="custom-control-label" for="time"> &nbsp;ชั่วโมง</label>
                                    </div>
                                    <div class="mt-3">
                                        <div class="relative mb-3">
                                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input type="text" class="datepicker form-control pl-12" name="date_leave" id="update-profile-form-3" placeholder="วันที่ลา" data-single-mode="true">
                                        </div>
                                        <input name="from_time" type="time" value="{{$work_shift->from_time}}">
                                        <input name="to_time" type="time" value="{{$work_shift->to_time}}">
                                    </div>

                                </li>

                            </ul>


                        </div>
                    </div>

                </div>

                <div class="input-file-doc">
                    <label for="exampleTextarea">เอกสาร</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file_name" id="validatedCustomFile">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-20 mt-6">Save</button>

                {{-- <div class="row button">
                    <div class="col-6 padding-rightca">
                        <div class="cancel" data-dismiss="modal" a="" href="#">ยกเลิก</div>
                    </div>
                                                                                            </div> --}}
            </form>
        </div>
        </div>
    </div>
</div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="button" data-tw-dismiss="modal" onclick="confirmDelete()" class="btn btn-danger w-24">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
@endsection

@section('script')
<script>
    function la(la,la_id){
        $("#la").val(la);
        $("#la_id").val(la_id);
        let leave_not_time = [3,4,5,6];
        if (leave_not_time.includes(la_id)) {
            $("#type-full").css('display','none');
        } else {
            $("#type-full").css('display','block');
        }
    }
    function loadDataLeave(v){
        window.location.replace("{{$page_url}}?ref_leave_id="+v);
    }
    // $(document).ready(function(){
    //     $('#formLeave').submit(function(event) {
    //         event.preventDefault(); // ป้องกันการ submit ฟอร์มแบบธรรมดา
    //         // return alert();
    //         var FLData = $(this).serialize();
    //         $(this).submit();
    //         console.log(FLData);
    //                 // $.ajax({
    //                 //     type: "DELETE",
    //                 //     url: "{{url('/leave')}}",
    //                 //     data: FLData,
    //                 //     success: function(data) {
    //                 //         // $('#delete-confirmation-modal').modal('hide');
    //                 //         loadData(page);
    //                 //     }
    //                 // });
    //     });
    // });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
        var page = "{{$page_url}}/datatable";
        // loadData(page);
        function loadData(page){
            $.ajax({
                type: "GET",
                url: page,
                data: {
                },
                success: function(data) {
                    $("#table-data").html(data);
                }
            });
        }
        let DeleteId = 10;
        function Delete(id){
            DeleteId = id;
            // console.log(DeleteId);
        }
        function confirmDelete(){
            $.ajax({
                type: "DELETE",
                url: "{{$page_url}}/"+DeleteId,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    // $('#delete-confirmation-modal').modal('hide');
                    loadData(page);
                }
            });

        }


</script>

@endsection