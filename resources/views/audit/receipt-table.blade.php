    @php
        $monthNames = [
                        '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
                        '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
                        '09' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
                    ];
        $type = [ 3 => "ค่าจองห้อง", 2 => "ค่าเงินประกันห้อง", 1 => "ค่าเช่ารายเดือน", 4 => "ย้ายออก(ใบเสร็จย้ายออก)", 5 => "หนี้สูญ", 6 => "คืนเงินประกัน(ย้ายออก)", 7 => "ใบย้ายออก(สรุป)"]

    @endphp
    <table class="datatables-basic table dataTable no-footer dtr-column"
        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
        <thead class="border-top">
            <tr class=" table-info">
                <th class="sorting_disabled receipt-dt-checkboxes-cell-t receipt-dt-checkboxes-select-all-t"
                    rowspan="1" colspan="1" style="width: 0px;"
                    data-col="1" aria-label="">
                    <input id="checkAll-T" type="checkbox" class="form-check-input">
                </th>
                <th class="text-center" tabindex="0" style="width: 40px;">
                    วันที่
                </th>
                <th class="text-center">
                    เลขที่เอกสาร
                </th>
                <th class="text-center">
                    ประเภท
                </th>
                <th class="text-center">
                    ห้อง
                </th>
                <th class="text-center">
                    ชื่อลูกค้า
                </th>
                <th class="text-center">
                    รวม
                </th>
                <th class="text-center">
                    ภาษีมูลค่าเพิ่ม
                </th>
                <th class="text-center">
                    รวมสุทธิ
                </th>
                {{-- <th class="text-center">
                    สถานะ
                </th> --}}
                <th class="text-center">
                    รูปภาพ
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($list_data as $key => $row)
            <tr class="odd">
                <td class="receipt-dt-checkboxes-cell-t">
                    {{-- @if ($row_2->ref_status_id == 2) --}}
                        <input type="checkbox" class="dt-checkboxes form-check-input ids_receipt" id="check-table-{{ $row->id }}" value="{{ $row->id }}">
                    {{-- @endif --}}
                </td>
                <td class="text-center">
                    {{ date('d/m/Y', strtotime($row->created_at)) }}
                </td>
                <td class="text-center d-write">
                    <a href="javascript:void(0)" class="btn btn-label-success waves-effect" onclick="printPdfReceipt({{$row->id}})">
                        <span class="ti-sm ti ti-printer me-2"></span>{{ $row->receipt_number }}
                    </a>
                </td>
                <td class="text-center">
                    {{ $type[$row->ref_type_id] }}
                </td>
                <td class="text-center">
                    {{ $row->room_name }}
                </td>
                <td class="text-center">
                    {{ $row->prefix.' '.$row->renter_name }}
                </td>
                <td class="text-center">
                    {{ number_format($row->total_amount) }}
                </td>
                <td class="text-center">
                    0
                </td>
                <td class="text-center">
                    {{ number_format($row->total_amount) }}
                </td>
                {{-- <td class="text-center text-danger">
                    @if (count(@$row->receipt) > 0 & $row->ref_status_id == 3)
                        <span class="text-danger py-1">
                        ค้างชำระ</span>
                    @else
                        <span class="text-{{ $row->status->color }} py-1">{{ $row->status->name }}</span>
                    @endif
                </td> --}}
                <td class="text-center">
                    @if ($row->evidence_of_money_transfer)
                        <a href="javascript:void(0)" data-bs-toggle="modal"
                            data-bs-target="#imageShow_{{ @$key }}">ดูรูปภาพ</a>

                        <div class="modal fade" id="imageShow_{{@$key}}" tabindex="-1" aria-labelledby="imageShow_{{@$key}}Label"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img src="{{ url('/upload/receipt/'.$row->evidence_of_money_transfer) }}" class="img-fluid rounded" alt="รูปภาพ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
    
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
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
                        <a class="page-link" href="javascript:void(0)" onclick='loadReceiptData("{{ $list_data->url(1) }}")'>First</a>
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
                            <a class="page-link" href="javascript:void(0)" onclick='loadReceiptData("{{ $list_data->url($i) }}")'>{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- เพิ่มการแสดงเลขหน้าสุดท้าย -->
                    @if ($to < $list_data->lastPage())
                        <li class="px-2 pe-1 mt-4">
                            ...
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick='loadReceiptData("{{ $list_data->url($list_data->lastPage()) }}")'>{{ $list_data->lastPage() }}</a>
                        </li>
                    @endif

                    <!-- ปุ่ม Last -->
                    <li class="page-item {{ ($list_data->currentPage() == $list_data->lastPage()) ? ' disabled' : '' }}">
                        <a class="page-link" href="javascript:void(0)" onclick='loadReceiptData("{{ $list_data->url($list_data->lastPage()) }}")'>Last</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        // เมื่อคลิกที่ checkbox ใน <th>
        $('.receipt-dt-checkboxes-select-all-t input[type="checkbox"]').on('change', function () {
            // ตรวจสอบสถานะของ checkbox ใน <th>
            var isChecked = $(this).prop('checked');
            
            // ทำให้ checkbox ทุกอันใน <td> ถูกเช็คหรือยกเลิกการเช็ค
            $('td.receipt-dt-checkboxes-cell-t input[type="checkbox"]').prop('checked', isChecked);
            receiptCheckNoCheckedT();
        });

        // เมื่อคลิกที่ checkbox ใน <td> (ตรวจสอบสถานะของทุก checkbox)
        $('td.receipt-dt-checkboxes-cell-t input[type="checkbox"]').on('change', function () {
            // ตรวจสอบว่า checkbox ใน <td> ถูกเช็คหรือไม่
            var allChecked = $('td.receipt-dt-checkboxes-cell-t input[type="checkbox"]').length === $('td.receipt-dt-checkboxes-cell-t input[type="checkbox"]:checked').length;
            
            // ถ้าทุก checkbox ใน <td> ถูกเช็ค จะทำให้ checkbox ใน <th> ถูกเช็ค
            $('.receipt-dt-checkboxes-select-all-t input[type="checkbox"]').prop('checked', allChecked);
            receiptCheckNoCheckedT();
        });
        
    });
    receiptCheckNoCheckedT();
    // function floorCheckedT() {
    //     $('.receipt-dt-checkboxes-select-all-t input[type="checkbox"]').prop('checked', true);
    //         $('td.receipt-dt-checkboxes-cell-t input[type="checkbox"]').prop('checked', true);
    //         receiptCheckNoCheckedT();
    //     // });
    // }
    function receiptCheckNoCheckedT() {
        if ($('td.receipt-dt-checkboxes-cell-t input[type="checkbox"]:checked').length === 0) {
        // ทำให้ปุ่มถูก disabled
            $('#edit-rent').prop('disabled', true);
        } else {
            // ถ้ามี checkbox ถูกเช็ค ให้เปิดใช้งานปุ่ม
            $('#edit-rent').prop('disabled', false);
        }
    }
</script>