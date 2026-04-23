@php
    $permission_bill = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 22)->where('status', 1)->first();
@endphp
<div class="tab-pane fade show" id="pills-home" role="tabpanel"
aria-labelledby="pills-home-tab" tabindex="0">
    <div class="card card-body shadow-none" style="padding: 10px;line-height: 5px;">
        <div class="row g-3 new_box" style="padding: 0px 30px;">
            @foreach ($list_data as $row)
            <div class="col-md-6 col-lg5" @if($permission_bill) style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#invoice" onclick="view({{ $row->id }},'table')" @endif>
                <div class="card bg-label-{{ $row->status->color }} card-check shadow-sm" style="height: 155.5px;">
                    <div class="card-body d-flex flex-column justify-content-center text-center p-3">
                        <h4 class="card-title mb-0 mb-2"><i class="text-{{ $row->status->color }} {{ $row->status->icon }} me-2"></i><b>{{ $row->room_name }}</b></h4>
                        <div class="text-{{ $row->status->color }} h4 text-center" style="margin-top: 0;margin-bottom: 0;">
                            {{
                                number_format($row->total_amount)
                            }}
                            บาท
                            {{-- // total_amount ไม่ใช่ collomn ใน database แต่มาจาก Function ใน Model payment_list(), getTotalAmountAttribute() --}}
                            @if (count($row->receipt ?? []) > 0 & $row->ref_status_id != 5)
                                <br><span class="text-truncate badge rounded-pill text-black mt-1" style="background-color: white;">จ่ายแล้ว &nbsp;{{ number_format($row->total_paid_including_fine) }} บาท</span>
                                @if ($row->total_paid_including_fine < $row->total_amount)
                                    <br><span class="text-truncate badge rounded-pill bg-danger">ค้างจ่าย &nbsp;{{ number_format($row->total_amount - $row->receipt->sum(function ($r) { return $r->total_amount; })) }}</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<input type="hidden" id="allIds" value="{{ $allIds }}">
<div class="tab-pane fade show" id="pills-profile" role="tabpanel"
aria-labelledby="pills-profile-tab" tabindex="0">
    <table class="datatables-basic table dataTable no-footer dtr-column"
        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
        <thead class="border-top">
            <tr class=" table-info">
                <th class="sorting_disabled dt-checkboxes-cell-t dt-checkboxes-select-all-t"
                    rowspan="1" colspan="1" style="width: 0px;"
                    data-col="1" aria-label="">
                    <input id="checkAll-T" type="checkbox" class="form-check-input">
                </th>
                <th class="control sorting_disabled dtr-hidden" rowspan="1"
                    colspan="1" style="width: 0px;"
                    aria-label="">
                    #
                </th>
                <th class="text-center" tabindex="0" style="width: 40px;">
                    ห้อง
                </th>
                <th class="text-center">
                    ผู้เช่า
                </th>
                <th class="text-center">
                    จำนวนเงินรวม
                </th>
                <th class="text-center">
                    สถานะบิล
                </th>
                <th class="text-center">
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
        @forelse ($list_data as $key => $row_2)
        @php
        $click = '';
            if($permission_bill){
                $click = "style='cursor: pointer' data-bs-toggle='modal' data-bs-target='#invoice' onclick='view({$row_2->id}, \"table\")'";
            }
        @endphp
            <tr class="odd">
                <td class="control" tabindex="0" style="display: none;">
                </td>
                <td class="dt-checkboxes-cell-t">
                    {{-- @if ($row_2->ref_status_id == 2) --}}
                        <input type="checkbox" class="dt-checkboxes form-check-input ids_invoice" id="check-table-{{ $row_2->id }}" value="{{ $row_2->id }}">
                    {{-- @endif --}}
                </td>
                <td class="dt-checkboxes-cell-t" {{ $click }}>
                    {{ $loop->iteration + (($list_data->currentPage() - 1) * $list_data->perPage()) }}
                <td class="text-center" {!! $click !!}>{{ $row_2->room_name }}</td>
                <td class="text-center" {!! $click !!}><span class="text-truncate">{{ $row_2->prefix.' '.$row_2->renter_name }}</span>
                </td>
                <td class="text-center" {!! $click !!}>
                    <span class="text-truncate">
                        {{-- @if($row_2->total > 0)
                            {{ number_format($row_2->rent+$row_2->electricity_amount+$row_2->water_amount) }}
                        @else
                            {{ number_format($row_2->total) }}
                        @endif --}}
                        {{
                            number_format($row_2->total_amount)
                        }}
                        {{-- {{$row_2->total_fine_amount}} --}}
                         {{-- // total_amount ไม่ใช่ collomn ใน database แต่มาจาก Function ใน Model payment_list(), getTotalAmountAttribute() --}}
                    </span>
                    @if (count($row_2->receipt ?? []) > 0 & $row_2->ref_status_id != 5)
                        <br><span class="text-truncate text-success"> จ่ายแล้ว {{ number_format($row_2->total_paid_including_fine) }}</span>
                        @if ($row_2->total_not_discount_amount < $row_2->total_amount)
                            <br><span class="text-truncate text-danger">ค้างจ่าย {{ number_format($row_2->total_amount - $row_2->receipt->sum(function ($r) { return $r->total_amount; })) }}</span>
                        @endif
                    @endif
                </td>
                <td class="text-center" {!! $click !!}>
                    @if (count(@$row_2->receipt ?? []) > 0 & $row_2->ref_status_id == 7)
                        <span class="badge bg-danger py-1" aria-expanded="false" text-capitalized="" style="font-size: unset;">
                        <i class="ti ti-mail ti-md me-2"></i>
                        ค้างชำระ</span>
                    @else
                        <span class="badge bg-{{ $row_2->status->color }} py-1" aria-expanded="false" text-capitalized="" style="font-size: unset;">
                            <i class="{{ $row_2->status->icon }} me-2" style="font-size: 20px;"></i>
                            {{ $row_2->status->name }}</span>
                    @endif
                </td>
                <td class="text-end px-5">
                    <div class="d-inline-block text-nowrap">
                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light" onclick="printPdf({{ $row_2->id }})">
                            <i class="ti ti-printer ti-md" style="color:#6f6b7d !important;"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty

                <tr>
                    <td colspan="20" class="text-center text-muted py-4">
                        <i class="ti ti-file-search" style="font-size: 24px;"></i><br>
                        ไม่พบข้อมูล
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>
    @include('layout/pagination')
</div>
<script>
    $(document).ready(function () {
        // เมื่อคลิกที่ checkbox ใน <th>
        $('.dt-checkboxes-select-all-t input[type="checkbox"]').on('change', function () {
            // ตรวจสอบสถานะของ checkbox ใน <th>
            var isChecked = $(this).prop('checked');
            
            // ทำให้ checkbox ทุกอันใน <td> ถูกเช็คหรือยกเลิกการเช็ค
            $('td.dt-checkboxes-cell-t input[type="checkbox"]').prop('checked', isChecked);
            checkNoCheckedT();
        });

        // เมื่อคลิกที่ checkbox ใน <td> (ตรวจสอบสถานะของทุก checkbox)
        $('td.dt-checkboxes-cell-t input[type="checkbox"]').on('change', function () {
            // ตรวจสอบว่า checkbox ใน <td> ถูกเช็คหรือไม่
            var allChecked = $('td.dt-checkboxes-cell-t input[type="checkbox"]').length === $('td.dt-checkboxes-cell-t input[type="checkbox"]:checked').length;
            
            // ถ้าทุก checkbox ใน <td> ถูกเช็ค จะทำให้ checkbox ใน <th> ถูกเช็ค
            $('.dt-checkboxes-select-all-t input[type="checkbox"]').prop('checked', allChecked);
            checkNoCheckedT();
        });
        
    });
    checkNoCheckedT();
    function floorCheckedT() {
        $('.dt-checkboxes-select-all-t input[type="checkbox"]').prop('checked', true);
            $('td.dt-checkboxes-cell-t input[type="checkbox"]').prop('checked', true);
            checkNoCheckedT();
        // });
    }
    function checkNoCheckedT() {
        if ($('td.dt-checkboxes-cell-t input[type="checkbox"]:checked').length === 0) {
        // ทำให้ปุ่มถูก disabled
            $('#edit-rent').prop('disabled', true);
        } else {
            // ถ้ามี checkbox ถูกเช็ค ให้เปิดใช้งานปุ่ม
            $('#edit-rent').prop('disabled', false);
        }
    }
</script>