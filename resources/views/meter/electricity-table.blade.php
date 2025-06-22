    @php
        $monthNames = [
                        '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
                        '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
                        '09' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
                    ];
    @endphp
    <table class="datatables-basic table dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_danger">
        <thead class="border-top">
            <tr class="table-danger">
                <th class="text-center" tabindex="0" style="width: 40px;">
                    ห้อง
                </th>
                <th class="text-center">
                    สถานะห้อง
                </th>
                <th class="text-center">
                    เลขมิเตอร์เดือน<br>({{ $monthNames[$month_previous].'/'.$year_previous }})</th>
                <th class="text-center">
                    เลขมิเตอร์เดือน<br>({{ $monthNames[$search_month].'/'.$search_year }})</th>
                <th class="text-center">
                    หน่วยที่ใช้
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_data as $key => $row)
            <tr>
                <td class="text-center">
                    {{ $row->name }}
                </td>
                <td class="text-center">
                    
                @if($row->status == 1 && count($row->room_for_rent->rent_bill_not_pay) > 0)
                    <span class="badge bg-info m-auto" style="font-size: small;" text-capitalized="">ห้องจอง<span class="text-danger">(ค้างชำระ)</span></span></td>
                @else
                    <span class="badge bg-label-{{ $row->room_status->color }} m-auto" text-capitalized="" style="font-size: small;">
                        {{ $row->room_status->name }}
                    </span>
                @endif
                </td>
                <td class="text-center">
                    {{ $row->meterPrevious->electricity_unit }}
                </td>
                <td class="text-end">
                    <span class="badge rounded-pill bg-label-danger text-black" text-capitalized="" style="font-size: unset;display: block;" >
                        <span class="ti ti-plug me-2"></span>
                        {{ intval($row->electricity_unit) }}
                    </span>
                    
                </td>
                <td class="text-center text-danger">
                    {{ intval($row->electricity_unit) - $row->meterPrevious->electricity_unit }}
                </td>
            </tr>
            @endforeach
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
                        <a class="page-link" href="javascript:void(0)" onclick='loadElectricityData("{{ $list_data->url(1) }}")'>First</a>
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
                            <a class="page-link" href="javascript:void(0)" onclick='loadElectricityData("{{ $list_data->url($i) }}")'>{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- เพิ่มการแสดงเลขหน้าสุดท้าย -->
                    @if ($to < $list_data->lastPage())
                        <li class="px-2 pe-1 mt-4">
                            ...
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick='loadElectricityData("{{ $list_data->url($list_data->lastPage()) }}")'>{{ $list_data->lastPage() }}</a>
                        </li>
                    @endif

                    <!-- ปุ่ม Last -->
                    <li class="page-item {{ ($list_data->currentPage() == $list_data->lastPage()) ? ' disabled' : '' }}">
                        <a class="page-link" href="javascript:void(0)" onclick='loadElectricityData("{{ $list_data->url($list_data->lastPage()) }}")'>Last</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>

        