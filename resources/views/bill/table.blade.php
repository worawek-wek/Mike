<div class="tab-pane fade show" id="pills-home" role="tabpanel"
aria-labelledby="pills-home-tab" tabindex="0">
    <div class="card card-body shadow-none" style="padding: 10px;line-height: 5px;">
        <div class="row g-3 new_box" style="padding: 0px 30px;">
            {{-- @foreach ($list_data as $row)
            <div class="col-md-6 col-lg5" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#invoice" onclick="view({{ $row->id }})">
                <div class="card bg-label-{{ $row->status->color }} card-check shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="text-{{ $row->status->color }} ti {{ $row->status->icon }} ti-md me-2"></i><b>{{ $row->room_name }}</b></h5>
                        <div class="text-{{ $row->status->color }} h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                            {{ number_format($row->rent+$row->electricity_amount+$row->water_amount) }} บาท
                        </div>
                    </div>
                </div>
            </div>
            @endforeach --}}
        </div>
    </div>
</div>
<div class="tab-pane fade show" id="pills-profile" role="tabpanel"
aria-labelledby="pills-profile-tab" tabindex="0">
    <table class="datatables-basic table dataTable no-footer dtr-column"
        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
        <thead class="border-top">
            <tr class=" table-info">
                <th class="control sorting_disabled dtr-hidden" rowspan="1"
                    colspan="1" style="width: 0px; display: none;"
                    aria-label=""></th>
                <th class="sorting_disabled dt-checkboxes-cell dt-checkboxes-select-all"
                    rowspan="1" colspan="1" style="width: 18px;"
                    data-col="1" aria-label="">
                    <input id="checkAll" type="checkbox" class="form-check-input"></th>
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
        @foreach ($list_data as $key => $row_2)
            <tr class="odd" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#invoice" onclick="view({{ $row_2->id }},'table')">
                <td class="control" tabindex="0" style="display: none;">
                </td>
                <td class="  dt-checkboxes-cell">
                    {{ $loop->iteration + (($list_data->currentPage() - 1) * $list_data->perPage()) }}
                <td class="text-center">{{ $row_2->room_name }}</td>
                <td class="text-center"><span class="text-truncate">{{ $row_2->prefix.' '.$row_2->renter_name }}</span>
                </td>
                <td class="text-center">
                    <span class="text-truncate">
                        {{-- @if($row_2->total > 0)
                            {{ number_format($row_2->rent+$row_2->electricity_amount+$row_2->water_amount) }}
                        @else
                            {{ number_format($row_2->total) }}
                        @endif --}}
                        {{
                            number_format($row_2->total_amount)
                        }}
                         {{-- // total_amount ไม่ใช่ collomn ใน database แต่มาจาก Function ใน Model payment_list(), getTotalAmountAttribute() --}}
                    </span>
                    @if (count(@$row_2->receipt) > 0 & $row_2->ref_status_id == 7)
                        <br><span class="text-truncate text-success">จ่ายแล้ว {{ $row_2->receipt->pluck('payment_list')->flatten()->sum('price') }}</span>
                        <br><span class="text-truncate text-danger">ค้างจ่าย {{ number_format($row_2->total_amount - $row_2->receipt->pluck('payment_list')->flatten()->sum('price')) }}</span>
                    @endif
                </td>
                <td class="text-center">
                    @if (count(@$row_2->receipt) > 0 & $row_2->ref_status_id == 7)
                        <span class="badge bg-danger py-1" aria-expanded="false" text-capitalized="" style="font-size: unset;">
                        <i class="ti ti-mail ti-md me-2"></i>
                        ค้างชำระ</span>
                    @else
                        <span class="badge bg-{{ $row_2->status->color }} py-1" aria-expanded="false" text-capitalized="" style="font-size: unset;">
                            <i class="{{ $row_2->status->icon }} me-2" style="font-size: 20px;"></i>
                            {{ $row_2->status->name }}</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-inline-block text-nowrap">
                        {{-- <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                            <i class="ti ti-edit ti-md" style="color:#6f6b7d !important;"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                        </button> --}}
                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light">
                            <i class="ti ti-printer ti-md" style="color:#6f6b7d !important;"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('layout/pagination')
</div>
<script>
    $('#checkAll').change(function() {
        $('.check-list-td').prop('checked', this.checked);
    });
    $('.check-list-td').on('change', function() {
        // ตรวจสอบสถานะของ checkbox ทั้งหมดที่มี class="check-list-td"
        const totalCheckboxes = $('.check-list-td').length;
        const checkedCheckboxes = $('.check-list-td:checked').length;

        // ถ้าทุก checkbox ถูกเลือก ให้เลือก checkAll
        $('#checkAll').prop('checked', checkedCheckboxes === totalCheckboxes);

        // ถ้าไม่มี checkbox ที่ถูกเลือกเลย จะทำให้ checkAll ถูกยกเลิก
        if (checkedCheckboxes === 0) {
            $('#checkAll').prop('checked', false);
        }
    });
</script>