    @php
    $permission_meter_water = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 49)->where('status', 0)->first();

        $monthNames = [
                        '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
                        '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
                        '09' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
                    ];
    @endphp
    <form id="update_meter">
        @csrf
    <table class="datatables-basic table dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
        <thead class="border-top">
            <tr class="table-info">
                <th class="text-center" tabindex="0" style="width: 40px;">
                    ห้อง
                </th>
                <th class="text-center">
                    สถานะห้อง
                </th>
                <th class="text-center">
                    เลขมิเตอร์เดือน<br>({{ $monthNames[$month_previous].'/'.$year_previous }})</th>
                <th class="text-center" width="25%">
                    เลขมิเตอร์เดือน<br>({{ $monthNames[$search_month].'/'.$search_year }})</th>
                <th class="text-center">
                    หน่วยที่ใช้
                </th>
                <th class="text-center">
                    ดำเนินการ
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_data as $key => $row)
                @php
                    $current_month_usage = intval($row->water_unit+$row->meter_before_change-$row->start_value_of_new_meter) - intval($row->meterPrevious->water_unit);
                    $background = '';
                    if($row->status == 0 && $row->move_out_water_meter != $row->water_unit){
                        $background = 'style="background-color: antiquewhite;"';
                    }
                @endphp
            <tr {!! $background !!}>
                <input type="hidden" id="water_unit{{ $row->meters_id }}" value="{{ intval($row->water_unit) }}">
                <td class="text-center">
                    {{ $row->name }}
                </td>
                <td class="text-center">
                @if($row->status == 1 && count($row->room_for_rent->rent_bill_not_pay ?? []) > 0)
                    <span class="badge bg-info m-auto" style="font-size: small;" text-capitalized="">ห้องจอง<span class="text-danger">(ค้างชำระ)</span></span></td>
                @else
                    <span class="badge bg-label-{{ $row->room_status->color }} m-auto" text-capitalized="" style="font-size: small;" >
                        {{ $row->room_status->name }}
                    </span>
                @endif
                </td>
                <td class="text-center">
                    @if ($row->reason_name == '')
                        {{ intval($row->meterPrevious->water_unit) }}<br>
                    @else
                        ({{ (int) $row->meter_before_change }} - {{ (int) $row->meterPrevious->water_unit }}) {{ $row->start_value_of_new_meter }}
                        <i class="fa fa-exclamation-circle text-warning"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{$row->reason_name}}น้ำ">
                        </i>
                    @endif
                </td>
                <td class="text-center">
                    <span class="badge rounded-pill bg-label-info text-black d-flex" text-capitalized="" style="font-size: unset;">
                        <span class="ti ti-droplet me-2 m-auto"></span>
                        <input type="number" name="id_room[]" id="room{{ $row->meters_id }}" class="form-control form-control-sm room{{$key}}"
                            value="{{ intval($row->water_unit) }}" onkeydown="handleInput(event,{{ $row->meters_id }}, this.value, {{ $key }})"
                            oninput="editRoom({{ $row->meters_id }}, this.value, {{ $row->start_value_of_new_meter ?? 0 }}, {{ $row->meter_before_change ?? 0 }}, {{ $row->meterPrevious->water_unit ?? 0 }})" style="background-color: #d6f7fb;border-color: #00bad1;"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            min="{{ $row->water_unit }}"
                            @if ($permission_meter_water)
                                readonly
                            @endif
                            autocomplete="off"
                            >
                    </span>
                    {{-- <div style="padding: inherit;"> --}}
                        {{-- <button type="button" id="updateRoom{{ $row->meters_id }}" class="btn btn-sm btn-secondary" disabled onclick="updateRoom('{{ $row->meters_id }}')">
                            <i class="ti-xs ti ti-pencil me-2"></i>บันทึก
                        </button> --}}
                    {{-- </div> --}}
                </td>
                <td class="text-center text-danger">
                    <span
                    @if ($current_month_usage < 0)
                        class="badge bg-label-danger"
                        style="padding: 15px;"
                    @endif
                     id="current_month_usage_water_{{ $row->meters_id }}"
                    >
                        {{ $current_month_usage }}
                    </span>
                    {{-- {{ intval($row->water_unit+$row->meter_before_change-$row->start_value_of_new_meter) - intval($row->meterPrevious->water_unit) }} --}}
                </td>
                <td class="text-center text-warning">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#change_meter" onclick="changeMeter_form({{ $row->meters_id }},'{{ $row->name }}')">
                        <span>
                            <i class="ti-md ti ti-settings"></i>
                            <b class="dam">เปลี่ยนมิเตอร์</b>
                        </span>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</form>
{{-- ////////////////////////////////////////////// --}}
<div class="row">
    <div class="col-sm-12 col-md-6 ps-4">
        <div class="dataTables_info" id="DataTables_Table_1_info" role="status" aria-live="polite">
            All &nbsp; {{$list_data->total()}} &nbsp; entries
        </div>
    </div>

    <div class="col-sm-12 col-md-6 pe-4">
        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate">
            @if ($list_data->lastPage() > 1)
                <ul class="pagination">
                    <!-- ปุ่ม First -->
                    <li class="page-item {{ ($list_data->currentPage() == 1) ? ' disabled' : '' }}">
                        <a class="page-link" href="javascript:void(0)" onclick='loadWaterData("{{ $list_data->url(1) }}")'>First</a>
                    </li>

                    <?php
                        // จำนวนหน้าที่ย่อ (ตัวอย่างนี้แสดงแค่ 8 หน้า)
                        $total_links = 9;  // เปลี่ยนจาก 5 เป็น 9
                        $half_total_links = floor($total_links / 2);
                        $from = $list_data->currentPage() - $half_total_links;
                        $to = $list_data->currentPage() + $half_total_links;

                        // แก้ไขการคำนวณจากหน้าแรกหรือหน้าสุดท้าย
                        if ($list_data->currentPage() < $half_total_links) {
                            $to += $half_total_links - $list_data->currentPage();
                        }
                        if ($list_data->lastPage() - $list_data->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($list_data->lastPage() - $list_data->currentPage()) - 1;
                        }

                        // กำหนดให้ค่าของ $from และ $to ไม่ให้ต่ำกว่า 1 หรือมากกว่าหน้าสุดท้าย
                        $from = max($from, 1);
                        $to = min($to, $list_data->lastPage());
                    ?>

                    <!-- แสดงหน้าที่ในช่วงที่คำนวณ -->
                    @for ($i = $from; $i <= $to; $i++)
                        <li class="page-item {{ ($list_data->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="javascript:void(0)" onclick='loadWaterData("{{ $list_data->url($i) }}")'>{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- เพิ่มการแสดงเลขหน้าสุดท้าย -->
                    @if ($to < $list_data->lastPage())
                        <li class="px-2 pe-1 mt-4">
                            ...
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick='loadWaterData("{{ $list_data->url($list_data->lastPage()) }}")'>{{ $list_data->lastPage() }}</a>
                        </li>
                    @endif

                    <!-- ปุ่ม Last -->
                    <li class="page-item {{ ($list_data->currentPage() == $list_data->lastPage()) ? ' disabled' : '' }}">
                        <a class="page-link" href="javascript:void(0)" onclick='loadWaterData("{{ $list_data->url($list_data->lastPage()) }}")'>Last</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>

{{-- ////////////////////////////////////////////// --}}

<script>
    focus_input_room(0);
    function focus_input_room(id) {
        const input = document.querySelector(".room" + id);
        if (!input) return;

        input.focus();

        // ✅ Trick สำหรับ number input: reset ค่าแล้วคืนกลับ
        const val = input.value;
        input.value = "";
        input.value = val;
        
        // ✅ เลือกข้อความทั้งหมด (เหมือน Ctrl+A)
        input.select();

    }

    function handleInput(event, id, v, k) {
        if (event.key === 'Enter') {
            // ข้ามไป focus ห้องถัดไป
            focus_input_room(1 + k);
        }
    }
    function editRoom(id, v, s, b, p){
        var c = v-s+b-p;
        $('#current_month_usage_water_'+id).html(c);
        // if($('#water_unit' + id).val() != v){
        //     $('#updateRoom' + id).prop('disabled', false);
        //     $('#updateRoom' + id).removeClass('btn-secondary').addClass('btn-success');
        // }else{
        //     $('#updateRoom' + id).prop('disabled', true);
        //     $('#updateRoom' + id).removeClass('btn-success').addClass('btn-secondary');
        // }
    }
    let data = [];
    function updateRoom(){
        var check_min = 0;
        let data = [];
        $('input[name="id_room[]"]').each(function () {
            const id = $(this).attr('id').replace('room', '');
            const value = parseFloat($(this).val()); // แปลงค่าเป็นตัวเลข
            const min = parseFloat($(this).attr('min')) || 0; // ถ้าไม่มี min ให้ถือว่า 0

            // ✅ ตรวจสอบว่า value น้อยกว่า min หรือไม่
            if (value < min) {
                check_min = 1;
                console.warn(`room${id}: ค่าน้อยกว่า min (${value} < ${min})`);
                $(this).addClass('is-invalid'); // เพิ่ม class สำหรับ highlight error
            } else {
                $(this).removeClass('is-invalid');
            }
            // เก็บข้อมูลใน array
            data.push({
                id: id,
                value: value
            });
        });
        
            if(check_min == 1){
                return Swal.fire('พบการกรอก มิเตอร์ ไม่ถูกต้อง', '', 'warning');
            }
            
        $.ajax({
            url: '/meter/water_unit', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
            type: 'POST',
            data: {
                _token : "{{ csrf_token() }}",
                meter: data,
            },
            success: function(response) {
                if(response == true){
                    loadWaterData(water_page)
                    // $('#water_unit' + id).val(response);
                    // $('#updateRoom' + id).prop('disabled', true);
                    // $('#updateRoom' + id).removeClass('btn-success').addClass('btn-secondary');
                    Swal.fire({
                        title: 'แก้ไข มิเตอร์น้ำ เรียบร้อยแล้ว',
                        icon: 'success',
                        timer: 1500, // ตั้งเวลาเป็น 1500 มิลลิวินาที (1.5 วินาที)
                        timerProgressBar: true, 
                        showConfirmButton: false,
                        customClass: {
                            title: 'custom-title', // กำหนดคลาสให้กับ title
                        },
                    });
                }
            },
            error: function(error) {
                Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                console.error('เกิดข้อผิดพลาด:', error);
            }
        });
    }
    var meter_id;
    var room_name;
    function changeMeter_form(p_meter_id, p_room_name){
        meter_id = p_meter_id;
        room_name = p_room_name;
        
        $.ajax({
            type: "GET",
            url: '/meter/get-water-meter-unit/'+p_meter_id,
            success: function(data) {
                $("#meter_before_change").val(data);
            }
        });
    }
    $('#change_meter_form').on('submit', function(event) {
        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
        Swal.fire({
            title: 'ยืนยันการดำเนินการ?',
            text: 'คุณต้องการ เปลี่ยนมิเตอร์ ห้อง '+room_name+' หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            showDenyButton: false,
            didOpen: () => {
                // โฟกัสที่ปุ่ม confirm
                Swal.getConfirmButton().focus();
            }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/meter/change-meter/water/'+meter_id, // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                loadWaterData(water_page)
                                
                                var modalEl = document.getElementById('change_meter');
                                var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                if (modalInstance) {
                                    modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }
                                $('#change_meter_form')[0].reset();
                                $('#defaultRadio1').prop('checked', true);
                                $('#div_reason2').css('display',"none");
                                $('#div_reason1').css('display',"block");
                                Swal.fire({
                                    title: 'เปลี่ยน มิเตอร์น้ำ เรียบร้อยแล้ว',
                                    icon: 'success',
                                    timer: 1500, // ตั้งเวลาเป็น 1500 มิลลิวินาที (1.5 วินาที)
                                    timerProgressBar: true, 
                                    showConfirmButton: false,
                                    customClass: {
                                        title: 'custom-title', // กำหนดคลาสให้กับ title
                                    },
                                });
                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
    });
</script>